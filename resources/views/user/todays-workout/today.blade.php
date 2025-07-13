@extends('layout.user')
@section('title', 'Today\'s Workout')
@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Success/Info Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
            {{ session('info') }}
        </div>
    @endif

    <!-- Workout Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Today's Workout</h1>
                <h2 class="text-xl text-gray-600 mb-2">{{ $scheduledWorkout->workoutTemplate->name }}</h2>
                <p class="text-gray-500">{{ $scheduledWorkout->workoutTemplate->description }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    @if($scheduledWorkout->status == 'Scheduled') bg-yellow-100 text-yellow-800
                    @elseif($scheduledWorkout->status == 'Completed') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ $scheduledWorkout->status }}
                </span>
            </div>
        </div>
        
        <!-- Workout Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $scheduledWorkout->workoutTemplate->duration_minutes }}</div>
                <div class="text-sm text-gray-500">Minutes</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $scheduledWorkout->workoutTemplate->exercises->count() }}</div>
                <div class="text-sm text-gray-500">Exercises</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $scheduledWorkout->workoutTemplate->difficulty_level }}/5</div>
                <div class="text-sm text-gray-500">Difficulty</div>
            </div>
        </div>
    </div>

    <!-- Exercise List -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Exercise List</h3>
        
        @if($scheduledWorkout->workoutTemplate->exercises->count() > 0)
            <div class="space-y-4">
                @foreach($scheduledWorkout->workoutTemplate->exercises as $exercise)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 mb-2">{{ $exercise->name }}</h4>
                                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($exercise->description, 100) }}</p>
                                
                                <!-- Exercise Details -->
                                <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-3">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        {{ $exercise->pivot->sets }} sets
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        {{ $exercise->pivot->reps }} reps
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $exercise->pivot->rest_seconds }}s rest
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        {{ $exercise->equipment_needed }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center text-sm text-blue-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ $exercise->muscle_group }}
                                </div>
                            </div>
                            
                            <div class="ml-4">
                                <a href="{{ route('workouts.exercise.show', [$scheduledWorkout->id, $exercise->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No exercises found for this workout.</p>
        @endif
        
        <!-- Action Buttons -->
        @if($scheduledWorkout->status == 'Scheduled')
            <div class="flex gap-4 mt-8 pt-6 border-t">
                <form action="{{ route('workouts.complete', $scheduledWorkout->id) }}" method="POST" class="flex-1">
                    @csrf
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Workout Notes (Optional)
                        </label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                  placeholder="How did the workout go? Any notes about your performance..."></textarea>
                    </div>
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-green-700 transition-colors">
                        Mark as Completed
                    </button>
                </form>
                
                <form action="{{ route('workouts.skip', $scheduledWorkout->id) }}" method="POST" class="flex-1">
                    @csrf
                    <div class="mb-4">
                        <div class="h-20"></div> <!-- Spacer to align with complete button -->
                    </div>
                    <button type="submit" 
                            class="w-full bg-gray-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-gray-700 transition-colors"
                            onclick="return confirm('Are you sure you want to skip this workout?')">
                        Skip Workout
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection