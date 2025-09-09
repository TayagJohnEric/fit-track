@extends('layout.user')
@section('title', 'Today\'s Workout')
@section('content')
<div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Success/Info Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-8 flex items-center">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-8 flex items-center">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            {{ session('info') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Today's Workout</h1>
            <p class="text-gray-600">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('workouts.history') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                View History
            </a>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
        <!-- Left Column: Workout Info (3/4 width on xl screens) -->
        <div class="xl:col-span-3 space-y-8">
            <!-- Workout Header Card -->
            <div class="rounded-xl  overflow-hidden">
                <div class="p-8">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $scheduledWorkout->workoutTemplate->name }}</h2>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    @if($scheduledWorkout->status == 'Scheduled') bg-amber-100 text-amber-700
                                    @elseif($scheduledWorkout->status == 'Completed') bg-emerald-100 text-emerald-700
                                    @else bg-gray-100  text-gray-700 @endif">
                                    {{ $scheduledWorkout->status }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-md leading-relaxed">{{ $scheduledWorkout->workoutTemplate->description }}</p>
                        </div>
                    </div>
                    
                    <!-- Workout Stats Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="text-center p-6 bg-gray-100 rounded-xl">
                            <div class="text-2xl font-bold text-gray-900 mb-1">{{ $scheduledWorkout->workoutTemplate->duration_minutes }}</div>
                            <div class="text-sm font-semibold text-gray-600 tracking-wide">Minutes</div>
                        </div>
                        <div class="text-center p-6 bg-gray-100 rounded-xl">
                            <div class="text-2xl font-bold text-green-900 mb-1">{{ $scheduledWorkout->workoutTemplate->exercises->count() }}</div>
                            <div class="text-sm font-semibold text-gray-600 tracking-wide">Exercises</div>
                        </div>
                        <div class="text-center p-6 bg-gray-100 rounded-xl">
                            <div class="text-2xl font-bold text-gray-900 mb-1">{{ $scheduledWorkout->workoutTemplate->difficulty_level }}/5</div>
                            <div class="text-sm font-semibold text-gray-600 tracking-wide">Difficulty</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exercise List Card -->
            <div class=" overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-xl font-bold text-gray-900">Exercise List</h3>
                        <span class="text-sm font-semibold text-gray-600 bg-gray-100 px-4 py-2 rounded-full">
                            {{ $scheduledWorkout->workoutTemplate->exercises->count() }} exercises
                        </span>
                    </div>
                    
                    @if($scheduledWorkout->workoutTemplate->exercises->count() > 0)
                        <div class="space-y-4">
                            @foreach($scheduledWorkout->workoutTemplate->exercises as $index => $exercise)
                               <a href="{{ route('workouts.exercise.show', [$scheduledWorkout->id, $exercise->id]) }}" 
   class="block bg-white shadow-sm border border-gray-100 rounded-xl hover:bg-orange-50 hover:border-orange-200 transition-all duration-200 p-6 group hover:shadow-md">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center gap-3">
            <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-800 rounded-full flex items-center justify-center text-sm font-bold">
                {{ $index + 1 }}
            </span>
            <h4 class="text-lg font-semibold text-gray-900 group-hover:text-orange-800 transition-colors">
                {{ $exercise->name }}
            </h4>
        </div>
        <span class="flex-shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white text-gray-700 border border-gray-200">
            {{ $exercise->muscle_group }}
        </span>
    </div>
    
    <p class="text-gray-600 mb-6 leading-relaxed">{{ Str::limit($exercise->description, 120) }}</p>
    
    <!-- Exercise Details Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="flex items-center text-gray-700 bg-white rounded-lg px-4 py-3 border border-gray-200">
            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ $exercise->pivot->sets }} sets</span>
        </div>
        <div class="flex items-center text-gray-700 bg-white rounded-lg px-4 py-3 border border-gray-200">
            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span class="font-semibold text-sm">{{ $exercise->pivot->reps }} reps</span>
        </div>
        <div class="flex items-center text-gray-700 bg-white rounded-lg px-4 py-3 border border-gray-200">
            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ $exercise->pivot->rest_seconds }}s rest</span>
        </div>
        <div class="flex items-center text-gray-700 bg-white rounded-lg px-4 py-3 border border-gray-200">
            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <span class="font-semibold text-sm">{{ $exercise->equipment_needed }}</span>
        </div>
    </div>
</a>

                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No exercises found</h3>
                            <p class="text-gray-600">No exercises found for this workout.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Action Panel (1/4 width on xl screens) -->
        @if($scheduledWorkout->status == 'Scheduled')
            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Workout Actions</h3>
                    
                    <!-- Complete Workout Form -->
                    <form action="{{ route('workouts.complete', $scheduledWorkout->id) }}" method="POST" class="mb-6">
                        @csrf
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-3">
                                Notes (Optional)
                            </label>
                            <textarea name="notes" id="notes" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none transition-colors" 
                                      placeholder="How did your workout go?"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full bg-orange-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                            <span class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                                Mark as Complete
                            </span>
                        </button>
                    </form>
                    
                    <!-- Skip Workout Form -->
                    <form action="{{ route('workouts.skip', $scheduledWorkout->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-white text-gray-700 border border-gray-300 py-3 px-4 rounded-lg font-semibold hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
                                onclick="return confirm('Are you sure you want to skip this workout?')">
                            <span class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <path d="M18 6 6 18"/>
                                    <path d="m6 6 12 12"/>
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
@endsection