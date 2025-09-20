@extends('layout.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div class="flex items-center">
                @if($user->profile_image_url)
                    <img src="{{ asset('storage/' . $user->profile_image_url) }}" alt="{{ $user->name }} profile" class="w-14 h-14 rounded-full object-cover shadow mr-4">
                @else
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $user->name }}</h2>
                    <p class="text-gray-600">User Account Details</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.edit', $user->id) }}" 
                   class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition duration-200">
                    Back to Users
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Basic Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Full Name</label>
                        <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email Address</label>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Role</label>
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-medium">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Member Since</label>
                        <p class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                   
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                        <p class="text-gray-900">{{ $user->updated_at->format('M d, Y g:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Information Card -->
            @if($user->userProfile)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Profile Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">First Name</label>
                        <p class="text-gray-900 font-medium">{{ $user->userProfile->first_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Last Name</label>
                        <p class="text-gray-900 font-medium">{{ $user->userProfile->last_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Gender</label>
                        <p class="text-gray-900">{{ $user->userProfile->sex }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Date of Birth</label>
                        <p class="text-gray-900">{{ $user->userProfile->date_of_birth->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Age</label>
                        <p class="text-gray-900">{{ $user->userProfile->date_of_birth->age }} years old</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Height</label>
                        <p class="text-gray-900">{{ $user->userProfile->height_cm }} cm</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Current Weight</label>
                        <p class="text-gray-900">{{ $user->userProfile->current_weight_kg }} kg</p>
                    </div>
                    @if($user->userProfile->daily_budget)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Daily Budget</label>
                        <p class="text-gray-900">${{ number_format($user->userProfile->daily_budget, 2) }}</p>
                    </div>
                    @endif
                </div>
                
                <!-- Fitness Information -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-medium text-gray-800 mb-3">Fitness Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($user->userProfile->fitnessGoal)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Fitness Goal</label>
                            <p class="text-gray-900">{{ $user->userProfile->fitnessGoal->name ?? 'N/A' }}</p>
                        </div>
                        @endif
                        
                        @if($user->userProfile->experienceLevel)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Experience Level</label>
                            <p class="text-gray-900">{{ $user->userProfile->experienceLevel->name ?? 'N/A' }}</p>
                        </div>
                        @endif
                        
                        @if($user->userProfile->preferredWorkoutType)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Preferred Workout</label>
                            <p class="text-gray-900">{{ $user->userProfile->preferredWorkoutType->name ?? 'N/A' }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-500">Last Profile Update</label>
                    <p class="text-gray-900">{{ $user->userProfile->last_profile_update->format('M d, Y g:i A') }}</p>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-yellow-800">No Profile Information</h3>
                </div>
                <p class="text-yellow-700 mt-2">This user has not completed their profile setup yet.</p>
            </div>
            @endif

            <!-- Recent Activity -->
            @if($user->mealLogs->count() > 0 || $user->workoutSchedules->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Recent Activity
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Recent Meal Logs -->
                    @if($user->mealLogs->count() > 0)
                    <div>
                        <h4 class="font-medium text-gray-700 mb-3">Recent Meal Logs</h4>
                        <div class="space-y-2">
                            @foreach($user->mealLogs->take(5) as $mealLog)
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded">
                                <span class="text-sm text-gray-900">{{ $mealLog->meal_type }}</span>
                                <span class="text-sm text-gray-500">{{ $mealLog->log_date->format('M d') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Recent Workouts -->
                    @if($user->workoutSchedules->count() > 0)
                    <div>
                        <h4 class="font-medium text-gray-700 mb-3">Recent Workouts</h4>
                        <div class="space-y-2">
                            @foreach($user->workoutSchedules->take(5) as $workout)
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded">
                                <span class="text-sm text-gray-900">{{ $workout->workoutTemplate->name ?? 'Template N/A' }}</span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $workout->status === 'Completed' ? 'bg-green-100 text-green-800' : 
                                           ($workout->status === 'Skipped' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $workout->status }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $workout->assigned_date->format('M d') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Stats & Summary -->
        <div class="space-y-6">
            <!-- Quick Stats Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Meal Logs</span>
                        <span class="font-semibold text-blue-600">{{ $stats['total_meal_logs'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Workouts</span>
                        <span class="font-semibold text-purple-600">{{ $stats['total_workouts'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Completed Workouts</span>
                        <span class="font-semibold text-green-600">{{ $stats['completed_workouts'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Active Days (30d)</span>
                        <span class="font-semibold text-orange-600">{{ $stats['recent_activity_days'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Account Status Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Status</h3>
                <div class="space-y-3">
                
                    <div class="flex items-center">
                        @if($user->userProfile)
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Profile Complete</span>
                        @else
                            <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Profile Incomplete</span>
                        @endif
                    </div>
                    <div class="flex items-center">
                        @if($stats['recent_activity_days'] > 0)
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Recently Active</span>
                        @else
                            <div class="w-3 h-3 bg-gray-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Image Card (if exists) -->
            @if($user->profile_image_url)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Profile Image</h3>
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $user->profile_image_url) }}"
                         alt="{{ $user->name }}'s profile" 
                         class="w-32 h-32 rounded-full object-cover shadow-md">
                </div>
            </div>
            @endif

           
        </div>
    </div>
</div>
@endsection