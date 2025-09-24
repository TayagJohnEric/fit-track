<?php

namespace App\Http\Controllers\Auth;

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
use Illuminate\Support\Facades\Validator;
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

    public function storeStepOne(Request $request)
    {
        // Validation rules from OnboardingStepOneRequest
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'sex' => ['required', 'in:Male,Female,Other'],
            'height_cm' => ['required', 'numeric', 'min:100', 'max:250'],
            'current_weight_kg' => ['required', 'numeric', 'min:30', 'max:300'],
        ], [
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'height_cm.min' => 'Height must be at least 100 cm.',
            'height_cm.max' => 'Height cannot exceed 250 cm.',
            'current_weight_kg.min' => 'Weight must be at least 30 kg.',
            'current_weight_kg.max' => 'Weight cannot exceed 300 kg.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        
        // Store step 1 data in session
        session([
            'onboarding_step1' => $validator->validated()
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

    public function storeStepTwo(Request $request)
    {
        // Ensure step 1 is completed
        if (!session('onboarding_step1')) {
            return redirect()->route('onboarding.step1');
        }

        // Validation rules from OnboardingStepTwoRequest
        $validator = Validator::make($request->all(), [
            'fitness_goal_id' => ['required', 'exists:fitness_goals,id'],
            'experience_level_id' => ['required', 'exists:experience_levels,id'],
            'preferred_workout_type_id' => ['required', 'exists:workout_types,id'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Store step 2 data in session
        session([
            'onboarding_step2' => $validator->validated()
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

    public function storeStepThree(Request $request)
    {
        // Ensure previous steps are completed
        if (!session('onboarding_step1') || !session('onboarding_step2')) {
            return redirect()->route('onboarding.step1');
        }

        // Validation rules from OnboardingStepThreeRequest
        $validator = Validator::make($request->all(), [
            'allergies' => ['nullable', 'array'],
            'allergies.*' => ['exists:allergies,id'],
            'daily_budget' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
        ], [
            'daily_budget.min' => 'Daily budget cannot be negative.',
            'daily_budget.max' => 'Daily budget is too large.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        
        try {
            DB::beginTransaction();

            // Get all onboarding data
            $step1Data = session('onboarding_step1');
            $step2Data = session('onboarding_step2');
            $step3Data = $validator->validated();

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

            // Calculate and create nutrition goals (integrated from service logic)
            $this->createNutritionGoals($user, $userProfile);

            // Assign initial workout schedule (integrated from service logic)
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
        // Find all suitable workout templates matching the user's preferences
        $workoutTemplates = WorkoutTemplate::where('workout_type_id', $userProfile->preferred_workout_type_id)
            ->where('experience_level_id', $userProfile->experience_level_id)
            ->get();

        if ($workoutTemplates->isEmpty()) {
            // Log a warning if no templates are found
            Log::warning('No workout templates found for workout_type_id: ' . $userProfile->preferred_workout_type_id . ' and experience_level_id: ' . $userProfile->experience_level_id);
            return;
        }

        // Create a 7-day schedule with 6 workout days and 1 rest day
        // Rest day will be on day 3 (Wednesday, 0-indexed)
        $restDay = 3;
        $templateIndex = 0;
        $templateCount = $workoutTemplates->count();

        for ($day = 0; $day < 7; $day++) {
            // Skip the rest day
            if ($day === $restDay) {
                continue;
            }

            // Rotate through available templates
            $currentTemplate = $workoutTemplates[$templateIndex % $templateCount];
            
            UserWorkoutSchedule::create([
                'user_id'       => $user->id,
                'template_id'   => $currentTemplate->id,
                'assigned_date' => now()->addDays($day)->toDateString(),
                'status'        => 'Scheduled',
            ]);

            // Move to next template for variety
            $templateIndex++;
        }

        Log::info('Created 7-day workout schedule for user ' . $user->id . ' with ' . $templateCount . ' different templates, rest day on day ' . $restDay);
    }

    // ===== INTEGRATED PROGRESS SERVICE METHODS =====

    /**
     * Calculate BMI from weight and height
     */
    public static function calculateBMI($weightKg, $heightCm)
    {
        if ($heightCm <= 0) return 0;
        
        $heightMeters = $heightCm / 100;
        return round($weightKg / ($heightMeters * $heightMeters), 1);
    }

    /**
     * Get BMI category based on BMI value
     */
    public static function getBMICategory($bmi)
    {
        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Overweight';
        return 'Obese';
    }

    /**
     * Calculate weight loss/gain rate per week
     */
    public static function calculateWeightChangeRate($startWeight, $endWeight, $startDate, $endDate)
    {
        $weightChange = $endWeight - $startWeight;
        $daysDiff = $startDate->diffInDays($endDate);
        
        if ($daysDiff <= 0) return 0;
        
        $weeksSpan = $daysDiff / 7;
        return round($weightChange / $weeksSpan, 2);
    }

    /**
     * Get nutrition adherence percentage for a specific nutrient
     */
    public static function getNutritionAdherence($actual, $target, $tolerance = 0.1)
    {
        if ($target <= 0) return 0;
        
        $percentage = ($actual / $target) * 100;
        $lowerBound = (1 - $tolerance) * 100;
        $upperBound = (1 + $tolerance) * 100;
        
        if ($percentage >= $lowerBound && $percentage <= $upperBound) {
            return 100; // Perfect adherence
        }
        
        return min($percentage, 100);
    }

    /**
     * Calculate nutrition consistency score
     */
    public static function calculateNutritionConsistency($userId, $startDate, $endDate, $calorieTarget, $tolerance = 100)
    {
        $dailyTotals = DB::table('user_meal_logs')
            ->join('user_meal_log_entries', 'user_meal_logs.id', '=', 'user_meal_log_entries.meal_log_id')
            ->join('food_items', 'user_meal_log_entries.food_item_id', '=', 'food_items.id')
            ->where('user_meal_logs.user_id', $userId)
            ->whereBetween('user_meal_logs.log_date', [$startDate, $endDate])
            ->select(
                'user_meal_logs.log_date',
                DB::raw('SUM(food_items.calories_per_serving * user_meal_log_entries.quantity_consumed) as total_calories')
            )
            ->groupBy('user_meal_logs.log_date')
            ->get();

        $consistentDays = $dailyTotals->filter(function($day) use ($calorieTarget, $tolerance) {
            return abs($day->total_calories - $calorieTarget) <= $tolerance;
        })->count();

        $totalDays = $dailyTotals->count();
        
        return $totalDays > 0 ? round(($consistentDays / $totalDays) * 100, 1) : 0;
    }

    /**
     * Get workout streak information
     */
    public static function getWorkoutStreak($userId)
    {
        $workouts = UserWorkoutSchedule::where('user_id', $userId)
            ->where('assigned_date', '<=', Carbon::now())
            ->orderBy('assigned_date', 'desc')
            ->get();

        $currentStreak = 0;
        $longestStreak = 0;
        $tempStreak = 0;

        foreach ($workouts as $workout) {
            if ($workout->status === 'Completed') {
                $tempStreak++;
                if ($currentStreak === 0) {
                    $currentStreak = $tempStreak;
                }
            } else {
                if ($tempStreak > $longestStreak) {
                    $longestStreak = $tempStreak;
                }
                $tempStreak = 0;
                $currentStreak = 0;
            }
        }

        if ($tempStreak > $longestStreak) {
            $longestStreak = $tempStreak;
        }

        return [
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak
        ];
    }

    /**
     * Get progress insights and recommendations
     */
    public static function getProgressInsights($weightData, $nutritionData, $workoutData)
    {
        $insights = [];

        // Weight insights
        if ($weightData['weight_change'] != 0) {
            $direction = $weightData['weight_change'] > 0 ? 'gained' : 'lost';
            $insights[] = [
                'type' => 'weight',
                'icon' => $weightData['weight_change'] > 0 ? 'trending-up' : 'trending-down',
                'message' => "You've {$direction} " . abs($weightData['weight_change']) . " kg",
                'color' => $weightData['weight_change'] > 0 ? 'text-red-600' : 'text-green-600'
            ];
        }

        // Nutrition insights
        if ($nutritionData['has_goals'] && $nutritionData['consistency_score'] > 0) {
            if ($nutritionData['consistency_score'] >= 80) {
                $insights[] = [
                    'type' => 'nutrition',
                    'icon' => 'check-circle',
                    'message' => "Excellent nutrition consistency at {$nutritionData['consistency_score']}%",
                    'color' => 'text-green-600'
                ];
            } elseif ($nutritionData['consistency_score'] >= 60) {
                $insights[] = [
                    'type' => 'nutrition',
                    'icon' => 'exclamation-circle',
                    'message' => "Good nutrition consistency. Try to improve to 80%+",
                    'color' => 'text-yellow-600'
                ];
            } else {
                $insights[] = [
                    'type' => 'nutrition',
                    'icon' => 'x-circle',
                    'message' => "Focus on improving nutrition consistency",
                    'color' => 'text-red-600'
                ];
            }
        }

        // Workout insights
        if ($workoutData['total_workouts'] > 0) {
            if ($workoutData['adherence_rate'] >= 80) {
                $insights[] = [
                    'type' => 'workout',
                    'icon' => 'lightning-bolt',
                    'message' => "Great workout adherence at {$workoutData['adherence_rate']}%",
                    'color' => 'text-green-600'
                ];
            } elseif ($workoutData['adherence_rate'] >= 60) {
                $insights[] = [
                    'type' => 'workout',
                    'icon' => 'clock',
                    'message' => "Good workout consistency. Aim for 80%+",
                    'color' => 'text-yellow-600'
                ];
            } else {
                $insights[] = [
                    'type' => 'workout',
                    'icon' => 'x-circle',
                    'message' => "Work on improving workout consistency",
                    'color' => 'text-red-600'
                ];
            }
        }

        return $insights;
    }

    /**
     * Format number for display
     */
    public static function formatNumber($number, $decimals = 1)
    {
        return number_format($number, $decimals);
    }

    /**
     * Get color based on percentage
     */
    public static function getProgressColor($percentage)
    {
        if ($percentage >= 90) return 'green';
        if ($percentage >= 70) return 'yellow';
        if ($percentage >= 50) return 'orange';
        return 'red';
    }
}