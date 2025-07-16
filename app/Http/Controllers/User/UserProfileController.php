<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\FitnessGoal;
use App\Models\ExperienceLevel;
use App\Models\WorkoutType;
use App\Models\WorkoutTemplate;
use App\Models\Allergy;
use App\Models\UserNutritionGoal;
use App\Models\UserWorkoutSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function show()
    {
        $user = Auth::user();
        
        // Load user profile with related data
        $userProfile = $user->userProfile()
            ->with(['fitnessGoal', 'experienceLevel', 'preferredWorkoutType'])
            ->first();
        
        // Get user allergies
        $userAllergies = $user->allergies;
        
        return view('user.profile.show', compact('user', 'userProfile', 'userAllergies'));
    }

    /**
     * Show the edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Load user profile with related data
        $userProfile = $user->userProfile()
            ->with(['fitnessGoal', 'experienceLevel', 'preferredWorkoutType'])
            ->first();
        
        // Get current user allergies
        $userAllergies = $user->allergies;
        
        // Get all available options for dropdowns
        $fitnessGoals = FitnessGoal::all();
        $experienceLevels = ExperienceLevel::all();
        $workoutTypes = WorkoutType::all();
        $allergies = Allergy::all();
        
        return view('user.profile.edit', compact(
            'user', 
            'userProfile', 
            'userAllergies', 
            'fitnessGoals', 
            'experienceLevels', 
            'workoutTypes', 
            'allergies'
        ));
    }

    /**
     * Update the user's profile    
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $userProfile = $user->userProfile;
        
        // Store original values to check for changes
        $originalFitnessGoal = $userProfile->fitness_goal_id;
        $originalExperienceLevel = $userProfile->experience_level_id;
        $originalPreferredWorkoutType = $userProfile->preferred_workout_type_id;
        
        // Validate the request - removed physical stats validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'sex' => 'required|in:Male,Female,Other',
            'fitness_goal_id' => 'required|exists:fitness_goals,id',
            'experience_level_id' => 'required|exists:experience_levels,id',
            'preferred_workout_type_id' => 'required|exists:workout_types,id',
            'allergies' => 'array',
            'allergies.*' => 'exists:allergies,id',
        ]);

        try {
            DB::beginTransaction();
            
            // Update user table
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);
            
            // Update user profile - only editable fields
            $userProfile->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'sex' => $validatedData['sex'],
                'fitness_goal_id' => $validatedData['fitness_goal_id'],
                'experience_level_id' => $validatedData['experience_level_id'],
                'preferred_workout_type_id' => $validatedData['preferred_workout_type_id'],
                'last_profile_update' => Carbon::now(),
            ]);
            
            // Update allergies (sync will remove unchecked and add new ones)
            $user->allergies()->sync($request->input('allergies', []));
            
            // Check if fitness preferences changed and trigger updates
            $fitnessPreferencesChanged = (
                $originalFitnessGoal != $validatedData['fitness_goal_id'] || 
                $originalExperienceLevel != $validatedData['experience_level_id'] || 
                $originalPreferredWorkoutType != $validatedData['preferred_workout_type_id']
            );
            
            if ($fitnessPreferencesChanged) {
                // Recalculate nutrition goals
                $this->updateNutritionGoals($user, $userProfile);
                
                // Update workout schedule
                $this->updateWorkoutSchedule($user, $userProfile);
            }
            
            DB::commit();
            
            return redirect()->route('profile.show')
                ->with('success', 'Profile updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'An error occurred while updating your profile. Please try again.']);
        }
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        return view('user.profile.change-password');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        try {
            // Update password
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('profile.show')
                ->with('success', 'Password updated successfully!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating your password. Please try again.']);
        }
    }

    /**
     * Create or update nutrition goals for the user
     */
    private function updateNutritionGoals($user, $userProfile)
    {
        // Basic BMR calculation using Mifflin-St Jeor equation
        $age = Carbon::parse($userProfile->date_of_birth)->age;
        $heightCm = $userProfile->height_cm;
        $weightKg = $userProfile->current_weight_kg;
        $sex = $userProfile->sex;
        
        if ($sex === 'Male') {
            $bmr = (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age) - 161;
        }
        
        // Apply activity factor (moderate activity)
        $tdee = $bmr * 1.55;
        
        // Adjust based on fitness goal
        $fitnessGoal = $userProfile->fitnessGoal->name;
        if ($fitnessGoal === 'Weight Loss') {
            $targetCalories = $tdee - 500; // 500 calorie deficit
        } else { // Muscle Gain
            $targetCalories = $tdee + 300; // 300 calorie surplus
        }
        
        // Calculate macros (protein: 25%, carbs: 45%, fat: 30%)
        $targetProtein = ($targetCalories * 0.25) / 4; // 4 calories per gram
        $targetCarbs = ($targetCalories * 0.45) / 4;
        $targetFat = ($targetCalories * 0.30) / 9; // 9 calories per gram
        
        // Update or create nutrition goals
        UserNutritionGoal::updateOrCreate(
            ['user_id' => $user->id],
            [
                'target_calories' => round($targetCalories),
                'target_protein_grams' => round($targetProtein),
                'target_carb_grams' => round($targetCarbs),
                'target_fat_grams' => round($targetFat),
                'last_updated' => now(),
            ]
        );
    }

    /**
     * Update workout schedule when fitness preferences change
     */
    private function updateWorkoutSchedule($user, $userProfile)
    {
        // Clear existing scheduled workouts (keep completed ones)
        UserWorkoutSchedule::where('user_id', $user->id)
            ->where('status', 'Scheduled')
            ->where('assigned_date', '>=', now()->toDateString())
            ->delete();

        // Find a suitable workout template randomly from the matching ones
        $workoutTemplate = WorkoutTemplate::where('workout_type_id', $userProfile->preferred_workout_type_id)
            ->where('experience_level_id', $userProfile->experience_level_id)
            ->inRandomOrder() // Adds variety
            ->first();

        if ($workoutTemplate) {
            // A more realistic schedule with rest days (e.g., Day 0, Day 2, Day 4)
            $scheduleDays = [0, 2, 4]; 
            
            foreach ($scheduleDays as $day) {
                UserWorkoutSchedule::create([
                    'user_id'       => $user->id,
                    'template_id'   => $workoutTemplate->id,
                    'assigned_date' => now()->addDays($day)->toDateString(),
                    'status'        => 'Scheduled',
                ]);
            }
        } else {
            // Log a warning if no template is found so you can add one later
            Log::warning('No workout template found for workout_type_id: ' . $userProfile->preferred_workout_type_id . ' and experience_level_id: ' . $userProfile->experience_level_id);
        }
    }

    /**
     * Create nutrition goals for new users (reusable function)
     */
    private function createNutritionGoals($user, $userProfile)
    {
        // Basic BMR calculation using Mifflin-St Jeor equation
        $age = Carbon::parse($userProfile->date_of_birth)->age;
        $heightCm = $userProfile->height_cm;
        $weightKg = $userProfile->current_weight_kg;
        $sex = $userProfile->sex;
        
        if ($sex === 'Male') {
            $bmr = (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age) - 161;
        }
        
        // Apply activity factor (moderate activity)
        $tdee = $bmr * 1.55;
        
        // Adjust based on fitness goal
        $fitnessGoal = $userProfile->fitnessGoal->name;
        if ($fitnessGoal === 'Weight Loss') {
            $targetCalories = $tdee - 500; // 500 calorie deficit
        } else { // Muscle Gain
            $targetCalories = $tdee + 300; // 300 calorie surplus
        }
        
        // Calculate macros (protein: 25%, carbs: 45%, fat: 30%)
        $targetProtein = ($targetCalories * 0.25) / 4; // 4 calories per gram
        $targetCarbs = ($targetCalories * 0.45) / 4;
        $targetFat = ($targetCalories * 0.30) / 9; // 9 calories per gram
        
        UserNutritionGoal::create([
            'user_id' => $user->id,
            'target_calories' => round($targetCalories),
            'target_protein_grams' => round($targetProtein),
            'target_carb_grams' => round($targetCarbs),
            'target_fat_grams' => round($targetFat),
            'last_updated' => now(),
        ]);
    }

    /**
     * Assign initial workout for new users (reusable function)
     */
    private function assignInitialWorkout($user, $userProfile)
    {
        // Find a suitable workout template randomly from the matching ones
        $workoutTemplate = WorkoutTemplate::where('workout_type_id', $userProfile->preferred_workout_type_id)
            ->where('experience_level_id', $userProfile->experience_level_id)
            ->inRandomOrder() // Adds variety
            ->first();
            
        if ($workoutTemplate) {
            // A more realistic schedule with rest days (e.g., Day 0, Day 2, Day 4)
            $scheduleDays = [0, 2, 4]; 
            
            foreach ($scheduleDays as $day) {
                UserWorkoutSchedule::create([
                    'user_id'       => $user->id,
                    'template_id'   => $workoutTemplate->id,
                    'assigned_date' => now()->addDays($day)->toDateString(), // Starts today
                    'status'        => 'Scheduled',
                ]);
            }
        } else {
            // Log a warning if no template is found so you can add one later
            Log::warning('No workout template found for workout_type_id: ' . $userProfile->preferred_workout_type_id . ' and experience_level_id: ' . $userProfile->experience_level_id);
        }
    }
}