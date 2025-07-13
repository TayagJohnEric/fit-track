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
            'status' => 'Skipped'
        ]);
        
        return redirect()->route('workouts.today')
            ->with('info', 'Workout marked as skipped. Don\'t worry, you can get back on track tomorrow!');
    }
}
