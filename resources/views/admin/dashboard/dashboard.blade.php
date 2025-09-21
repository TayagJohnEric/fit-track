@extends('layout.admin')
@section('title', 'Admin Dashboard')
@section('content')

<div class="min-h-screen bg-white">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Welcome Header -->
        <div class="relative bg-white rounded-2xl shadow border border-gray-100 overflow-hidden mb-8 group hover:shadow-md transition-all duration-300">
            
            <!-- Content -->
            <div class="px-6 py-8 sm:px-8 sm:py-10">
                <!-- Header with icon and actions -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <!-- Dashboard icon with orange accent -->
                        <div class="p-3 bg-orange-50 rounded-xl border border-orange-100 group-hover:bg-orange-100 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-600 group-hover:text-orange-700 transition-colors duration-300">
                                <path d="M3 3v16a2 2 0 0 0 2 2h16"/>
                                <path d="M7 16c.5-2 1.5-7 4-7 2 0 2 3 4 3 2.5 0 4.5-5 5-7"/>
                            </svg>
                        </div>

                        <!-- Title section -->
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1 tracking-tight">
                                Fit-Track Admin
                            </h1>
                            <p class="text-base sm:text-lg font-normal text-gray-500">Dashboard Overview</p>
                        </div>
                    </div>

                    <!-- Quick actions with icons -->
                    <div class="hidden sm:flex items-center space-x-3">
                        <button class="p-3 bg-white rounded-xl border border-gray-200 hover:border-orange-200 hover:bg-orange-50 transition-all duration-300 cursor-pointer group">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-orange-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </button>
                        <button class="p-3 bg-white rounded-xl border border-gray-200 hover:border-orange-200 hover:bg-orange-50 transition-all duration-300 cursor-pointer group">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-orange-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Welcome message -->
                <div class="space-y-4">
                    <p class="text-gray-600 text-base sm:text-lg max-w-3xl leading-relaxed">
                        Welcome back! Here's what's happening with your 
                        <span class="text-orange-600 font-semibold">fitness platform</span> today.
                    </p>

                    <!-- Status indicators -->
                    <div class="flex items-center space-x-6 pt-2">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-500">All systems operational</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                            <span class="text-sm text-gray-500">Real-time monitoring</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <a href="/users" class="group block transform hover:scale-[1.02] transition-all duration-200">
                <div class="bg-white rounded-2xl shadow border border-gray-100 hover:shadow-lg hover:border-orange-100 transition-all duration-200 p-6 relative overflow-hidden">
                    <!-- Orange accent -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-full opacity-70"></div>
                    <div class="flex items-center justify-between relative">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-3">
                                <p class="text-sm font-medium text-gray-600">Total Users</p>
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($statistics['total_users']) }}</p>
                            @php
                                $lastMonthUsers = $statistics['total_users_last_month'];
                            @endphp
                            <p class="text-xs text-gray-500">
                                {{ number_format($lastMonthUsers) }} users from last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center group-hover:bg-orange-100 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-orange-600 group-hover:text-orange-700">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <path d="M16 3.128a4 4 0 0 1 0 7.744"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                    <circle cx="9" cy="7" r="4"/>
                                </svg>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 group-hover:text-orange-500 group-hover:translate-x-1 transition-all duration-200">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- New Sign-ups This Week -->
            <a href="/new-signups" class="group block transform hover:scale-[1.02] transition-all duration-200">
                <div class="bg-white rounded-2xl shadow border border-gray-100 hover:shadow-lg hover:border-orange-100 transition-all duration-200 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-full opacity-70"></div>
                    <div class="flex items-center justify-between relative">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-3">
                                <p class="text-sm font-medium text-gray-600">New Sign-ups This Week</p>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($statistics['new_signups_this_week']) }}</p>
                            @php
                                $diff = $statistics['new_signups_this_week'] - $statistics['new_signups_last_week'];
                            @endphp
                            <p class="text-xs text-gray-500">
                                {{ $diff >= 0 ? '+' : '' }}{{ number_format($diff) }} from last week
                            </p>
                        </div>
                        <div class="flex-shrink-0 flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center group-hover:bg-orange-100 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-orange-600 group-hover:text-orange-700">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <line x1="19" x2="19" y1="8" y2="14"/>
                                    <line x1="22" x2="16" y1="11" y2="11"/>
                                </svg>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 group-hover:text-orange-500 group-hover:translate-x-1 transition-all duration-200">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Daily Active Users -->
            <a href="/active-users" class="group block transform hover:scale-[1.02] transition-all duration-200">
                <div class="bg-white rounded-2xl shadow border border-gray-100 hover:shadow-lg hover:border-orange-100 transition-all duration-200 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-full opacity-70"></div>
                    <div class="flex items-center justify-between relative">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-3">
                                <p class="text-sm font-medium text-gray-600">Daily Active Users</p>
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($statistics['daily_active_users']) }}</p>
                            @php
                                $diff = $statistics['daily_active_users'] - $statistics['daily_active_yesterday'];
                            @endphp
                            <p class="text-xs text-gray-500">
                                {{ $diff >= 0 ? '+' : '' }}{{ number_format($diff) }} from yesterday
                            </p>
                        </div>
                        <div class="flex-shrink-0 flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center group-hover:bg-orange-100 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-orange-600 group-hover:text-orange-700">
                                    <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/>
                                </svg>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 group-hover:text-orange-500 group-hover:translate-x-1 transition-all duration-200">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Total Workouts Logged -->
            <a href="/total-workouts" class="group block transform hover:scale-[1.02] transition-all duration-200">
                <div class="bg-white rounded-2xl shadow border border-gray-100 hover:shadow-lg hover:border-orange-100 transition-all duration-200 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-orange-50 to-transparent rounded-bl-full opacity-70"></div>
                    <div class="flex items-center justify-between relative">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-3">
                                <p class="text-sm font-medium text-gray-600">Total Workouts Logged</p>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($statistics['total_workouts_logged']) }}</p>
                            @php
                                $diff = $statistics['total_workouts_logged'] - $statistics['total_workouts_last_month'];
                            @endphp
                            <p class="text-xs text-gray-500">
                                {{ $diff >= 0 ? '+' : '' }}{{ number_format($diff) }} from last month
                            </p>
                        </div>
                        <div class="flex-shrink-0 flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center group-hover:bg-orange-100 transition-all duration-200">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-orange-600 hover:text-orange-700 lucide lucide-dumbbell-icon lucide-dumbbell"><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 group-hover:text-orange-500 group-hover:translate-x-1 transition-all duration-200">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Content Library Overview -->
        <div class="bg-white rounded-2xl shadow border border-gray-100 mb-8 overflow-hidden group hover:shadow-lg transition-all duration-300">
            <!-- Header with orange accent -->
            <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 relative">
               
                
                <div class="relative flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center mr-3 border border-orange-100 group-hover:bg-orange-100 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-orange-600 group-hover:text-orange-700 transition-colors duration-300">
                                <path d="M12 7v14"/>
                                <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-gray-800">Content Library Overview</div>
                            <div class="text-sm text-gray-500 font-normal">Manage your fitness content resources</div>
                        </div>
                    </h2>
                </div>
            </div>
            
            <!-- Stats grid -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Exercise Stats Card -->
                    <div class="group/card relative text-center p-6 bg-gradient-to-br from-gray-50 to-white rounded-2xl hover:from-orange-50 hover:to-white transition-all duration-300 cursor-pointer border border-gray-100 hover:border-orange-100 hover:shadow-md">
                        <div class="absolute top-4 right-4 opacity-20 group-hover/card:opacity-30 transition-opacity duration-300">
                            <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        
                        <div class="relative">
                            <div class="text-3xl font-bold text-gray-800 mb-2 group-hover/card:text-orange-700 transition-colors duration-300">
                                {{ number_format($contentLibrary['total_exercises']) }}
                            </div>
                            <div class="text-sm font-medium text-gray-600 group-hover/card:text-orange-600 transition-colors duration-300">
                                Total Exercises
                            </div>
                            <div class="mt-2 text-xs text-gray-500 group-hover/card:text-orange-500 transition-colors duration-300">
                                Active content library
                            </div>
                        </div>
                        
                        <div class="absolute bottom-0 left-6 right-6 h-0.5 bg-gradient-to-r from-transparent via-gray-300 to-transparent group-hover/card:via-orange-400 transition-all duration-300"></div>
                    </div>
                    
                    <!-- Food Items Stats Card -->
                    <div class="group/card relative text-center p-6 bg-gradient-to-br from-gray-50 to-white rounded-2xl hover:from-orange-50 hover:to-white transition-all duration-300 cursor-pointer border border-gray-100 hover:border-orange-100 hover:shadow-md">
                        <div class="absolute top-4 right-4 opacity-20 group-hover/card:opacity-30 transition-opacity duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-400">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                        </div>
                        
                        <div class="relative">
                            <div class="text-3xl font-bold text-gray-800 mb-2 group-hover/card:text-orange-700 transition-colors duration-300">
                                {{ number_format($contentLibrary['total_food_items']) }}
                            </div>
                            <div class="text-sm font-medium text-gray-600 group-hover/card:text-orange-600 transition-colors duration-300">
                                Total Food Items
                            </div>
                            <div class="mt-2 text-xs text-gray-500 group-hover/card:text-orange-500 transition-colors duration-300">
                                Nutrition database
                            </div>
                        </div>
                        
                        <div class="absolute bottom-0 left-6 right-6 h-0.5 bg-gradient-to-r from-transparent via-gray-300 to-transparent group-hover/card:via-orange-400 transition-all duration-300"></div>
                    </div>
                    
                    <!-- Workout Templates Stats Card -->
                    <div class="group/card relative text-center p-6 bg-gradient-to-br from-gray-50 to-white rounded-2xl hover:from-orange-50 hover:to-white transition-all duration-300 cursor-pointer border border-gray-100 hover:border-orange-100 hover:shadow-md">
                        <div class="absolute top-4 right-4 opacity-20 group-hover/card:opacity-30 transition-opacity duration-300">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-400 lucide lucide-dumbbell-icon lucide-dumbbell"><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                        </div>
                        
                        <div class="relative">
                            <div class="text-3xl font-bold text-gray-800 mb-2 group-hover/card:text-orange-700 transition-colors duration-300">
                                {{ number_format($contentLibrary['total_workout_templates']) }}
                            </div>
                            <div class="text-sm font-medium text-gray-600 group-hover/card:text-orange-600 transition-colors duration-300">
                                Workout Templates
                            </div>
                            <div class="mt-2 text-xs text-gray-500 group-hover/card:text-orange-500 transition-colors duration-300">
                                Ready-to-use plans
                            </div>
                        </div>
                        
                        <div class="absolute bottom-0 left-6 right-6 h-0.5 bg-gradient-to-r from-transparent via-gray-300 to-transparent group-hover/card:via-orange-400 transition-all duration-300"></div>
                    </div>
                </div>
                
                <!-- Summary footer -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                <span>Content synced</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                                <span>Live updates</span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400">
                            Last updated: Just now
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Latest Sign-ups -->
            <div class="bg-white rounded-2xl shadow border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center mr-3 border border-orange-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-orange-600">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <line x1="19" x2="19" y1="8" y2="14"/>
                                <line x1="22" x2="16" y1="11" y2="11"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-gray-800">Latest Sign-ups</div>
                            <div class="text-sm text-gray-500 font-normal">Recent user registrations</div>
                        </div>
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentActivity['latest_signups'] as $signup)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-orange-50 transition-colors duration-200 border border-transparent hover:border-orange-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-4 flex-shrink-0">
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
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">No recent sign-ups</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Completions -->
            <div class="bg-white rounded-2xl shadow border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center mr-3 border border-orange-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-orange-600">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-gray-800">Recent Completions</div>
                            <div class="text-sm text-gray-500 font-normal">Latest workout achievements</div>
                        </div>
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentActivity['recent_completions'] as $completion)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-orange-50 transition-colors duration-200 border border-transparent hover:border-orange-100">
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
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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