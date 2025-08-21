<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FitnessFact;
use App\Models\FitnessMotivation;
use App\Models\UserWorkoutSchedule;
use App\Models\UserNutritionGoal;
use App\Models\UserMealLog;
use App\Models\UserMealLogEntry;
use App\Models\FoodItem;
use Carbon\Carbon;


class UserDashboardController extends Controller
{
     /**
     * Display the user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $showWelcomeMessage = $user->created_at->isToday();

        

        // Get random fitness fact
        $fitnessFact = FitnessFact::inRandomOrder()->first();

         // Get random fitness motivation
        $fitnessMotivation = FitnessMotivation::inRandomOrder()->first();

        // Get today's workout schedule
        $todaysWorkout = UserWorkoutSchedule::where('user_id', $user->id)
            ->whereDate('assigned_date', $today)
            ->with('workoutTemplate')
            ->first();

        // Get user's nutrition goals
        $nutritionGoals = UserNutritionGoal::where('user_id', $user->id)
            ->latest()
            ->first();

        // Calculate today's nutrition summary
        $nutritionSummary = $this->calculateTodaysNutrition($user->id, $today);

        // Get recent meal logs for today
        $todaysMealLogs = UserMealLog::where('user_id', $user->id)
            ->whereDate('log_date', $today)
            ->with(['mealLogEntries.foodItem'])
            ->get();

        // Get weekly workout completion stats
        $weeklyWorkoutStats = $this->getWeeklyWorkoutStats($user->id);

        return view('user.dashboard.index', compact(
            'fitnessFact',
            'todaysWorkout',
            'nutritionGoals',
            'nutritionSummary',
            'todaysMealLogs',
            'weeklyWorkoutStats',
            'fitnessMotivation',
            'showWelcomeMessage' // 👈 Add this

        ));
    }

    /**
     * Calculate today's nutrition intake
     */
    private function calculateTodaysNutrition($userId, $date)
    {
        $mealLogs = UserMealLog::where('user_id', $userId)
            ->whereDate('log_date', $date)
            ->with(['mealLogEntries.foodItem'])
            ->get();

        $totalCalories = 0;
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFat = 0;

        foreach ($mealLogs as $mealLog) {
            foreach ($mealLog->mealLogEntries as $entry) {
                if ($entry->foodItem) {
                    // Assuming FoodItem has nutritional values per 100g
                    $multiplier = $entry->quantity_consumed / 100;
                    $totalCalories += ($entry->foodItem->calories ?? 0) * $multiplier;
                    $totalProtein += ($entry->foodItem->protein_grams ?? 0) * $multiplier;
                    $totalCarbs += ($entry->foodItem->carb_grams ?? 0) * $multiplier;
                    $totalFat += ($entry->foodItem->fat_grams ?? 0) * $multiplier;
                }
            }
        }

        return [
            'calories' => round($totalCalories),
            'protein' => round($totalProtein, 1),
            'carbs' => round($totalCarbs, 1),
            'fat' => round($totalFat, 1),
        ];
    }

    /**
     * Get weekly workout completion statistics
     */
    private function getWeeklyWorkoutStats($userId)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $totalWorkouts = UserWorkoutSchedule::where('user_id', $userId)
            ->whereBetween('assigned_date', [$startOfWeek, $endOfWeek])
            ->count();

        $completedWorkouts = UserWorkoutSchedule::where('user_id', $userId)
            ->whereBetween('assigned_date', [$startOfWeek, $endOfWeek])
            ->where('status', 'Completed')
            ->count();

        $completionRate = $totalWorkouts > 0 ? round(($completedWorkouts / $totalWorkouts) * 100) : 0;

        return [
            'total' => $totalWorkouts,
            'completed' => $completedWorkouts,
            'completion_rate' => $completionRate,
        ];
    }
}
