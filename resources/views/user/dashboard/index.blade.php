@extends('layout.user')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-6">
   <!-- Welcome Header -->
<div class="mb-8">
    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
        {{ $showWelcomeMessage ? 'Welcome to your dashboard, ' : 'Welcome back, ' }}{{ auth()->user()->name }}!
    </h1>
    <p class="text-gray-600 text-lg">Here's your fitness overview for {{ date('F j, Y') }}</p>
</div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        <!-- Today's Workout Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-600 mb-2">Today's Workout</p>
                    @if($todaysWorkout)
                        <p class="text-2xl font-bold text-gray-900 truncate">{{ $todaysWorkout->status }}</p>
                        <p class="text-sm text-gray-500 mt-1 truncate">{{ $todaysWorkout->workoutTemplate->name ?? 'Workout Scheduled' }}</p>
                    @else
                        <p class="text-2xl font-bold text-gray-400">No Workout</p>
                        <p class="text-sm text-gray-500 mt-1">Rest day</p>
                    @endif
                </div>
                <div class="h-12 w-12 bg-orange-50 rounded-lg flex items-center justify-center ml-4 flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-orange-600 lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                </div>
            </div>
        </div>

        <!-- Weekly Progress -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-600 mb-2">Weekly Progress</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $weeklyWorkoutStats['completion_rate'] }}%</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $weeklyWorkoutStats['completed'] }}/{{ $weeklyWorkoutStats['total'] }} workouts</p>
                </div>
                <div class="h-12 w-12 bg-orange-50 rounded-lg flex items-center justify-center ml-4 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-orange-600">
                        <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"/>
                    </svg>           
                </div>
            </div>
        </div>

        <!-- Calories Today -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-600 mb-2">Calories Today</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $nutritionSummary['calories'] }}</p>
                    @if($nutritionGoals)
                        <p class="text-sm text-gray-500 mt-1">of {{ $nutritionGoals->target_calories }} goal</p>
                    @else
                        <p class="text-sm text-gray-500 mt-1">No goal set</p>
                    @endif
                </div>
                <div class="h-12 w-12 bg-orange-50 rounded-lg flex items-center justify-center ml-4 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-orange-600">
                        <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Meals Logged -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-600 mb-2">Meals Logged</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $todaysMealLogs->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">Today</p>
                </div>
                <div class="h-12 w-12 bg-orange-50 rounded-lg flex items-center justify-center ml-4 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-orange-600">
                        <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
                        <path d="M7 2v20"/>
                        <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Left Column - Workout & Nutrition -->
        <div class="lg:col-span-2 space-y-6 lg:space-y-8">
            <!-- Today's Workout Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Today's Workout</h2>
                    @if($todaysWorkout)
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($todaysWorkout->status === 'Completed') bg-green-100 text-green-800 border border-green-200
                            @elseif($todaysWorkout->status === 'Scheduled') bg-orange-100 text-orange-800 border border-orange-200
                            @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                            {{ $todaysWorkout->status }}
                        </span>
                    @endif
                </div>

                @if($todaysWorkout)
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="h-12 w-12 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $todaysWorkout->workoutTemplate->name ?? 'Scheduled Workout' }}</h3>
                                <p class="text-gray-600 mt-1">{{ $todaysWorkout->workoutTemplate->description ?? 'Complete your scheduled workout for today.' }}</p>
                                @if($todaysWorkout->user_notes)
                                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-700 italic">Notes: {{ $todaysWorkout->user_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($todaysWorkout->status === 'Scheduled')
                            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                               <a href="{{ route('workouts.today') }}" class="flex-1 bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200 font-medium text-center">
                                    Start Workout
                                </a>
                                <a href="{{ route('workouts.today') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 font-medium text-center">
                                    Skip Today
                                </a>

                            </div>
                        @elseif($todaysWorkout->status === 'Completed')
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-green-800 font-medium">Workout completed!</span>
                                </div>
                                @if($todaysWorkout->completion_date)
                                    <p class="text-green-700 text-sm mt-1 ml-7">Completed at {{ $todaysWorkout->completion_date->format('g:i A') }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.5a1.5 1.5 0 011.5 1.5v1M9 10H6a2 2 0 00-2 2v5a2 2 0 002 2h8a2 2 0 002-2v-5a2 2 0 00-2-2h-3m-6 0V8a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No workout scheduled</h3>
                        <p class="text-gray-600 mb-6">Take a rest day or browse available workouts</p>
                        <button class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                            Browse Workouts
                        </button>
                    </div>
                @endif
            </div>

            <!-- Nutrition Summary Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Today's Nutrition</h2>
                </div>

                @if($nutritionGoals)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <!-- Calories Progress -->
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-medium text-gray-700">Calories</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $nutritionSummary['calories'] }}/{{ $nutritionGoals->target_calories }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-orange-500 h-2.5 rounded-full transition-all duration-300" style="width: {{ min(($nutritionSummary['calories'] / $nutritionGoals->target_calories) * 100, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Protein Progress -->
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-medium text-gray-700">Protein</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $nutritionSummary['protein'] }}g/{{ $nutritionGoals->target_protein_grams }}g</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-orange-400 h-2.5 rounded-full transition-all duration-300" style="width: {{ min(($nutritionSummary['protein'] / $nutritionGoals->target_protein_grams) * 100, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Carbs Progress -->
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-medium text-gray-700">Carbs</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $nutritionSummary['carbs'] }}g/{{ $nutritionGoals->target_carb_grams }}g</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-orange-300 h-2.5 rounded-full transition-all duration-300" style="width: {{ min(($nutritionSummary['carbs'] / $nutritionGoals->target_carb_grams) * 100, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Fat Progress -->
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-medium text-gray-700">Fat</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $nutritionSummary['fat'] }}g/{{ $nutritionGoals->target_fat_grams }}g</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-orange-600 h-2.5 rounded-full transition-all duration-300" style="width: {{ min(($nutritionSummary['fat'] / $nutritionGoals->target_fat_grams) * 100, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="h-12 w-12 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 mb-4">No nutrition goals set</p>
                        <button class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                            Set Goals
                        </button>
                    </div>
                @endif

                <!-- Recent Meals -->
                @if($todaysMealLogs->count() > 0)
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-4">Recent Meals</h3>
                        <div class="space-y-3">
                            @foreach($todaysMealLogs->take(3) as $mealLog)
                                <div class="flex items-center justify-between py-3 px-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2M7 2v20M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 capitalize">{{ $mealLog->meal_type }}</p>
                                            <p class="text-xs text-gray-600">{{ $mealLog->mealLogEntries->count() }} {{ $mealLog->mealLogEntries->count() === 1 ? 'item' : 'items' }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 flex-shrink-0">{{ $mealLog->created_at->format('g:i A') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Fitness Fact & Motivation -->
        <div class="space-y-6 lg:space-y-8">
            <!-- Fitness Fact Card -->
            @if($fitnessFact)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-6">
                    <div class="flex items-start space-x-4">
                        <div class="h-12 w-12 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Fitness Tip</h3>
                            <p class="text-gray-700 text-sm leading-relaxed mb-4">{{ $fitnessFact->fact_text }}</p>
                            @if($fitnessFact->category)
                                <span class="inline-block px-3 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded-full border border-orange-200">
                                    {{ $fitnessFact->category }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Motivational Quote Card -->
            @if($fitnessMotivation)
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl shadow-sm border border-orange-200 hover:shadow-md transition-shadow duration-200 p-6">
                    <div class="text-center">
                        <div class="h-12 w-12 bg-orange-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-6 w-6 text-orange-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                            </svg>
                        </div>
                        <blockquote class="text-gray-800 font-medium text-base italic mb-4 leading-relaxed">
                            "{{ $fitnessMotivation->quote }}"
                        </blockquote>
                        @if($fitnessMotivation->author)
                            <cite class="text-gray-700 text-sm font-medium">— {{ $fitnessMotivation->author }}</cite>
                        @endif
                    </div>
                </div>
            @else
                <!-- Fallback motivation card -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl shadow-sm border border-orange-200 p-6">
                    <div class="text-center">
                        <div class="h-12 w-12 bg-orange-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-6 w-6 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <p class="text-center text-sm text-gray-600 italic">Stay motivated! Your fitness journey matters.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection