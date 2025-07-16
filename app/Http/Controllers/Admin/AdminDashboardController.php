<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserMealLog;
use App\Models\UserWorkoutSchedule;
use App\Models\Exercise;
use App\Models\FoodItem;
use App\Models\WorkoutTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $data = [
            'statistics' => $this->getKeyStatistics(),
            'contentLibrary' => $this->getContentLibraryStats(),
            'recentActivity' => $this->getRecentActivity(),
        ];

        return view('admin.dashboard.dashboard', $data);
    }

   private function getKeyStatistics()
{
    $today = Carbon::today();
    $weekAgo = Carbon::now()->subDays(7);
    $lastWeekStart = Carbon::now()->subDays(14);
    $lastWeekEnd = Carbon::now()->subDays(7);
    $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
    $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

    return [
        'total_users' => User::count(),
                'total_users_last_month' => User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count(),

        'new_signups_this_week' => User::where('created_at', '>=', $weekAgo)->count(),
        'new_signups_last_week' => User::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
        'daily_active_users' => $this->getDailyActiveUsers($today),
        'daily_active_yesterday' => $this->getDailyActiveUsers(Carbon::yesterday()),
        'total_workouts_logged' => UserWorkoutSchedule::where('status', 'Completed')->count(),
        'total_workouts_last_month' => UserWorkoutSchedule::where('status', 'Completed')
            ->whereBetween('completion_date', [$lastMonthStart, $lastMonthEnd])
            ->count(),
    ];
}


    private function getDailyActiveUsers($date)
    {
        $mealLogUsers = UserMealLog::whereDate('log_date', $date)
            ->distinct('user_id')
            ->pluck('user_id');

        $workoutUsers = UserWorkoutSchedule::whereDate('completion_date', $date)
            ->where('status', 'Completed')
            ->distinct('user_id')
            ->pluck('user_id');

        return $mealLogUsers->merge($workoutUsers)->unique()->count();
    }

    private function getContentLibraryStats()
    {
        return [
            'total_exercises' => Exercise::count(),
            'total_food_items' => FoodItem::whereNull('creator_user_id')->count(),
            'total_workout_templates' => WorkoutTemplate::count(),
        ];
    }

    private function getRecentActivity()
    {
        return [
            'latest_signups' => $this->getLatestSignups(),
            'recent_completions' => $this->getRecentCompletions(),
        ];
    }

    private function getLatestSignups()
    {
        return User::with('userProfile')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                $profile = $user->userProfile;
                $displayName = $profile ? 
                    $profile->first_name . ' ' . substr($profile->last_name, 0, 1) . '.' : 
                    $user->name;
                
                return [
                    'name' => $displayName,
                    'created_at' => $user->created_at,
                    'location' => 'San Jose Del Monte', // You can enhance this with actual location data
                ];
            });
    }

    private function getRecentCompletions()
    {
        return UserWorkoutSchedule::with(['user.userProfile', 'workoutTemplate'])
            ->where('status', 'Completed')
            ->latest('completion_date')
            ->take(5)
            ->get()
            ->map(function ($schedule) {
                $profile = $schedule->user->userProfile;
                $displayName = $profile ? 
                    $profile->first_name . ' ' . substr($profile->last_name, 0, 1) . '.' : 
                    $schedule->user->name;
                
                return [
                    'user_name' => $displayName,
                    'workout_name' => $schedule->workoutTemplate->name,
                    'completion_date' => $schedule->completion_date,
                ];
            });
    }

    

}
