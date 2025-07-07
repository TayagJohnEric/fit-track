@extends('layout.user')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
   <!-- Welcome Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">
        {{ $showWelcomeMessage ? 'Welcome to your dashboard, ' : 'Welcome back, ' }}{{ auth()->user()->name }}!
    </h1>
    <p class="text-gray-600 mt-2">Here's your fitness overview for {{ date('F j, Y') }}</p>
</div>


    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Today's Workout Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Today's Workout</p>
                    @if($todaysWorkout)
                        <p class="text-2xl font-bold text-gray-800">{{ $todaysWorkout->status }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $todaysWorkout->workoutTemplate->name ?? 'Workout Scheduled' }}</p>
                    @else
                        <p class="text-2xl font-bold text-gray-400">No Workout</p>
                        <p class="text-sm text-gray-500 mt-1">Rest day</p>
                    @endif
                </div>
                <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-gray-500 lucide lucide-dumbbell-icon lucide-dumbbell"><path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/><path d="m2.5 21.5 1.4-1.4"/><path d="m20.1 3.9 1.4-1.4"/><path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/><path d="m9.6 14.4 4.8-4.8"/></svg>
                </div>
            </div>
        </div>

        <!-- Weekly Progress -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Weekly Progress</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $weeklyWorkoutStats['completion_rate'] }}%</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $weeklyWorkoutStats['completed'] }}/{{ $weeklyWorkoutStats['total'] }} workouts</p>
                </div>
                <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-gray-500 group-hover:lucide lucide-activity-icon lucide-activity"><path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"/></svg>           
                </div>
            </div>
        </div>

        <!-- Calories Today -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Calories Today</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $nutritionSummary['calories'] }}</p>
                    @if($nutritionGoals)
                        <p class="text-sm text-gray-500 mt-1">of {{ $nutritionGoals->target_calories }} goal</p>
                    @else
                        <p class="text-sm text-gray-500 mt-1">No goal set</p>
                    @endif
                </div>
                <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-gray-500 lucide lucide-flame-icon lucide-flame"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                </div>
            </div>
        </div>

        <!-- Meals Logged -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Meals Logged</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $todaysMealLogs->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">Today</p>
                </div>
                <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-gray-500 lucide lucide-utensils-icon lucide-utensils"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Workout & Nutrition -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Today's Workout Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Today's Workout</h2>
                    @if($todaysWorkout)
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($todaysWorkout->status === 'Completed') bg-gray-200 text-gray-600
                            @elseif($todaysWorkout->status === 'Scheduled') bg-gray-200 text-gray-600
                            @else bg-gray-200 text-gray-800 @endif">
                            {{ $todaysWorkout->status }}
                        </span>
                    @endif
                </div>

                @if($todaysWorkout)
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $todaysWorkout->workoutTemplate->name ?? 'Scheduled Workout' }}</h3>
                                <p class="text-gray-600 mt-1">{{ $todaysWorkout->workoutTemplate->description ?? 'Complete your scheduled workout for today.' }}</p>
                                @if($todaysWorkout->user_notes)
                                    <p class="text-sm text-gray-500 mt-2 italic">Notes: {{ $todaysWorkout->user_notes }}</p>
                                @endif
                            </div>
                        </div>

                        @if($todaysWorkout->status === 'Scheduled')
                            <div class="flex space-x-3">
                                <button class="flex-1 bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                    Start Workout
                                </button>
                                <button class="px-4 py-2 border border-gray-300 text-gray-800 rounded-lg hover:bg-gray-50 transition-colors">
                                    Skip Today
                                </button>
                            </div>
                        @elseif($todaysWorkout->status === 'Completed')
                            <div class="bg-green-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-800 font-medium">Workout completed!</span>
                                </div>
                                @if($todaysWorkout->completion_date)
                                    <p class="text-gray-700 text-sm mt-1">Completed at {{ $todaysWorkout->completion_date->format('g:i A') }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.5a1.5 1.5 0 011.5 1.5v1M9 10H6a2 2 0 00-2 2v5a2 2 0 002 2h8a2 2 0 002-2v-5a2 2 0 00-2-2h-3m-6 0V8a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No workout scheduled</h3>
                        <p class="text-gray-600 mb-4">Take a rest day or browse available workouts</p>
                        <button class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                            Browse Workouts
                        </button>
                    </div>
                @endif
            </div>

            <!-- Nutrition Summary Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Today's Nutrition</h2>
<button class="flex items-center gap-1 text-gray-600 hover:text-gray-800 hover:bg-gray-100 text-sm font-medium px-3 py-2 rounded">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
    <circle cx="12" cy="12" r="3"/>
  </svg>
  View Details
</button>

                </div>

                @if($nutritionGoals)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Calories Progress -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Calories</span>
                                <span class="text-sm text-gray-600">{{ $nutritionSummary['calories'] }}/{{ $nutritionGoals->target_calories }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gray-600 h-2 rounded-full" style="width: {{ min(($nutritionSummary['calories'] / $nutritionGoals->target_calories) * 100, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Protein Progress -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Protein</span>
                                <span class="text-sm text-gray-600">{{ $nutritionSummary['protein'] }}g/{{ $nutritionGoals->target_protein_grams }}g</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gray-600 h-2 rounded-full" style="width: {{ min(($nutritionSummary['protein'] / $nutritionGoals->target_protein_grams) * 100, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Carbs Progress -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Carbs</span>
                                <span class="text-sm text-gray-600">{{ $nutritionSummary['carbs'] }}g/{{ $nutritionGoals->target_carb_grams }}g</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gray-600 h-2 rounded-full" style="width: {{ min(($nutritionSummary['carbs'] / $nutritionGoals->target_carb_grams) * 100, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Fat Progress -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Fat</span>
                                <span class="text-sm text-gray-600">{{ $nutritionSummary['fat'] }}g/{{ $nutritionGoals->target_fat_grams }}g</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gray-600 h-2 rounded-full" style="width: {{ min(($nutritionSummary['fat'] / $nutritionGoals->target_fat_grams) * 100, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-600 mb-4">No nutrition goals set</p>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Set Goals
                        </button>
                    </div>
                @endif

                <!-- Recent Meals -->
                @if($todaysMealLogs->count() > 0)
                    <div class="border-t pt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Recent Meals</h3>
                        <div class="space-y-2">
                            @foreach($todaysMealLogs->take(3) as $mealLog)
                                <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $mealLog->meal_type }}</p>
                                            <p class="text-xs text-gray-600">{{ $mealLog->mealLogEntries->count() }} items</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $mealLog->created_at->format('g:i A') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Fitness Fact -->
        <div class="space-y-8">
            <!-- Fitness Fact Card -->
            @if($fitnessFact)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start space-x-3">
                        <div class="h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Fitness Tip</h3>
                            <p class="text-gray-800 text-sm leading-relaxed">{{ $fitnessFact->fact_text }}</p>
                            @if($fitnessFact->category)
                                <span class="inline-block mt-3 px-2 py-1 bg-gray-200 text-gray-800 text-xs rounded-full">
                                    {{ $fitnessFact->category }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Motivational Quote Card -->
@if($fitnessMotivation)
<div class="bg-gray-100 rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="text-center">
        <svg class="h-8 w-8 text-gray-600 mx-auto mb-3" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
        </svg>
        <blockquote class="text-gray-800 font-medium text-sm italic mb-2">
            "{{ $fitnessMotivation->quote }}"
        </blockquote>
        @if($fitnessMotivation->author)
            <cite class="text-gray-600 text-xs">- {{ $fitnessMotivation->author }}</cite>
        @endif
    </div>
</div>
@else
<!-- Optional: Fallback if no quote is found -->
<p class="text-center text-sm text-gray-500">No motivation found today. Try again later!</p>
@endif

        </div>
    </div>

</div>
@endsection