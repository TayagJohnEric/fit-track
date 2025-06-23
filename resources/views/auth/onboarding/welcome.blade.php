@extends('layout.onboarding')

@section('title', 'Welcome')
@section('subtitle', 'Welcome to your fitness journey!')

@section('content')
<div class="text-center space-y-6">
    <!-- Welcome Icon -->
    <div class="mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
    </div>

    <!-- Welcome Text -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            Welcome, {{ auth()->user()->name }}!
        </h2>
        <p class="text-gray-600">
            Let's set up your profile to create a personalized fitness and nutrition plan just for you.
        </p>
    </div>

    <!-- Features List -->
    <div class="space-y-3 text-left">
        <div class="flex items-center space-x-3">
            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-gray-700">Personalized workout plans</span>
        </div>
        
        <div class="flex items-center space-x-3">
            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-gray-700">Custom nutrition goals</span>
        </div>
        
        <div class="flex items-center space-x-3">
            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-gray-700">Progress tracking</span>
        </div>
    </div>

    <!-- CTA Button -->
    <div class="pt-4">
        <a href="{{ route('onboarding.step1') }}" 
           class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 block text-center">
            Let's Get Started
        </a>
    </div>

    <!-- Note -->
    <p class="text-xs text-gray-500">
        This will only take a few minutes
    </p>
</div>
@endsection