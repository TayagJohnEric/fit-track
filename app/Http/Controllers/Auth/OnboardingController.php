<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\OnboardingStepOneRequest;
use App\Http\Requests\OnboardingStepTwoRequest;
use App\Http\Requests\OnboardingStepThreeRequest;
use App\Models\Allergy;
use App\Models\ExperienceLevel;
use App\Models\FitnessGoal;
use App\Models\UserNutritionGoal;
use App\Models\UserProfile;
use App\Models\UserWorkoutSchedule;
use App\Models\WeightHistory;
use App\Models\WorkoutTemplate;
use App\Models\WorkoutType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use Carbon\Carbon;
use App\Http\Controllers\Controller; 


class OnboardingController extends Controller
{
    public function checkOnboardingStatus()
    {
        $user = auth()->user();
        
        if ($user->userProfile) {
            return redirect()->route('dashboard');
        }
        
        return redirect()->route('onboarding.welcome');
    }

    public function welcome()
    {
        $user = auth()->user();
        
        // If user already has a profile, redirect to dashboard
        if ($user->userProfile) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.onboarding.welcome');
    }

    public function stepOne()
    {
        return view('auth.onboarding.step1');
    }

    public function storeStepOne(OnboardingStepOneRequest $request)
    {
        $user = auth()->user();
        
        // Store step 1 data in session
        session([
            'onboarding_step1' => $request->validated()
        ]);
        
        return redirect()->route('onboarding.step2');
    }

    public function stepTwo()
    {
        // Ensure step 1 is completed
        if (!session('onboarding_step1')) {
            return redirect()->route('onboarding.step1');
        }

        $fitnessGoals = FitnessGoal::all();
        $experienceLevels = ExperienceLevel::all();
        $workoutTypes = WorkoutType::all();

        return view('auth.onboarding.step2', compact('fitnessGoals', 'experienceLevels', 'workoutTypes'));
    }

    public function storeStepTwo(OnboardingStepTwoRequest $request)
    {
        // Ensure step 1 is completed
        if (!session('onboarding_step1')) {
            return redirect()->route('onboarding.step1');
        }

        // Store step 2 data in session
        session([
            'onboarding_step2' => $request->validated()
        ]);

        return redirect()->route('onboarding.step3');
    }

    public function stepThree()
    {
        // Ensure previous steps are completed
        if (!session('onboarding_step1') || !session('onboarding_step2')) {
            return redirect()->route('onboarding.step1');
        }

        $allergies = Allergy::all();

        return view('auth.onboarding.step3', compact('allergies'));
    }

    public function storeStepThree(OnboardingStepThreeRequest $request)
    {
        // Ensure previous steps are completed
        if (!session('onboarding_step1') || !session('onboarding_step2')) {
            return redirect()->route('onboarding.step1');
        }

        $user = auth()->user();
        
        try {
            DB::beginTransaction();

            // Get all onboarding data
            $step1Data = session('onboarding_step1');
            $step2Data = session('onboarding_step2');
            $step3Data = $request->validated();

            // Create user profile
            $userProfile = UserProfile::create([
                'user_id' => $user->id,
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'date_of_birth' => $step1Data['date_of_birth'],
                'sex' => $step1Data['sex'],
                'height_cm' => $step1Data['height_cm'],
                'current_weight_kg' => $step1Data['current_weight_kg'],
                'daily_budget' => $step3Data['daily_budget'] ?? null,
                'fitness_goal_id' => $step2Data['fitness_goal_id'],
                'experience_level_id' => $step2Data['experience_level_id'],
                'preferred_workout_type_id' => $step2Data['preferred_workout_type_id'],
                'last_profile_update' => now(),
            ]);

            // Create initial weight history entry
            WeightHistory::create([
                'user_id' => $user->id,
                'log_date' => now()->toDateString(),
                'weight_kg' => $step1Data['current_weight_kg'],
            ]);

            // Attach allergies if selected
            if (!empty($step3Data['allergies'])) {
                $user->allergies()->attach($step3Data['allergies']);
            }

            // Calculate and create nutrition goals
            $this->createNutritionGoals($user, $userProfile);

            // Assign initial workout schedule
            $this->assignInitialWorkout($user, $userProfile);

            DB::commit();

            // Clear onboarding session data
            session()->forget(['onboarding_step1', 'onboarding_step2']);

            return redirect()->route('onboarding.complete');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Onboarding completion failed: ' . $e->getMessage());
            
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function complete()
    {
        $user = auth()->user();
        
        // Ensure user has completed onboarding
        if (!$user->userProfile) {
            return redirect()->route('onboarding.welcome');
        }

        return view('auth.onboarding.complete');
    }

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
