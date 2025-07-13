@extends('layout.user')
@section('title', $exercise->name . ' - Exercise Details')
@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('workouts.today') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Workout
        </a>
    </div>

    <!-- Exercise Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $exercise->name }}</h1>
                <div class="flex items-center text-sm text-blue-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    {{ $exercise->muscle_group }}
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ $scheduledWorkout->workoutTemplate->name }}
                </span>
            </div>
        </div>
        
        <!-- Exercise Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $exercise->pivot->sets }}</div>
                <div class="text-sm text-gray-500">Sets</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $exercise->pivot->reps }}</div>
                <div class="text-sm text-gray-500">Reps</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $exercise->pivot->rest_seconds }}s</div>
                <div class="text-sm text-gray-500">Rest</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600">
                    @if($exercise->pivot->duration_seconds)
                        {{ $exercise->pivot->duration_seconds }}s
                    @else
                        N/A
                    @endif
                </div>
                <div class="text-sm text-gray-500">Duration</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Exercise Video -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Exercise Demonstration</h3>
            
            @if($exercise->video_url)
                <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden mb-4">
                    @if(str_contains($exercise->video_url, 'youtube.com') || str_contains($exercise->video_url, 'youtu.be'))
                        @php
                            $videoId = '';
                            if (str_contains($exercise->video_url, 'youtube.com/watch?v=')) {
                                $videoId = substr($exercise->video_url, strpos($exercise->video_url, 'v=') + 2);
                                $videoId = strpos($videoId, '&') ? substr($videoId, 0, strpos($videoId, '&')) : $videoId;
                            } elseif (str_contains($exercise->video_url, 'youtu.be/')) {
                                $videoId = substr($exercise->video_url, strpos($exercise->video_url, 'youtu.be/') + 9);
                                $videoId = strpos($videoId, '?') ? substr($videoId, 0, strpos($videoId, '?')) : $videoId;
                            }
                        @endphp
                        @if($videoId)
                            <iframe 
                                src="https://www.youtube.com/embed/{{ $videoId }}" 
                                frameborder="0" 
                                allowfullscreen
                                class="w-full h-full">
                            </iframe>
                        @else
                            <div class="flex items-center justify-center h-full">
                                <a href="{{ $exercise->video_url }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 underline">
                                    Watch Video
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="flex items-center justify-center h-full">
                            <a href="{{ $exercise->video_url }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m2-10l-2 2m0 0l-2-2m2 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h8l2 2z"></path>
                                </svg>
                                Watch Video
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="aspect-video bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                    <div class="text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <p>No video available</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Exercise Instructions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Exercise Instructions</h3>
            
            <div class="prose prose-sm max-w-none">
                <p class="text-gray-700 mb-6">{{ $exercise->description }}</p>
            </div>
            
            <!-- Equipment Needed -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-gray-800 mb-2">Equipment Needed:</h4>
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    {{ $exercise->equipment_needed }}
                </div>
            </div>
            
            <!-- Exercise Tips -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="font-semibold text-blue-800 mb-2">Tips for Success:</h4>
                <ul class="text-blue-700 text-sm space-y-1">
                    <li>• Focus on proper form over speed</li>
                    <li>• Control your breathing throughout the movement</li>
                    <li>• Rest fully between sets for optimal performance</li>
                    <li>• Listen to your body and stop if you feel pain</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <div class="flex gap-4">
            <a href="{{ route('workouts.today') }}" 
               class="flex-1 bg-gray-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-gray-700 transition-colors text-center">
                Back to Workout
            </a>
            
            @if($scheduledWorkout->status == 'Scheduled')
                <form action="{{ route('workouts.complete', $scheduledWorkout->id) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-green-700 transition-colors">
                        Mark Workout as Complete
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection