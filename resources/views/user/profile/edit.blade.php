@extends('layout.user')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Please fix the following errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Edit Profile</h2>
                <p class="text-gray-600 mt-1">Update your personal information and preferences</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Profile
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Personal Information
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" 
                                   name="first_name" 
                                   id="first_name" 
                                   value="{{ old('first_name', $userProfile->first_name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror"
                                   required>
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" 
                                   name="last_name" 
                                   id="last_name" 
                                   value="{{ old('last_name', $userProfile->last_name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror"
                                   required>
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input type="date" 
                                   name="date_of_birth" 
                                   id="date_of_birth" 
                                   value="{{ old('date_of_birth', $userProfile->date_of_birth->format('Y-m-d')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-500 @enderror"
                                   required>
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="sex" class="block text-sm font-medium text-gray-700 mb-1">Sex</label>
                            <select name="sex" 
                                    id="sex" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('sex') border-red-500 @enderror"
                                    required>
                                <option value="">Select Sex</option>
                                <option value="Male" {{ old('sex', $userProfile->sex) === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex', $userProfile->sex) === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('sex', $userProfile->sex) === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('sex')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Physical Stats -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Physical Stats
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="height_cm" class="block text-sm font-medium text-gray-700 mb-1">Height (cm)</label>
                            <input type="number" 
                                   name="height_cm" 
                                   id="height_cm" 
                                   value="{{ old('height_cm', $userProfile->height_cm) }}"
                                   step="0.1"
                                   min="50"
                                   max="300"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('height_cm') border-red-500 @enderror"
                                   required>
                            @error('height_cm')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="current_weight_kg" class="block text-sm font-medium text-gray-700 mb-1">Current Weight (kg)</label>
                            <input type="number" 
                                   name="current_weight_kg" 
                                   id="current_weight_kg" 
                                   value="{{ old('current_weight_kg', $userProfile->current_weight_kg) }}"
                                   step="0.1"
                                   min="20"
                                   max="500"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_weight_kg') border-red-500 @enderror"
                                   required>
                            @error('current_weight_kg')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="daily_budget" class="block text-sm font-medium text-gray-700 mb-1">Daily Budget ($) <span class="text-gray-500">(optional)</span></label>
                        <input type="number" 
                               name="daily_budget" 
                               id="daily_budget" 
                               value="{{ old('daily_budget', $userProfile->daily_budget) }}"
                               step="0.01"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('daily_budget') border-red-500 @enderror">
                        @error('daily_budget')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Fitness Preferences -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Fitness Preferences
                </h3>
                <div class="space-y-4">
                    <div>
                        <label for="fitness_goal_id" class="block text-sm font-medium text-gray-700 mb-1">Fitness Goal</label>
                        <select name="fitness_goal_id" 
                                id="fitness_goal_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('fitness_goal_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Fitness Goal</option>
                            @foreach($fitnessGoals as $goal)
                                <option value="{{ $goal->id }}" {{ old('fitness_goal_id', $userProfile->fitness_goal_id) == $goal->id ? 'selected' : '' }}>
                                    {{ $goal->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('fitness_goal_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="experience_level_id" class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                        <select name="experience_level_id" 
                                id="experience_level_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('experience_level_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Experience Level</option>
                            @foreach($experienceLevels as $level)
                                <option value="{{ $level->id }}" {{ old('experience_level_id', $userProfile->experience_level_id) == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('experience_level_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="preferred_workout_type_id" class="block text-sm font-medium text-gray-700 mb-1">Preferred Workout Type</label>
                        <select name="preferred_workout_type_id" 
                                id="preferred_workout_type_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('preferred_workout_type_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Workout Type</option>
                            @foreach($workoutTypes as $type)
                                <option value="{{ $type->id }}" {{ old('preferred_workout_type_id', $userProfile->preferred_workout_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('preferred_workout_type_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Allergies -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Allergies
                </h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Known Allergies</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($allergies as $allergy)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="allergies[]" 
                                       value="{{ $allergy->id }}"
                                       id="allergy_{{ $allergy->id }}"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                       {{ in_array($allergy->id, old('allergies', $userAllergies->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label for="allergy_{{ $allergy->id }}" class="ml-2 text-sm text-gray-700">
                                    {{ $allergy->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('allergies')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-gray-200">
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 bg-white rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection