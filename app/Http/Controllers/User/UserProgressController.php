<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\WeightHistory;
use App\Models\UserNutritionGoal;
use App\Models\UserWorkoutSchedule;
use App\Services\ProgressService;

class UserProgressController extends Controller
{
     public function index(Request $request)
    {
        $user = Auth::user();
        $dateRange = $request->get('date_range', '30'); // Default to 30 days
        
        // Calculate date range
        $endDate = Carbon::now();
        $startDate = $this->getStartDate($dateRange, $endDate, $user->id);
        
        // Get progress data
        $weightData = $this->getWeightData($user->id, $startDate, $endDate);
        $nutritionData = $this->getNutritionData($user->id, $startDate, $endDate);
        $workoutData = $this->getWorkoutData($user->id, $startDate, $endDate);
        // Build insights for the UI
        $insights = ProgressService::getProgressInsights($weightData, $nutritionData, $workoutData);
        // Workout streaks
        $streak = ProgressService::getWorkoutStreak($user->id);
        
        return view('user.my-progress.index', compact(
            'weightData',
            'nutritionData', 
            'workoutData',
            'dateRange',
            'insights',
            'streak'
        ));
    }

    public function logWeight(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:20|max:500',
            'date' => 'required|date|before_or_equal:today'
        ]);

        $user = Auth::user();
        
        // Check if weight already exists for this date
        $existingWeight = WeightHistory::where('user_id', $user->id)
            ->where('log_date', $request->date)
            ->first();

        if ($existingWeight) {
            $existingWeight->update(['weight_kg' => $request->weight]);
        } else {
            WeightHistory::create([
                'user_id' => $user->id,
                'log_date' => $request->date,
                'weight_kg' => $request->weight
            ]);
        }

        // Update current weight in user profile
        if ($user->userProfile) {
            $user->userProfile->update(['current_weight_kg' => $request->weight]);
        }

        return redirect()
            ->route('progress.index', ['date_range' => $request->input('date_range', '30')])
            ->with('success', 'Weight logged successfully!');
    }

    private function getStartDate($dateRange, $endDate, $userId)
    {
        switch ($dateRange) {
            case '7':
                return $endDate->copy()->subDays(7);
            case '30':
                return $endDate->copy()->subDays(30);
            case '90':
                return $endDate->copy()->subDays(90);
            case 'all':
                // Determine earliest available date from user data
                $earliestWeight = WeightHistory::where('user_id', $userId)->min('log_date');
                $earliestMeal = DB::table('user_meal_logs')->where('user_id', $userId)->min('log_date');
                $earliestWorkout = UserWorkoutSchedule::where('user_id', $userId)->min('assigned_date');

                $candidates = array_filter([
                    $earliestWeight,
                    $earliestMeal,
                    $earliestWorkout,
                ]);

                if (empty($candidates)) {
                    return $endDate->copy()->subDays(30);
                }

                // Convert to Carbon instances and return the minimum
                $carbonDates = array_map(function ($d) { return Carbon::parse($d); }, $candidates);
                return collect($carbonDates)->min();
            default:
                return $endDate->copy()->subDays(30);
        }
    }

    private function getWeightData($userId, $startDate, $endDate)
    {
        // Get weight history (use date-only boundaries to avoid time casting issues)
        $weightHistory = WeightHistory::where('user_id', $userId)
            ->whereBetween('log_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('log_date')
            ->get();

        $user = Auth::user();
        $userProfile = $user->userProfile;
        
        // Calculate BMI data if height is available
        $bmiData = [];
        if ($userProfile && $userProfile->height_cm) {
            $heightInMeters = $userProfile->height_cm / 100;
            $bmiData = $weightHistory->map(function($weight) use ($heightInMeters) {
                return [
                    'date' => $weight->log_date->format('Y-m-d'),
                    'bmi' => round($weight->weight_kg / ($heightInMeters * $heightInMeters), 1)
                ];
            });
        }

        // Calculate weight statistics
        // Use the last weight BEFORE the period as baseline if available, so change reflects the whole selected period
        $previousWeight = WeightHistory::where('user_id', $userId)
            ->where('log_date', '<', $startDate->toDateString())
            ->orderBy('log_date', 'desc')
            ->first();

        $firstInRangeWeight = $weightHistory->first()?->weight_kg;
        $currentWeight = $weightHistory->last()?->weight_kg;

        // Baseline preference: previous before range, otherwise first within range, otherwise null
        $baselineWeight = $previousWeight->weight_kg
            ?? ($firstInRangeWeight ?? null);

        // Normalize values so math behaves predictably
        if ($baselineWeight === null && $currentWeight === null) {
            // No data at all
            $baselineWeight = 0.0;
            $currentWeight = 0.0;
        } elseif ($baselineWeight === null && $currentWeight !== null) {
            // Only one point (in-range) exists; set baseline to current for 0 change
            $baselineWeight = (float) $currentWeight;
        } elseif ($baselineWeight !== null && $currentWeight === null) {
            // Only a baseline exists before the range; treat as no change within range
            $currentWeight = (float) $baselineWeight;
        }

        $startingWeight = (float) $baselineWeight;
        $currentWeight = (float) $currentWeight;
        $weightChange = $currentWeight - $startingWeight;

        // Centralized BMI values for cards
        $startingBmi = null;
        $currentBmi = null;
        if ($userProfile && $userProfile->height_cm) {
            $startingBmi = ProgressService::calculateBMI($startingWeight, (float) $userProfile->height_cm);
            $currentBmi = ProgressService::calculateBMI($currentWeight, (float) $userProfile->height_cm);
        }

        // Recent change (global, regardless of range) - helpful when the range only has one entry
        $latestTwo = WeightHistory::where('user_id', $userId)
            ->orderBy('log_date', 'desc')
            ->limit(2)
            ->get();
        $recentChange = null;
        if ($latestTwo->count() >= 2) {
            $recentChange = (float) $latestTwo[0]->weight_kg - (float) $latestTwo[1]->weight_kg;
        }

        return [
            'history' => $weightHistory->map(function($weight) {
                return [
                    'date' => $weight->log_date->format('Y-m-d'),
                    'weight' => $weight->weight_kg
                ];
            }),
            'bmi_data' => $bmiData,
            'starting_weight' => $startingWeight,
            'current_weight' => $currentWeight,
            'weight_change' => $weightChange,
            'has_height' => $userProfile && $userProfile->height_cm,
            'starting_bmi' => $startingBmi,
            'current_bmi' => $currentBmi,
            // extra helpers
            'recent_change' => $recentChange,
        ];
    }

    private function getNutritionData($userId, $startDate, $endDate)
    {
        // Get user's nutrition goals
        $nutritionGoals = UserNutritionGoal::where('user_id', $userId)->latest()->first();
        
        if (!$nutritionGoals) {
            return [
                'has_goals' => false,
                'averages' => [],
                'goals' => [],
                'consistency_score' => 0,
                'consistent_days' => 0,
                'total_days' => 0
            ];
        }

        // Get daily nutrition totals
        $dailyTotals = DB::table('user_meal_logs')
            ->join('user_meal_log_entries', 'user_meal_logs.id', '=', 'user_meal_log_entries.meal_log_id')
            ->join('food_items', 'user_meal_log_entries.food_item_id', '=', 'food_items.id')
            ->where('user_meal_logs.user_id', $userId)
            ->whereBetween('user_meal_logs.log_date', [$startDate, $endDate])
            ->select(
                'user_meal_logs.log_date',
                DB::raw('SUM(food_items.calories_per_serving * user_meal_log_entries.quantity_consumed) as total_calories'),
                DB::raw('SUM(food_items.protein_grams_per_serving * user_meal_log_entries.quantity_consumed) as total_protein'),
                DB::raw('SUM(food_items.carb_grams_per_serving * user_meal_log_entries.quantity_consumed) as total_carbs'),
                DB::raw('SUM(food_items.fat_grams_per_serving * user_meal_log_entries.quantity_consumed) as total_fat')
            )
            ->groupBy('user_meal_logs.log_date')
            ->get();

        // Calculate averages
        $averages = [
            'calories' => $dailyTotals->avg('total_calories') ?? 0,
            'protein' => $dailyTotals->avg('total_protein') ?? 0,
            'carbs' => $dailyTotals->avg('total_carbs') ?? 0,
            'fat' => $dailyTotals->avg('total_fat') ?? 0
        ];

        // Calculate consistency score (days within ±100 calories of target)
        $consistentDays = $dailyTotals->filter(function($day) use ($nutritionGoals) {
            return abs($day->total_calories - $nutritionGoals->target_calories) <= 100;
        })->count();

        $totalDays = $dailyTotals->count();
        $consistencyScore = $totalDays > 0 ? ($consistentDays / $totalDays) * 100 : 0;

        return [
            'has_goals' => true,
            'averages' => $averages,
            'goals' => [
                'calories' => $nutritionGoals->target_calories,
                'protein' => $nutritionGoals->target_protein_grams,
                'carbs' => $nutritionGoals->target_carb_grams,
                'fat' => $nutritionGoals->target_fat_grams
            ],
            'consistency_score' => round($consistencyScore, 1),
            'consistent_days' => $consistentDays,
            'total_days' => $totalDays
        ];
    }

    private function getWorkoutData($userId, $startDate, $endDate)
    {
        // Get workout schedules within date range
        $workoutSchedules = UserWorkoutSchedule::where('user_id', $userId)
            ->whereBetween('assigned_date', [$startDate, $endDate])
            ->get();

        $totalWorkouts = $workoutSchedules->count();
        $completedWorkouts = $workoutSchedules->where('status', 'Completed')->count();
        $skippedWorkouts = $workoutSchedules->where('status', 'Skipped')->count();
        
        // Count overdue workouts as skipped
        $overdueWorkouts = $workoutSchedules->filter(function($workout) {
            return $workout->status === 'Scheduled' && 
                   $workout->assigned_date->lt(Carbon::now()->startOfDay());
        })->count();

        $effectiveSkipped = $skippedWorkouts + $overdueWorkouts;
        $adherenceRate = $totalWorkouts > 0 ? ($completedWorkouts / $totalWorkouts) * 100 : 0;

        return [
            'total_workouts' => $totalWorkouts,
            'completed_workouts' => $completedWorkouts,
            'skipped_workouts' => $effectiveSkipped,
            'adherence_rate' => round($adherenceRate, 1)
        ];
    }
}
