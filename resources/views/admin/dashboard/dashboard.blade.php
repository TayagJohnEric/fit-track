@extends('layout.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="min-h-screen">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Header -->
        <div class="relative bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-800 to-gray-900 opacity-90"></div>
            <div class="relative px-6 py-8 sm:px-8 sm:py-12">
                <h1 class="text-2xl sm:text-2xl font-bold text-white mb-3">
                    Fit-Track Admin Dashboard
                </h1>
                <p class="text-gray-300 text-lg max-w-2xl">
                    Welcome back! Here's what's happening with your fitness platform today.
                </p>
            </div>
        </div>

        <!-- Key Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 ">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($statistics['total_users']) }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-500 lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>                        </div>
                    </div>
                </div>
            </div>

            <!-- New Sign-ups This Week -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 ">New Sign-ups</p>
                        <p class="text-xs text-gray-500 mt-1">This Week</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($statistics['new_signups_this_week']) }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-500 lucide lucide-user-plus-icon lucide-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Active Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 ">Daily Active Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($statistics['daily_active_users']) }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-500 lucide lucide-zap-icon lucide-zap"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Workouts Logged -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 ">Total Workouts</p>
                        <p class="text-xs text-gray-500 mt-1">Logged</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($statistics['total_workouts_logged']) }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-500 lucide lucide-dumbbell-icon lucide-dumbbell"><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Library Overview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-500 lucide lucide-book-open-icon lucide-book-open"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                    </div>
                    Content Library Overview
                </h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                        <div class="text-3xl font-bold text-gray-800 mb-2">{{ number_format($contentLibrary['total_exercises']) }}</div>
                        <div class="text-sm font-medium text-gray-600 ">Total Exercises</div>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                        <div class="text-3xl font-bold text-gray-800 mb-2">{{ number_format($contentLibrary['total_food_items']) }}</div>
                        <div class="text-sm font-medium text-gray-600 ">Total Food Items</div>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                        <div class="text-3xl font-bold text-gray-800 mb-2">{{ number_format($contentLibrary['total_workout_templates']) }}</div>
                        <div class="text-sm font-medium text-gray-600 ">Workout Templates</div>
                    </div>
                </div>
            </div>
        </div>

      

        <!-- Recent Activity Feed -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Latest Sign-ups -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        Latest Sign-ups
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentActivity['latest_signups'] as $signup)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-4 flex-shrink-0">
                                {{ substr($signup['name'], 0, 2) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $signup['name'] }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    From {{ $signup['location'] }} • {{ $signup['created_at']->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">No recent sign-ups</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Completions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-green-100 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Recent Completions
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentActivity['recent_completions'] as $completion)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white mr-4 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $completion['user_name'] }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1 truncate">
                                    Completed "{{ $completion['workout_name'] }}" • {{ $completion['completion_date']->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">No recent workout completions</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection