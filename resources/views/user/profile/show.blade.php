@extends('layout.user')

@section('title', 'Profile & Settings')

@section('content')
<div class="min-h-screen">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 rounded-lg shadow-sm">
                <div class="flex items-center p-4">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

       <!-- Header Section with Profile Image -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-8 py-12">
        <div class="flex flex-col sm:flex-row items-center sm:items-end space-y-6 sm:space-y-0 sm:space-x-8">
            <!-- Profile Image -->
            <div class="relative group">
                <div class="w-32 h-32 rounded-full bg-gray-100 border border-gray-200 overflow-hidden shadow-md">
                    @if($user->profile_image_url)
                        <img src="{{ asset('storage/' . $user->profile_image_url) }}" 
                             alt="{{ $user->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-orange-200 to-orange-300">
                            <svg class="w-16 h-16 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <!-- Hover overlay for future edit functionality -->
                <div class="absolute inset-0 rounded-full bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>

            <!-- User Info -->
            <div class="text-center sm:text-left flex-1">
                <h1 class="text-3xl lg:text-4xl font-bold text-black mb-2">
                    {{ $userProfile->first_name }} {{ $userProfile->last_name }}
                </h1>
                <p class="text-gray-700 text-lg mb-4">{{ $user->email }}</p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-200 transition-all duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                    <a href="{{ route('profile.change-password') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-black font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-200 border border-gray-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Left Column - Personal & Physical -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Personal Information Card -->
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
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>
                               
                                    <p class="text-gray-900 font-medium">{{ $userProfile->first_name }}</p>
                               
                            </div>
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>
                                    <p class="text-gray-900 font-medium">{{ $userProfile->last_name }}</p>
                            </div>
                        </div>
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Display Name</label>
                                <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth</label>
                                    <p class="text-gray-900 font-medium">{{ $userProfile->date_of_birth->format('F j, Y') }}</p>
                            </div>
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Sex</label>
                                    <p class="text-gray-900 font-medium">{{ $userProfile->sex }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Physical Stats Card -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-white px-6 py-4">
                       <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            Physical Stats
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Height</label>
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50/50 px-4 py-3 rounded-xl border border-green-100 group-hover:border-green-200 transition-colors">
                                    <p class="text-gray-900 font-medium flex items-center">
                                        <span class="text-2xl font-bold text-green-600 mr-2">{{ $userProfile->height_cm }}</span>
                                        <span class="text-green-600">cm</span>
                                    </p>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Weight</label>
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50/50 px-4 py-3 rounded-xl border border-green-100 group-hover:border-green-200 transition-colors">
                                    <p class="text-gray-900 font-medium flex items-center">
                                        <span class="text-2xl font-bold text-green-600 mr-2">{{ $userProfile->current_weight_kg }}</span>
                                        <span class="text-green-600">kg</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Daily Budget</label>
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50/50 px-4 py-3 rounded-xl border border-green-100 group-hover:border-green-200 transition-colors">
                                <p class="text-gray-900 font-medium flex items-center">
                                    @if($userProfile->daily_budget)
                                        <span class="text-2xl font-bold text-green-600 mr-2">${{ number_format($userProfile->daily_budget, 2) }}</span>
                                        <span class="text-green-600">per day</span>
                                    @else
                                        <span class="text-gray-500 italic">Not set</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Fitness & Allergies -->
            <div class="space-y-8">
                <!-- Fitness Preferences Card -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-white- px-6 py-4">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            Fitness Goals
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Fitness Goal</label>
                                <p class="text-gray-900 font-medium">{{ $userProfile->fitnessGoal->name }}</p>
                        </div>
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Experience Level</label>
                                <p class="text-gray-900 font-medium">{{ $userProfile->experienceLevel->name }}</p>
                        </div>
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Workout</label>
                                <p class="text-gray-900 font-medium">{{ $userProfile->preferredWorkoutType->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Allergies Card -->
                <div class="bg-white rounded-2xl shadow-md  overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            Allergies
                        </h3>
                    </div>
                    <div class="p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Known Allergies</label>
                        <div class="bg-gradient-to-r from-red-50 to-rose-50/50 px-4 py-4 rounded-xl border border-red-100 min-h-[80px]">
                            @if($userAllergies->count() > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($userAllergies as $allergy)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-red-100 to-rose-100 text-red-800 border border-red-200 shadow-sm">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $allergy->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex items-center justify-center h-12">
                                    <p class="text-gray-500 text-sm italic flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        No allergies specified
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-12 bg-white rounded-2xl shadow-md  overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-orange-50/30 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Last updated: <span class="font-medium ml-1">{{ $userProfile->last_profile_update->format('F j, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="mt-3 sm:mt-0 flex items-center text-xs text-gray-500">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                        Profile is up to date
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection