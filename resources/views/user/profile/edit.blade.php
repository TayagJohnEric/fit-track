@extends('layout.user')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen ">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-8 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-400 rounded-lg shadow-sm">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Please fix the following errors:</h3>
                            <ul class="mt-2 text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-8">
            <div class="bg-white px-8 py-8">
                <div class="flex flex-col sm:flex-row items-center sm:items-center sm:justify-between">
                    <div class="text-center sm:text-left">
                        <h1 class="text-xl lg:text-3xl font-bold text-gray-900 mb-2">Edit Profile</h1>
                        <p class="text-gray-600 text-md">Update your personal information and preferences</p>
                    </div>

                   <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200">
                   Profile
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-orange-600">Edit Profile</span>
                </div>
            </li>
        </ol>
    </nav>     

                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Profile Image Upload Section -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="bg-white px-6 py-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        Profile Picture
                    </h3>
                </div>
                <div class="p-8">
                    <div class="flex flex-col sm:flex-row items-center space-y-6 sm:space-y-0 sm:space-x-8">
                        <!-- Current Profile Image -->
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 rounded-full overflow-hidden shadow-lg border-4 border-gray-100 bg-gradient-to-br from-orange-100 to-orange-200">
                                @if($user->profile_image_url ?? false)
                                    <img src="{{ asset('storage/' . $user->profile_image_url) }}" 
                                         alt="Current profile picture" 
                                         id="current-avatar"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-orange-200 to-orange-300" id="current-avatar">
                                        <svg class="w-16 h-16 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Upload Section -->
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Update Profile Picture</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="profile_image_url" class="flex flex-col items-center justify-center w-full h-32 border-2 border-indigo-300 border-dashed rounded-xl cursor-pointer bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 transition-all duration-200">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-indigo-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-indigo-600 font-semibold">Click to upload</p>
                                        <p class="text-xs text-indigo-400">PNG, JPG or JPEG (MAX. 2MB)</p>
                                    </div>
                                    <input id="profile_image_url" name="profile_image_url" type="file" class="hidden" accept="image/*" onchange="previewImage(event)"/>
                                </label>
                            </div>
                            @error('profile_image_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

           <!-- Personal Information -->
<div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="bg-white px-6 py-4">
        <h3 class="text-xl font-bold text-gray-800 flex items-center">
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            Personal Information
        </h3>
    </div>
    <div class="p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>
                <input type="text" 
                       name="first_name" 
                       id="first_name" 
                       value="{{ old('first_name', $userProfile->first_name) }}"
                       class="w-full px-4 py-3 bg-gray-100 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 transition-all duration-200 @error('first_name') border border-red-400 bg-red-50 @enderror"
                       required>
                @error('first_name')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>
                <input type="text" 
                       name="last_name" 
                       id="last_name" 
                       value="{{ old('last_name', $userProfile->last_name) }}"
                       class="w-full px-4 py-3 bg-gray-100 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 transition-all duration-200 @error('last_name') border border-red-400 bg-red-50 @enderror"
                       required>
                @error('last_name')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Display Name</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-3 bg-gray-100 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 transition-all duration-200 @error('name') border border-red-400 bg-red-50 @enderror"
                   required>
            @error('name')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-3 bg-gray-100 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 transition-all duration-200 @error('email') border border-red-400 bg-red-50 @enderror"
                   required>
            @error('email')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth</label>
                <input type="date" 
                       name="date_of_birth" 
                       id="date_of_birth" 
                       value="{{ old('date_of_birth', $userProfile->date_of_birth->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 bg-gray-100 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 transition-all duration-200 @error('date_of_birth') border border-red-400 bg-red-50 @enderror"
                       required>
                @error('date_of_birth')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="sex" class="block text-sm font-semibold text-gray-700 mb-2">Sex</label>
                <select name="sex" 
                        id="sex" 
                        class="w-full px-4 py-3 bg-gray-100 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 transition-all duration-200 @error('sex') border border-red-400 bg-red-50 @enderror"
                        required>
                    <option value="">Select Sex</option>
                    <option value="Male" {{ old('sex', $userProfile->sex) === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sex', $userProfile->sex) === 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('sex', $userProfile->sex) === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('sex')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>
</div>

            <!-- Physical Stats (Read-only) -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="bg-white px-6 py-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        Physical Stats
                        <span class="ml-3 px-3 py-1 text-xs font-semibold border border-gray-300 bg-white/20 rounded-full">Read-only</span>
                    </h3>
                </div>
                <div class="p-8">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50/50 border border-green-200 rounded-xl p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-3 bg-green-100 rounded-full">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 mb-1">Height</p>
                                <p class="text-2xl font-bold text-green-600">{{ $userProfile->height_cm }} <span class="text-sm font-normal">cm</span></p>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-3 bg-green-100 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 h-8 text-green-600 lucide lucide-weight-icon lucide-weight"><circle cx="12" cy="5" r="3"/><path d="M6.5 8a2 2 0 0 0-1.905 1.46L2.1 18.5A2 2 0 0 0 4 21h16a2 2 0 0 0 1.925-2.54L19.4 9.5A2 2 0 0 0 17.48 8Z"/></svg>                                </div>
                                <p class="text-sm font-semibold text-gray-700 mb-1">Current Weight</p>
                                <p class="text-2xl font-bold text-green-600">{{ $userProfile->current_weight_kg }} <span class="text-sm font-normal">kg</span></p>
                            </div>
                            @if($userProfile->daily_budget)
                            <div class="text-center">
                                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-3 bg-green-100 rounded-full">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-green-600 lucide lucide-arrow-up-icon lucide-arrow-up"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 mb-1">Daily Budget</p>
                                <p class="text-2xl font-bold text-green-600">${{ number_format($userProfile->daily_budget, 2) }}</p>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>

           <!-- Fitness Preferences -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
    <div class="bg-white px-6 py-4">
        <h3 class="text-xl font-bold text-gray-900 flex items-center">
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            Fitness Preferences
        </h3>
    </div>
    <div class="p-8 space-y-6">
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <div class="text-sm text-amber-800">
                    <p class="font-semibold mb-1">Important Notice:</p>
                    <p>Changing your fitness preferences will automatically update your nutrition goals and workout schedule based on your new selections.</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <label for="fitness_goal_id" class="block text-sm font-semibold text-gray-700 mb-2">Fitness Goal</label>
                <select name="fitness_goal_id" 
                        id="fitness_goal_id" 
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('fitness_goal_id') border-red-400 bg-red-50 @enderror"
                        required>
                    <option value="">Select Fitness Goal</option>
                    @foreach($fitnessGoals as $goal)
                        <option value="{{ $goal->id }}" {{ old('fitness_goal_id', $userProfile->fitness_goal_id) == $goal->id ? 'selected' : '' }}>
                            {{ $goal->name }}
                        </option>
                    @endforeach
                </select>
                @error('fitness_goal_id')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="experience_level_id" class="block text-sm font-semibold text-gray-700 mb-2">Experience Level</label>
                <select name="experience_level_id" 
                        id="experience_level_id" 
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('experience_level_id') border-red-400 bg-red-50 @enderror"
                        required>
                    <option value="">Select Experience Level</option>
                    @foreach($experienceLevels as $level)
                        <option value="{{ $level->id }}" {{ old('experience_level_id', $userProfile->experience_level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('experience_level_id')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="preferred_workout_type_id" class="block text-sm font-semibold text-gray-700 mb-2">Preferred Workout Type</label>
                <select name="preferred_workout_type_id" 
                        id="preferred_workout_type_id" 
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('preferred_workout_type_id') border-red-400 bg-red-50 @enderror"
                        required>
                    <option value="">Select Workout Type</option>
                    @foreach($workoutTypes as $type)
                        <option value="{{ $type->id }}" {{ old('preferred_workout_type_id', $userProfile->preferred_workout_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('preferred_workout_type_id')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    </div>
</div>


            <!-- Allergies -->
            <div class="bg-white rounded-2xl shadow-md  overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="bg-white px-6 py-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        Allergies & Dietary Restrictions
                    </h3>
                </div>
                <div class="p-8">
                    <div class="mb-6">
                        <p class="text-gray-600 bg-gradient-to-r from-red-50 to-rose-50 border border-red-100 rounded-xl p-4">
                            <svg class="w-5 h-5 inline mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Select any allergies or dietary restrictions you have. This will help us customize your meal recommendations and ensure your safety.
                        </p>
                    </div>
                    
                    @if($allergies->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($allergies as $allergy)
                                <label class="relative flex items-center p-4 bg-gradient-to-r from-red-50 to-rose-50/50 border border-red-100 rounded-xl cursor-pointer hover:from-red-100 hover:to-rose-100 transition-all duration-200 group">
                                    <input type="checkbox" 
                                           name="allergies[]" 
                                           id="allergy_{{ $allergy->id }}" 
                                           value="{{ $allergy->id }}"
                                           class="h-5 w-5 text-red-600 border-red-300 rounded focus:ring-red-500 focus:ring-2"
                                           {{ in_array($allergy->id, old('allergies', $userAllergies->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-red-700 transition-colors">
                                        {{ $allergy->name }}
                                    </span>
                                    <svg class="w-4 h-4 ml-auto text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-6 text-center">
                            <svg class="w-12 h-12 mx-auto mb-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <p class="text-yellow-800 font-medium mb-2">No allergies available</p>
                            <p class="text-sm text-yellow-700">No allergies are currently available in the system. Please contact support if you need to add specific allergies.</p>
                        </div>
                    @endif
                    
                    @error('allergies')
                        <p class="mt-4 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="px-8 py-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <!-- Primary Actions -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-500/50 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 transform">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Profile
                            </button>
                            <a href="{{ route('profile.show') }}" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 font-semibold rounded-xl hover:from-gray-200 hover:to-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-500/50 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 transform">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel Changes
                            </a>
                        </div>

                        <!-- Secondary Actions & Info -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <a href="{{ route('profile.change-password') }}" 
                               class="text-orange-600 hover:text-orange-800 font-semibold transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Change Password
                            </a>
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Last updated: {{ $userProfile->last_profile_update ? $userProfile->last_profile_update->format('M j, Y g:i A') : 'Never' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview functionality
function previewImage(event) {
    const file = event.target.files[0];
    const currentAvatar = document.getElementById('current-avatar');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            currentAvatar.innerHTML = `<img src="${e.target.result}" alt="Profile preview" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    }
}

// Form validation and user experience enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to submit button
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function() {
        submitButton.innerHTML = `
            <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Updating Profile...
        `;
        submitButton.disabled = true;
    });
    
    // Enhanced form field interactions
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-orange-500/20');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-orange-500/20');
        });
    });
});
</script>
@endsection