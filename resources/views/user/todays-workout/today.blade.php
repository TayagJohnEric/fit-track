@extends('layout.user')
@section('title', 'Today\'s Workout')
@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Success/Info Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-6">
            {{ session('info') }}
        </div>
    @endif

    <!-- Workout Header with Action Buttons -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
            <!-- Workout Info -->
            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Today's Workout</h1>
                        <h2 class="text-lg sm:text-xl text-gray-700 font-semibold mb-2">{{ $scheduledWorkout->workoutTemplate->name }}</h2>
                        <p class="text-gray-600 text-sm sm:text-base">{{ $scheduledWorkout->workoutTemplate->description }}</p>
                    </div>
                    <div class="flex-shrink-0">    
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium 
                            @if($scheduledWorkout->status == 'Scheduled') bg-amber-50 text-amber-700 border border-amber-200
                            @elseif($scheduledWorkout->status == 'Completed') bg-emerald-50 text-emerald-700 border border-emerald-200
                            @else bg-gray-50 text-gray-700 border border-gray-200 @endif">
                            {{ $scheduledWorkout->status }}
                        </span>
                    </div>
                </div>
                
                <!-- Workout Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-orange-50 rounded-lg border border-orange-100">
                        <div class="text-xl sm:text-2xl font-bold text-orange-600">{{ $scheduledWorkout->workoutTemplate->duration_minutes }}</div>
                        <div class="text-xs sm:text-sm text-gray-600 font-medium">Minutes</div>
                    </div>
                    <div class="text-center p-4 bg-emerald-50 rounded-lg border border-emerald-100">
                        <div class="text-xl sm:text-2xl font-bold text-emerald-600">{{ $scheduledWorkout->workoutTemplate->exercises->count() }}</div>
                        <div class="text-xs sm:text-sm text-gray-600 font-medium">Exercises</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-100">
                        <div class="text-xl sm:text-2xl font-bold text-purple-600">{{ $scheduledWorkout->workoutTemplate->difficulty_level }}/5</div>
                        <div class="text-xs sm:text-sm text-gray-600 font-medium">Difficulty</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Relocated to header for better UX -->
            @if($scheduledWorkout->status == 'Scheduled')
                <div class="flex-shrink-0 w-full lg:w-80">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Workout Actions</h3>
                        
                        <!-- Complete Workout Form -->
                        <form action="{{ route('workouts.complete', $scheduledWorkout->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="notes" class="block text-xs font-medium text-gray-700 mb-2">
                                    Notes (Optional)
                                </label>
                                <textarea name="notes" id="notes" rows="2" 
                                          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none" 
                                          placeholder="How did it go?"></textarea>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-emerald-600 text-white py-2.5 px-4 rounded-lg font-medium text-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                <span class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Mark as Completed
                                </span>
                            </button>
                        </form>
                        
                        <!-- Skip Workout Form -->
                        <form action="{{ route('workouts.skip', $scheduledWorkout->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-gray-600 text-white py-2.5 px-4 rounded-lg font-medium text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
                                    onclick="return confirm('Are you sure you want to skip this workout?')">
                                <span class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Skip Workout
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

   <!-- Exercise List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-900">Exercise List</h3>
        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
            {{ $scheduledWorkout->workoutTemplate->exercises->count() }} exercises
        </span>
    </div>
    
    @if($scheduledWorkout->workoutTemplate->exercises->count() > 0)
        <div class="space-y-4">
            @foreach($scheduledWorkout->workoutTemplate->exercises as $exercise)
                <a href="{{ route('workouts.exercise.show', [$scheduledWorkout->id, $exercise->id]) }}" class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-6 group">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-3">
                                <h4 class="font-semibold text-gray-900 text-lg group-hover:text-orange-700 transition-colors">{{ $exercise->name }}</h4>
                                <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    {{ $exercise->muscle_group }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 mb-4 text-sm leading-relaxed">{{ Str::limit($exercise->description, 100) }}</p>
                            
                            <!-- Exercise Details -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                                <div class="flex items-center text-gray-600 bg-gray-50 rounded-lg px-3 py-2">
                                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $exercise->pivot->sets }} sets</span>
                                </div>
                                <div class="flex items-center text-gray-600 bg-gray-50 rounded-lg px-3 py-2">
                                    <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <span class="font-medium">{{ $exercise->pivot->reps }} reps</span>
                                </div>
                                <div class="flex items-center text-gray-600 bg-gray-50 rounded-lg px-3 py-2">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $exercise->pivot->rest_seconds }}s rest</span>
                                </div>
                                <div class="flex items-center text-gray-600 bg-gray-50 rounded-lg px-3 py-2">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <span class="font-medium">{{ $exercise->equipment_needed }}</span>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No exercises found</h3>
            <p class="mt-1 text-sm text-gray-500">No exercises found for this workout.</p>
        </div>
    @endif
</div>
</div>
@endsection