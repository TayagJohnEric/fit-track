@extends('layout.onboarding')

@section('title', 'Step 1 - Personal Information')
@section('subtitle', 'Tell us about yourself')

@section('content')
<div class="space-y-6">
    <!-- Step Header -->
    <div class="text-center">
        <h2 class="text-xl font-bold text-gray-900">Personal Information</h2>
        <p class="text-sm text-gray-600 mt-1">Step 1 of 3</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('onboarding.store.step1') }}" class="space-y-4">
        @csrf

        <!-- Name Fields -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                    First Name
                </label>
                <input type="text" id="first_name" name="first_name" 
                       value="{{ old('first_name', session('onboarding_step1.first_name')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('first_name') border-red-300 @enderror"
                       required>
                @error('first_name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Last Name
                </label>
                <input type="text" id="last_name" name="last_name" 
                       value="{{ old('last_name', session('onboarding_step1.last_name')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('last_name') border-red-300 @enderror"
                       required>
                @error('last_name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Date of Birth -->
        <div>
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
                Date of Birth
            </label>
            <input type="date" id="date_of_birth" name="date_of_birth" 
                   value="{{ old('date_of_birth', session('onboarding_step1.date_of_birth')) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('date_of_birth') border-red-300 @enderror"
                   required>
            @error('date_of_birth')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Sex -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Sex
            </label>
            <div class="grid grid-cols-3 gap-3">
                @foreach(['Male', 'Female', 'Other'] as $sex)
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="sex" value="{{ $sex }}" 
                           class="sr-only peer" 
                           {{ old('sex', session('onboarding_step1.sex')) == $sex ? 'checked' : '' }}
                           required>
                    <div class="w-full px-4 py-2 text-sm font-medium text-center text-gray-700 bg-white border border-gray-300 rounded-lg peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 hover:bg-gray-50 peer-checked:hover:bg-primary-700">
                        {{ $sex }}
                    </div>
                </label>
                @endforeach
            </div>
            @error('sex')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Height and Weight -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="height_cm" class="block text-sm font-medium text-gray-700 mb-1">
                    Height (cm)
                </label>
                <input type="number" id="height_cm" name="height_cm" step="0.1" min="100" max="250"
                       value="{{ old('height_cm', session('onboarding_step1.height_cm')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('height_cm') border-red-300 @enderror"
                       placeholder="e.g., 175"
                       required>
                @error('height_cm')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="current_weight_kg" class="block text-sm font-medium text-gray-700 mb-1">
                    Weight (kg)
                </label>
                <input type="number" id="current_weight_kg" name="current_weight_kg" step="0.1" min="30" max="300"
                       value="{{ old('current_weight_kg', session('onboarding_step1.current_weight_kg')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('current_weight_kg') border-red-300 @enderror"
                       placeholder="e.g., 70"
                       required>
                @error('current_weight_kg')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <a href="{{ route('onboarding.welcome') }}" 
               class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                ← Back
            </a>

            <button type="submit" 
                    class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition duration-200">
                Next Step →
            </button>
        </div>
    </form>
</div>
@endsection