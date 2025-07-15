<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\WeightHistory;
use App\Models\UserNutritionGoal;
use App\Models\UserWorkoutSchedule;

class ProgressService
{
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