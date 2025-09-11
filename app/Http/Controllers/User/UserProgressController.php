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


class UserProgressController extends Controller
{
    /**
     * Display the main progress dashboard
     * Shows weight overview, BMI trends, and progress metrics
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userProfile = $user->userProfile;
        
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
        
        return view('user.my-progress.index', compact(
            'userProfile',
            'weightHistory',
            'progressMetrics',
            'chartData',
            'insights',
            'startDate',
            'endDate'
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
