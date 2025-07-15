<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\FitnessGoal;
use App\Models\ExperienceLevel;
use App\Models\WorkoutType;
use App\Models\Allergy;
use App\Models\UserNutritionGoal;
use App\Models\UserWorkoutSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        $originalWeight = $userProfile->current_weight_kg;
        $originalFitnessGoal = $userProfile->fitness_goal_id;
        $originalExperienceLevel = $userProfile->experience_level_id;
        
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'sex' => 'required|in:Male,Female,Other',
            'height_cm' => 'required|numeric|between:50,300',
            'current_weight_kg' => 'required|numeric|between:20,500',
            'daily_budget' => 'nullable|numeric|min:0',
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
            
            // Update user profile
            $userProfile->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'sex' => $validatedData['sex'],
                'height_cm' => $validatedData['height_cm'],
                'current_weight_kg' => $validatedData['current_weight_kg'],
                'daily_budget' => $validatedData['daily_budget'],
                'fitness_goal_id' => $validatedData['fitness_goal_id'],
                'experience_level_id' => $validatedData['experience_level_id'],
                'preferred_workout_type_id' => $validatedData['preferred_workout_type_id'],
                'last_profile_update' => Carbon::now(),
            ]);
            
            // Update allergies (sync will remove unchecked and add new ones)
            $user->allergies()->sync($request->input('allergies', []));
            
            // Check if core metrics changed and trigger recalculation
            if ($originalWeight != $validatedData['current_weight_kg'] || 
                $originalFitnessGoal != $validatedData['fitness_goal_id'] || 
                $originalExperienceLevel != $validatedData['experience_level_id']) {
                
                $this->recalculateUserData($user);
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

            // Optional: Log out other sessions for security
            // Auth::logoutOtherDevices($request->new_password);

            return redirect()->route('profile.show')
                ->with('success', 'Password updated successfully!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating your password. Please try again.']);
        }
    }

    /**
     * Recalculate user nutrition goals and potentially workout schedules
     */
    private function recalculateUserData(User $user)
    {
        // This is a placeholder for your nutrition calculation logic
        // You would implement your actual calculation based on the user's profile
        
        $userProfile = $user->userProfile;
        
        // Example calculation (replace with your actual logic)
        $bmr = $this->calculateBMR($userProfile);
        $tdee = $this->calculateTDEE($bmr, $userProfile->experienceLevel->name);
        $calories = $this->adjustCaloriesForGoal($tdee, $userProfile->fitnessGoal->name);
        
        // Update or create nutrition goals
        UserNutritionGoal::updateOrCreate(
            ['user_id' => $user->id],
            [
                'target_calories' => $calories,
                'target_protein_grams' => $this->calculateProtein($userProfile),
                'target_carb_grams' => $this->calculateCarbs($calories),
                'target_fat_grams' => $this->calculateFats($calories),
                'last_updated' => Carbon::now(),
            ]
        );
        
        // You might also want to re-evaluate workout schedules here
        // $this->updateWorkoutSchedules($user);
    }

    /**
     * Calculate BMR (Basal Metabolic Rate)
     */
    private function calculateBMR(UserProfile $profile)
    {
        // Mifflin-St Jeor Equation
        $age = Carbon::parse($profile->date_of_birth)->age;
        
        if ($profile->sex === 'Male') {
            return (10 * $profile->current_weight_kg) + (6.25 * $profile->height_cm) - (5 * $age) + 5;
        } else {
            return (10 * $profile->current_weight_kg) + (6.25 * $profile->height_cm) - (5 * $age) - 161;
        }
    }

    /**
     * Calculate TDEE (Total Daily Energy Expenditure)
     */
    private function calculateTDEE($bmr, $experienceLevel)
    {
        $activityMultipliers = [
            'Beginner' => 1.4,
            'Intermediate' => 1.6,
            'Advanced' => 1.8,
        ];
        
        return $bmr * ($activityMultipliers[$experienceLevel] ?? 1.5);
    }

    /**
     * Adjust calories based on fitness goal
     */
    private function adjustCaloriesForGoal($tdee, $fitnessGoal)
    {
        switch ($fitnessGoal) {
            case 'Weight Loss':
                return $tdee - 500; // 500 calorie deficit
            case 'Muscle Gain':
                return $tdee + 300; // 300 calorie surplus
            default:
                return $tdee;
        }
    }

    /**
     * Calculate protein requirements
     */
    private function calculateProtein(UserProfile $profile)
    {
        // 2g per kg of body weight for muscle gain, 1.6g for weight loss
        $multiplier = $profile->fitnessGoal->name === 'Muscle Gain' ? 2.0 : 1.6;
        return $profile->current_weight_kg * $multiplier;
    }

    /**
     * Calculate carb requirements
     */
    private function calculateCarbs($calories)
    {
        // 40% of calories from carbs
        return ($calories * 0.4) / 4; // 4 calories per gram of carbs
    }

    /**
     * Calculate fat requirements
     */
    private function calculateFats($calories)
    {
        // 30% of calories from fats
        return ($calories * 0.3) / 9; // 9 calories per gram of fat
    }
}
