@extends('layout.onboarding')

@section('title', 'Welcome to FitnessApp!')
@section('subtitle', 'Your profile is all set up!')

@section('content')
<div class="text-center space-y-6">
    <!-- Success Icon -->
    <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <!-- Success Message -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            🎉 Congratulations!
        </h2>
        <p class="text-gray-600">
            Your profile has been created successfully. We've prepared a personalized fitness and nutrition plan just for you.
        </p>
    </div>

    <!-- What's Next -->
    <div class="bg-blue-50 rounded-lg p-6 text-left">
        <h3 class="font-semibold text-blue-900 mb-3">What happens next?</h3>
        <div class="space-y-2 text-sm text-blue-800">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Your personalized workout schedule has been created</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Your nutrition goals have been calculated</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Meal recommendations will consider your allergies and budget</span>
            </div>
        </div>
    </div>

    <!-- User Info Summary -->
    @if(auth()->user()->userProfile)
    <div class="bg-gray-50 rounded-lg p-4 text-left">
        <h3 class="font-semibold text-gray-900 mb-3">Your Profile Summary</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Goal:</span>
                <span class="font-medium ml-2">{{ auth()->user()->userProfile->fitnessGoal->name }}</span>
            </div>
            <div>
                <span class="text-gray-600">Level:</span>
                <span class="font-medium ml-2">{{ auth()->user()->userProfile->experienceLevel->name }}</span>
            </div>
            <div>
                <span class="text-gray-600">Workout:</span>
                <span class="font-medium ml-2">{{ auth()->user()->userProfile->preferredWorkoutType->name }}</span>
            </div>
            <div>
                <span class="text-gray-600">Weight:</span>
                <span class="font-medium ml-2">{{ auth()->user()->userProfile->current_weight_kg }} kg</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="space-y-3">
        <a href="{{ route('dashboard') }}" 
           class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 block text-center">
            Go to Dashboard
        </a>
        
        <p class="text-xs text-gray-500">
            You can always update your preferences later in your profile settings
        </p>
    </div>

    <!-- Motivational Quote -->
    <div class="border-t pt-6">
        <blockquote class="text-sm italic text-gray-600">
            "The journey of a thousand miles begins with one step."
        </blockquote>
        <p class="text-xs text-gray-500 mt-1">— Lao Tzu</p>
    </div>
</div>
@endsection