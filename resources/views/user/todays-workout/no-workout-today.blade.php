@extends('layout.user')
@section('title', 'No Workout Today')
@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-gray-50  p-6">
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-4">No Workout Scheduled for Today</h2>
            <p class="text-gray-600 mb-6">
                It looks like you don't have any workout scheduled for today. 
                Take this time to rest and recover, or check back tomorrow for your next workout!
            </p>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ route('workouts.history') }}" 
                   class="inline-flex items-center px-6 py-3 bg-orange-600 text-white text-sm font-medium rounded-md hover:bg-orange-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    View Workout History
                </a>
                
                
            </div>
        </div>
    </div>
</div>
@endsection