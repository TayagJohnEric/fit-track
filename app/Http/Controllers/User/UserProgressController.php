<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\WeightHistory;
use App\Models\UserProfile;
use App\Models\UserWorkoutSchedule;
use App\Models\UserMealLog;
use App\Models\UserNutritionGoal;



class UserProgressController extends Controller
{
     /**
     * Display the main progress dashboard
     * Shows weight overview, BMI trends, and progress metrics
     */
    public function index(Request $request, $id = null)
    {
        $user = Auth::user();
        $userProfile = $user->userProfile;

        // Handle edit request via modal (no separate view)
    if ($id) {
        $weightEntry = WeightHistory::where('user_id', $user->id)
            ->findOrFail($id);

        if ($request->ajax()) {
            return response()->json(['weightEntry' => $weightEntry]);
        }

        // If not AJAX, fallback to index view but prefill modal data
        return redirect()->route('progress.index')->with('editEntryId', $id);
    }
        
        // Get date range filter (default to last 30 days)
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        // Get weight history within date range
        $weightHistory = WeightHistory::where('user_id', $user->id)
            ->whereBetween('log_date', [$startDate, $endDate])
            ->orderBy('log_date', 'asc')
            ->get();
        
        // Calculate progress metrics
        $progressMetrics = $this->calculateProgressMetrics($user, $weightHistory);
        
        // Get weight and BMI chart data
        $chartData = $this->buildChartData($weightHistory, $userProfile);
        
        // Generate insights
        $insights = $this->generateInsights($user, $weightHistory, $progressMetrics);
        
        // NEW ENHANCED FEATURES
        // Get workout streak data
        $workoutStreakData = $this->getWorkoutStreakData($user, $startDate, $endDate);
        
        // Get goal adherence data
        $goalAdherenceData = $this->getGoalAdherenceData($user, $startDate, $endDate);
        
        // Get nutrition consistency data
        $nutritionConsistency = $this->getNutritionConsistencyData($user, $startDate, $endDate);
        
        // Get weekly progress summary
        $weeklyProgress = $this->getWeeklyProgressSummary($user, $startDate, $endDate);
        
        return view('user.my-progress.index', compact(
            'userProfile',
            'weightHistory',
            'progressMetrics',
            'chartData',
            'insights',
            'startDate',
            'endDate',
            // New data
            'workoutStreakData',
            'goalAdherenceData',
            'nutritionConsistency',
            'weeklyProgress'
        ));
    }
    
    /**
     * Show form to log new weight entry
     */
    public function create()
    {
        return view('user.my-progress.create');
    }
    
