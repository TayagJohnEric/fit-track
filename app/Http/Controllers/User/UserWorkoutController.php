<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserWorkoutSchedule;
use App\Models\WorkoutTemplate;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserWorkoutController extends Controller
{
    /**
     * Display today's workout for the authenticated user
     */
    public function todaysWorkout()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Auto-skip previous incomplete workouts before showing today's workout
        $this->autoSkipIncompleteWorkouts($user->id);
        
        // Get today's scheduled workout
        $scheduledWorkout = UserWorkoutSchedule::where('user_id', $user->id)
            ->where('assigned_date', $today)
            ->with(['workoutTemplate.exercises' => function ($query) {
                $query->orderBy('workout_template_exercises.order_in_workout');
            }])
            ->first();
        
        if (!$scheduledWorkout) {
            return view('user.todays-workout.no-workout-today');
        }
        
        return view('user.todays-workout.today', compact('scheduledWorkout'));
    }
    
    /**
     * Display detailed view of a specific exercise
     */
    public function showExercise($workoutScheduleId, $exerciseId)
    {
        $user = Auth::user();
        
        // Verify the workout schedule belongs to the user
        $scheduledWorkout = UserWorkoutSchedule::where('id', $workoutScheduleId)
            ->where('user_id', $user->id)
            ->with('workoutTemplate')
            ->firstOrFail();
        
        // Get the exercise with pivot data
        $exercise = $scheduledWorkout->workoutTemplate->exercises()
            ->where('exercises.id', $exerciseId)
            ->firstOrFail();
        
        return view('user.todays-workout.exercise-detail', compact('scheduledWorkout', 'exercise'));
    }
    
    /**
     * Mark workout as completed
     */
    public function completeWorkout(Request $request, $workoutScheduleId)
    {
        $user = Auth::user();
        
        $scheduledWorkout = UserWorkoutSchedule::where('id', $workoutScheduleId)
            ->where('user_id', $user->id)
            ->firstOrFail();
        
        // Update workout status
        $scheduledWorkout->update([
            'status' => 'Completed',
            'completion_date' => Carbon::now(),
            'user_notes' => $request->input('notes')
        ]);
        
        return redirect()->route('workouts.today')
            ->with('success', 'Congratulations! You have completed your workout for today.');
    }
    
    /**
     * Display workout history
     */
    public function history()
    {
        $user = Auth::user();
        
        // Auto-skip incomplete workouts before showing history
        $this->autoSkipIncompleteWorkouts($user->id);
        
        $workoutHistory = UserWorkoutSchedule::where('user_id', $user->id)
            ->with('workoutTemplate')
            ->orderBy('assigned_date', 'desc')
            ->paginate(10);
        
        return view('user.todays-workout.history', compact('workoutHistory'));
    }
    
    /**
     * Skip today's workout
     */
    public function skipWorkout($workoutScheduleId)
    {
        $user = Auth::user();
        
        $scheduledWorkout = UserWorkoutSchedule::where('id', $workoutScheduleId)
            ->where('user_id', $user->id)
            ->firstOrFail();
        
        $scheduledWorkout->update([
            'status' => 'Skipped',
            'skipped_date' => Carbon::now() // Track when it was skipped
        ]);
        
        return redirect()->route('workouts.today')
            ->with('info', 'Workout marked as skipped. Don\'t worry, you can get back on track tomorrow!');
    }
    
    /**
     * Automatically mark incomplete workouts as skipped
     * This method should be called at strategic points or via scheduled task
     */
    public function autoSkipIncompleteWorkouts($userId = null)
    {
        $query = UserWorkoutSchedule::query()
            ->where('assigned_date', '<', Carbon::today()) // Only past dates
            ->whereIn('status', ['Scheduled', 'Pending', 'In Progress', null]); // Incomplete statuses
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        $incompleteWorkouts = $query->get();
        
        foreach ($incompleteWorkouts as $workout) {
            $workout->update([
                'status' => 'Auto-Skipped',
                'skipped_date' => Carbon::now(),
                'user_notes' => ($workout->user_notes ?? '') . ' [Auto-skipped due to inactivity]'
            ]);
        }
        
        return $incompleteWorkouts->count();
    }
    
    /**
     * Manual endpoint to trigger auto-skip for all users (for admin use)
     */
    public function triggerAutoSkip()
    {
        // You might want to add authorization check here
        $skippedCount = $this->autoSkipIncompleteWorkouts();
        
        return response()->json([
            'message' => "Auto-skipped {$skippedCount} incomplete workouts",
            'count' => $skippedCount
        ]);
    }
    
    /**
     * Get workout statistics including auto-skipped workouts
     */
    public function getWorkoutStats()
    {
        $user = Auth::user();
        
        // Auto-skip incomplete workouts first
        $this->autoSkipIncompleteWorkouts($user->id);
        
        $stats = [
            'completed' => UserWorkoutSchedule::where('user_id', $user->id)
                ->where('status', 'Completed')
                ->count(),
            'manually_skipped' => UserWorkoutSchedule::where('user_id', $user->id)
                ->where('status', 'Skipped')
                ->count(),
            'auto_skipped' => UserWorkoutSchedule::where('user_id', $user->id)
                ->where('status', 'Auto-Skipped')
                ->count(),
            'pending' => UserWorkoutSchedule::where('user_id', $user->id)
                ->whereIn('status', ['Scheduled', 'Pending', 'In Progress', null])
                ->where('assigned_date', '>=', Carbon::today())
                ->count()
        ];
        
        return response()->json($stats);
    }
    
    /**
     * Check if there are any workouts that need to be auto-skipped for current user
     */
    public function checkPendingAutoSkips()
    {
        $user = Auth::user();
        
        $pendingAutoSkips = UserWorkoutSchedule::where('user_id', $user->id)
            ->where('assigned_date', '<', Carbon::today())
            ->whereIn('status', ['Scheduled', 'Pending', 'In Progress', null])
            ->count();
        
        return response()->json(['pending_auto_skips' => $pendingAutoSkips]);
    }
}