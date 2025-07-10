<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserMealLog;
use App\Models\UserWorkoutSchedule;
use Carbon\Carbon;



class AdminUserManagementController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('userProfile')
            ->where('role', 'user')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.manage-users.index', compact('users', 'search'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'user') {
            abort(403);
        }

        return view('admin.manage-users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->role !== 'user') {
            abort(403);
        }

        $user->load('userProfile');

        return view('admin.manage-users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'user') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:Male,Female,Other',
            'height_cm' => 'required|numeric',
            'current_weight_kg' => 'required|numeric',
            'daily_budget' => 'nullable|numeric',
            'fitness_goal_id' => 'required|exists:fitness_goals,id',
            'experience_level_id' => 'required|exists:experience_levels,id',
            'preferred_workout_type_id' => 'required|exists:workout_types,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->userProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'date_of_birth' => $validated['date_of_birth'],
                'sex' => $validated['sex'],
                'height_cm' => $validated['height_cm'],
                'current_weight_kg' => $validated['current_weight_kg'],
                'daily_budget' => $validated['daily_budget'],
                'fitness_goal_id' => $validated['fitness_goal_id'],
                'experience_level_id' => $validated['experience_level_id'],
                'preferred_workout_type_id' => $validated['preferred_workout_type_id'],
            ]
        );

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'user') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    //New Signup Users

    public function newUsers(Request $request)
{
    $filter = $request->query('filter', 'day'); // default to 'day'
    $query = User::with('userProfile')->latest();

    $now = Carbon::now();

    switch ($filter) {
        case 'week':
            $query->where('created_at', '>=', $now->copy()->subWeek());
            break;
        case 'month':
            $query->where('created_at', '>=', $now->copy()->subMonth());
            break;
        case 'day':
        default:
            $query->whereDate('created_at', $now->toDateString());
            break;
    }

    $users = $query->paginate(10)->withQueryString();

    return view('admin.dashboard.new_signups', compact('users', 'filter'));
}


//Daily Active Users
public function activeUsers(Request $request)
{
    $filter = $request->query('filter', 'day');
    $now = Carbon::now();

    $startDate = match ($filter) {
        'week' => $now->copy()->subWeek()->startOfDay(),
        'month' => $now->copy()->subMonth()->startOfDay(),
        default => $now->copy()->startOfDay(),
    };

    // Get user IDs from logs
    $mealUserIds = UserMealLog::whereDate('log_date', '>=', $startDate)
        ->pluck('user_id')->toArray();
    
    $workoutUserIds = UserWorkoutSchedule::where('status', 'Completed')
        ->whereDate('completion_date', '>=', $startDate)
        ->pluck('user_id')->toArray();

    $activeUserIds = array_unique(array_merge($mealUserIds, $workoutUserIds));

    $users = User::with('userProfile')
        ->whereIn('id', $activeUserIds)
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.dashboard.active_users', compact('users', 'filter'));
}

 public function totalWorkoutsLogged(Request $request)
{
    $filter = $request->query('filter', 'day');
    $now = Carbon::now();

    $startDate = match ($filter) {
        'week' => $now->copy()->subWeek()->startOfDay(),
        'month' => $now->copy()->subMonth()->startOfDay(),
        default => $now->copy()->startOfDay(),
    };

    $workouts = UserWorkoutSchedule::with(['user.userProfile', 'template'])
        ->where('status', 'Completed')
        ->whereDate('completion_date', '>=', $startDate)
        ->latest('completion_date')
        ->paginate(10)
        ->withQueryString();

    return view('admin.dashboard.total_workouts', compact('workouts', 'filter'));
}
}