    /**
     * Store new weight entry
     * Automatically updates user profile current weight and calculates BMI
     */
    public function store(Request $request)
    {
        $request->validate([
            'log_date' => 'required|date|before_or_equal:today',
            'weight_kg' => 'required|numeric|min:20|max:500'
        ]);
        
        $user = Auth::user();
        
        // Check if weight already exists for this date
        $existingEntry = WeightHistory::where('user_id', $user->id)
            ->where('log_date', $request->log_date)
            ->first();
            
        if ($existingEntry) {
            return response()->json([
                'success' => false,
                'message' => 'Weight entry already exists for this date. Please update the existing entry instead.'
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Create weight history entry
            $weightEntry = WeightHistory::create([
                'user_id' => $user->id,
                'log_date' => $request->log_date,
                'weight_kg' => $request->weight_kg
            ]);
            
            // Update user profile current weight if this is the most recent entry
            $latestEntry = WeightHistory::where('user_id', $user->id)
                ->orderBy('log_date', 'desc')
                ->first();
                
            if ($latestEntry && $latestEntry->id === $weightEntry->id) {
                $user->userProfile->update([
                    'current_weight_kg' => $request->weight_kg,
                    'last_profile_update' => now()
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Weight logged successfully!',
                'redirect' => route('progress.index')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error logging weight. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Show form to edit existing weight entry
     */
    public function edit($id)
    {
        $weightEntry = WeightHistory::where('user_id', Auth::id())
            ->findOrFail($id);
            
        return view('user.my-progress.edit', compact('weightEntry'));
    }
    
    /**
     * Update existing weight entry
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'log_date' => 'required|date|before_or_equal:today',
            'weight_kg' => 'required|numeric|min:20|max:500'
        ]);
        
        $user = Auth::user();
        $weightEntry = WeightHistory::where('user_id', $user->id)->findOrFail($id);
        
        // Check if another entry exists for the new date (excluding current entry)
        $existingEntry = WeightHistory::where('user_id', $user->id)
            ->where('log_date', $request->log_date)
            ->where('id', '!=', $id)
            ->first();
            
        if ($existingEntry) {
            return response()->json([
                'success' => false,
                'message' => 'Another weight entry already exists for this date.'
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            $weightEntry->update([
                'log_date' => $request->log_date,
                'weight_kg' => $request->weight_kg
            ]);
            
            // Update user profile current weight if this is the most recent entry
            $latestEntry = WeightHistory::where('user_id', $user->id)
                ->orderBy('log_date', 'desc')
                ->first();
                
            if ($latestEntry && $latestEntry->id === $weightEntry->id) {
                $user->userProfile->update([
                    'current_weight_kg' => $request->weight_kg,
                    'last_profile_update' => now()
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Weight updated successfully!',
                'redirect' => route('progress.index')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error updating weight. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Delete weight entry
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $weightEntry = WeightHistory::where('user_id', $user->id)->findOrFail($id);
            
            DB::beginTransaction();
            
            $isLatestEntry = WeightHistory::where('user_id', $user->id)
                ->orderBy('log_date', 'desc')
                ->first()->id === $weightEntry->id;
            
            $weightEntry->delete();
            
            // Update user profile current weight if we deleted the latest entry
            if ($isLatestEntry) {
                $newLatestEntry = WeightHistory::where('user_id', $user->id)
                    ->orderBy('log_date', 'desc')
                    ->first();
                    
                if ($newLatestEntry) {
                    $user->userProfile->update([
                        'current_weight_kg' => $newLatestEntry->weight_kg,
                        'last_profile_update' => now()
                    ]);
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Weight entry deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting weight entry. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Get chart data for AJAX requests
     */
    public function getChartData(Request $request)
    {
        $user = Auth::user();
        $userProfile = $user->userProfile;
        
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $weightHistory = WeightHistory::where('user_id', $user->id)
            ->whereBetween('log_date', [$startDate, $endDate])
            ->orderBy('log_date', 'asc')
            ->get();
        
        $chartData = $this->buildChartData($weightHistory, $userProfile);
        
        return response()->json($chartData);
    }
    
    /**
     * NEW FEATURE: Get detailed workout streak information
     */
    public function getWorkoutStreakData($user, $startDate, $endDate)
    {
        // Get all workout schedules within date range
        $workouts = UserWorkoutSchedule::where('user_id', $user->id)
            ->whereBetween('assigned_date', [$startDate, $endDate])
            ->orderBy('assigned_date', 'desc')
            ->get();
        
        $currentStreak = $this->calculateCurrentWorkoutStreak($user);
        $longestStreak = $this->calculateLongestWorkoutStreak($user);
        $completionRate = $workouts->count() > 0 ? 
            round(($workouts->where('status', 'Completed')->count() / $workouts->count()) * 100, 1) : 0;
        
        return [
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak,
            'completion_rate' => $completionRate,
            'total_workouts' => $workouts->count(),
            'completed_workouts' => $workouts->where('status', 'Completed')->count(),
            'skipped_workouts' => $workouts->whereIn('status', ['Skipped', 'Auto-Skipped'])->count(),
            'recent_workouts' => $workouts->take(7) // Last 7 workouts for mini calendar view
        ];
    }
    
    /**
     * NEW FEATURE: Calculate goal adherence metrics
     */
    public function getGoalAdherenceData($user, $startDate, $endDate)
    {
        $userProfile = $user->userProfile;
        
        if (!$userProfile || !$userProfile->fitnessGoal) {
            return [
                'goal_type' => null,
                'weight_progress' => 0,
                'target_rate' => 0,
                'actual_rate' => 0,
                'adherence_percentage' => 0,
                'status' => 'No Goal Set'
            ];
        }
        
        $fitnessGoal = $userProfile->fitnessGoal->name;
        $weightData = $this->calculateWeightProgress($user, $startDate, $endDate);
        
        // Calculate target vs actual progress based on goal
        $targetRate = $fitnessGoal === 'Weight Loss' ? -0.5 : 0.3; // kg per week
        $actualRate = $weightData['weekly_rate'];
        
        $adherencePercentage = $this->calculateGoalAdherence($fitnessGoal, $targetRate, $actualRate);
        
        return [
            'goal_type' => $fitnessGoal,
            'weight_progress' => $weightData['total_change'],
            'target_rate' => $targetRate,
            'actual_rate' => $actualRate,
            'adherence_percentage' => $adherencePercentage,
            'status' => $this->getGoalStatus($adherencePercentage)
        ];
    }
    
    /**
     * NEW FEATURE: Get nutrition consistency data
     */
    public function getNutritionConsistencyData($user, $startDate, $endDate)
    {
        $mealLogs = UserMealLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$startDate, $endDate])
            ->with('mealLogEntries.foodItem')
            ->get();
        
        $nutritionGoals = UserNutritionGoal::where('user_id', $user->id)
            ->latest()
            ->first();
        
        $daysInRange = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
        $daysLogged = $mealLogs->groupBy('log_date')->count();
        $consistencyRate = $daysInRange > 0 ? round(($daysLogged / $daysInRange) * 100, 1) : 0;
        
        // Calculate average daily nutrients
        $avgNutrients = $this->calculateAverageNutrients($mealLogs);
        
        return [
            'consistency_rate' => $consistencyRate,
            'days_logged' => $daysLogged,
            'total_days' => $daysInRange,
            'avg_calories' => $avgNutrients['calories'],
            'avg_protein' => $avgNutrients['protein'],
            'avg_carbs' => $avgNutrients['carbs'],
            'avg_fat' => $avgNutrients['fat'],
            'has_goals' => $nutritionGoals !== null,
            'goals' => $nutritionGoals ? [
                'calories' => $nutritionGoals->target_calories,
                'protein' => $nutritionGoals->target_protein_grams,
                'carbs' => $nutritionGoals->target_carb_grams,
                'fat' => $nutritionGoals->target_fat_grams
            ] : null
        ];
    }
    
    /**
     * NEW FEATURE: Get weekly progress summary
     */
    public function getWeeklyProgressSummary($user, $startDate, $endDate)
    {
        $weeks = [];
        $currentDate = Carbon::parse($startDate)->startOfWeek();
        $endDate = Carbon::parse($endDate);
        
        while ($currentDate->lte($endDate)) {
            $weekEnd = $currentDate->copy()->endOfWeek();
            if ($weekEnd->gt($endDate)) {
                $weekEnd = $endDate;
            }
            
            $weekData = $this->calculateWeekData($user, $currentDate, $weekEnd);
            $weeks[] = [
                'week_start' => $currentDate->format('M j'),
                'week_end' => $weekEnd->format('M j'),
                'weight_change' => $weekData['weight_change'],
                'workouts_completed' => $weekData['workouts_completed'],
                'workouts_scheduled' => $weekData['workouts_scheduled'],
                'nutrition_days' => $weekData['nutrition_days'],
                'week_score' => $this->calculateWeekScore($weekData)
            ];
            
            $currentDate->addWeek();
        }
        
        return array_reverse($weeks); // Most recent first
    }
    
    /**
     * Calculate comprehensive progress metrics
     */
    private function calculateProgressMetrics($user, $weightHistory)
    {
        $userProfile = $user->userProfile;
        $metrics = [
            'days_tracked' => $weightHistory->count(),
            'weight_change' => 0,
            'weight_change_percentage' => 0,
            'current_bmi' => 0,
            'bmi_category' => 'Normal',
            'workout_streak' => 0,
            'total_workouts_completed' => 0
        ];
        
        if ($weightHistory->isNotEmpty()) {
            $startWeight = $weightHistory->first()->weight_kg;
            $currentWeight = $weightHistory->last()->weight_kg;
            
            $metrics['weight_change'] = $currentWeight - $startWeight;
            $metrics['weight_change_percentage'] = $startWeight > 0 
                ? (($currentWeight - $startWeight) / $startWeight) * 100 
                : 0;
        }
        
        // Calculate current BMI
        if ($userProfile && $userProfile->height_cm > 0 && $userProfile->current_weight_kg > 0) {
            $heightM = $userProfile->height_cm / 100;
            $metrics['current_bmi'] = $userProfile->current_weight_kg / ($heightM * $heightM);
            $metrics['bmi_category'] = $this->getBMICategory($metrics['current_bmi']);
        }
        
        // Calculate workout metrics
        $workoutMetrics = $this->calculateWorkoutMetrics($user);
        $metrics['workout_streak'] = $workoutMetrics['current_streak'];
        $metrics['total_workouts_completed'] = $workoutMetrics['total_completed'];
        
        return $metrics;
    }
    
    /**
     * Generate chart data for weight and BMI trends
     */
    private function buildChartData($weightHistory, $userProfile)
    {
        $weightData = [];
        $bmiData = [];
        $labels = [];
        
        if ($userProfile && $userProfile->height_cm > 0) {
            $heightM = $userProfile->height_cm / 100;
            
            foreach ($weightHistory as $entry) {
                $labels[] = $entry->log_date->format('M j');
                $weightData[] = (float) $entry->weight_kg;
                $bmiData[] = round($entry->weight_kg / ($heightM * $heightM), 1);
            }
        }
        
        return [
            'labels' => $labels,
            'weight' => $weightData,
            'bmi' => $bmiData
        ];
    }
    
    /**
     * Generate insights based on user progress data
     */
    private function generateInsights($user, $weightHistory, $progressMetrics)
    {
        $insights = [];
        
        // Weight trend insights
        if ($progressMetrics['weight_change'] > 0) {
            $insights[] = [
                'type' => 'info',
                'message' => "You've gained " . number_format(abs($progressMetrics['weight_change']), 1) . " kg over the tracked period."
            ];
        } elseif ($progressMetrics['weight_change'] < 0) {
            $insights[] = [
                'type' => 'success',
                'message' => "Great progress! You've lost " . number_format(abs($progressMetrics['weight_change']), 1) . " kg over the tracked period."
            ];
        }
        
        // BMI insights
        if ($progressMetrics['current_bmi'] > 0) {
            $bmiCategory = $progressMetrics['bmi_category'];
            if ($bmiCategory === 'Normal') {
                $insights[] = [
                    'type' => 'success',
                    'message' => "Your BMI of " . number_format($progressMetrics['current_bmi'], 1) . " is in the healthy range!"
                ];
            } elseif ($bmiCategory === 'Overweight') {
                $insights[] = [
                    'type' => 'warning',
                    'message' => "Your BMI indicates you're in the overweight range. Consider consulting with a healthcare provider."
                ];
            }
        }
        
        // Consistency insights
        if ($progressMetrics['days_tracked'] >= 30) {
            $insights[] = [
                'type' => 'success',
                'message' => "Excellent consistency! You've tracked your weight for " . $progressMetrics['days_tracked'] . " days."
            ];
        } elseif ($progressMetrics['days_tracked'] < 7) {
            $insights[] = [
                'type' => 'info',
                'message' => "Try to track your weight more regularly for better progress monitoring."
            ];
        }
        
        // Workout insights
        if ($progressMetrics['workout_streak'] > 0) {
            $insights[] = [
                'type' => 'success',
                'message' => "Keep it up! You're on a " . $progressMetrics['workout_streak'] . "-day workout streak."
            ];
        }
        
        return $insights;
    }
    
    /**
     * Calculate workout-related metrics
     */
    private function calculateWorkoutMetrics($user)
    {
        $completedWorkouts = UserWorkoutSchedule::where('user_id', $user->id)
            ->where('status', 'Completed')
            ->orderBy('assigned_date', 'desc')
            ->get();
        
        $currentStreak = 0;
        $currentDate = Carbon::now();
        
        // Calculate current workout streak
        foreach ($completedWorkouts as $workout) {
            if ($workout->assigned_date->diffInDays($currentDate) <= $currentStreak + 1) {
                $currentStreak++;
                $currentDate = $workout->assigned_date;
            } else {
                break;
            }
        }
        
        return [
            'current_streak' => $currentStreak,
            'total_completed' => $completedWorkouts->count()
        ];
    }
    
    // NEW PRIVATE HELPER METHODS
    
    private function calculateCurrentWorkoutStreak($user)
    {
        $workouts = UserWorkoutSchedule::where('user_id', $user->id)
            ->where('status', 'Completed')
            ->orderBy('assigned_date', 'desc')
            ->take(30) // Check last 30 workouts
            ->get();
            
        $streak = 0;
        $lastDate = Carbon::now();
        
        foreach ($workouts as $workout) {
            $daysDiff = $lastDate->diffInDays($workout->assigned_date);
            if ($daysDiff <= 1) {
                $streak++;
                $lastDate = $workout->assigned_date;
            } else {
                break;
            }
        }
        
        return $streak;
    }
    
    private function calculateLongestWorkoutStreak($user)
    {
        $workouts = UserWorkoutSchedule::where('user_id', $user->id)
            ->where('status', 'Completed')
            ->orderBy('assigned_date', 'asc')
            ->get();
            
        $longestStreak = 0;
        $currentStreak = 0;
        $previousDate = null;
        
        foreach ($workouts as $workout) {
            if ($previousDate === null || $previousDate->diffInDays($workout->assigned_date) <= 1) {
                $currentStreak++;
            } else {
                $longestStreak = max($longestStreak, $currentStreak);
                $currentStreak = 1;
            }
            $previousDate = $workout->assigned_date;
        }
        
        return max($longestStreak, $currentStreak);
    }
    
    private function calculateWeightProgress($user, $startDate, $endDate)
    {
        $weights = WeightHistory::where('user_id', $user->id)
            ->whereBetween('log_date', [$startDate, $endDate])
            ->orderBy('log_date', 'asc')
            ->get();
            
        if ($weights->count() < 2) {
            return ['total_change' => 0, 'weekly_rate' => 0];
        }
        
        $startWeight = $weights->first()->weight_kg;
        $endWeight = $weights->last()->weight_kg;
        $totalChange = $endWeight - $startWeight;
        
        $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
        $weeks = max($days / 7, 1);
        $weeklyRate = $totalChange / $weeks;
        
        return [
            'total_change' => $totalChange,
            'weekly_rate' => $weeklyRate
        ];
    }
    
    private function calculateGoalAdherence($goalType, $targetRate, $actualRate)
    {
        if ($targetRate == 0) return 100;
        
        $adherence = ($actualRate / $targetRate) * 100;
        
        // For weight loss, negative rates are good
        if ($goalType === 'Weight Loss') {
            $adherence = abs($adherence);
        }
        
        return min(100, max(0, $adherence));
    }
    
    private function getGoalStatus($adherencePercentage)
    {
        if ($adherencePercentage >= 80) return 'On Track';
        if ($adherencePercentage >= 60) return 'Close';
        if ($adherencePercentage >= 40) return 'Needs Work';
        return 'Off Track';
    }
    
    private function calculateAverageNutrients($mealLogs)
    {
        $totalCalories = 0;
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFat = 0;
        $dayCount = $mealLogs->groupBy('log_date')->count();
        
        if ($dayCount === 0) {
            return ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fat' => 0];
        }
        
        foreach ($mealLogs as $mealLog) {
            foreach ($mealLog->mealLogEntries as $entry) {
                $foodItem = $entry->foodItem;
                $multiplier = $entry->quantity_consumed;
                
                $totalCalories += $foodItem->calories_per_serving * $multiplier;
                $totalProtein += $foodItem->protein_grams_per_serving * $multiplier;
                $totalCarbs += $foodItem->carb_grams_per_serving * $multiplier;
                $totalFat += $foodItem->fat_grams_per_serving * $multiplier;
            }
        }
        
        return [
            'calories' => round($totalCalories / $dayCount),
            'protein' => round($totalProtein / $dayCount, 1),
            'carbs' => round($totalCarbs / $dayCount, 1),
            'fat' => round($totalFat / $dayCount, 1)
        ];
    }
    
    private function calculateWeekData($user, $weekStart, $weekEnd)
    {
        // Weight change for the week
        $weekWeights = WeightHistory::where('user_id', $user->id)
            ->whereBetween('log_date', [$weekStart, $weekEnd])
            ->orderBy('log_date', 'asc')
            ->get();
            
        $weightChange = 0;
        if ($weekWeights->count() >= 2) {
            $weightChange = $weekWeights->last()->weight_kg - $weekWeights->first()->weight_kg;
        }
        
        // Workout data
        $workouts = UserWorkoutSchedule::where('user_id', $user->id)
            ->whereBetween('assigned_date', [$weekStart, $weekEnd])
            ->get();
            
        // Nutrition data
        $nutritionDays = UserMealLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$weekStart, $weekEnd])
            ->distinct('log_date')
            ->count();
        
        return [
            'weight_change' => $weightChange,
            'workouts_completed' => $workouts->where('status', 'Completed')->count(),
            'workouts_scheduled' => $workouts->count(),
            'nutrition_days' => $nutritionDays
        ];
    }
    
    private function calculateWeekScore($weekData)
    {
        $score = 0;
        
        // Workout completion (40 points max)
        if ($weekData['workouts_scheduled'] > 0) {
            $workoutRate = $weekData['workouts_completed'] / $weekData['workouts_scheduled'];
            $score += $workoutRate * 40;
        }
        
        // Nutrition tracking (30 points max)
        $nutritionRate = min($weekData['nutrition_days'] / 7, 1);
        $score += $nutritionRate * 30;
        
        // Weight progress (30 points max) - subjective based on goals
        $score += 30; // Placeholder - could be enhanced with goal-specific logic
        
        return round($score);
    }
    
    /**
     * Get BMI category based on BMI value
     */
    private function getBMICategory($bmi)
    {
        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'Normal';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }
}
