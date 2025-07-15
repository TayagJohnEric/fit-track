@extends('layout.user')

@section('title', 'Profile & Settings')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Profile & Settings</h2>
                <p class="text-gray-600 mt-1">Manage your personal information and account settings</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Profile
                </a>
                <a href="{{ route('profile.change-password') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Change Password
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->first_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->last_name }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                        <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $user->email }}</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->date_of_birth->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sex</label>
                            <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->sex }}</p>
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Height</label>
                            <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->height_cm }} cm</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Weight</label>
                            <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->current_weight_kg }} kg</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Daily Budget</label>
                        <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">
                            @if($userProfile->daily_budget)
                                ${{ number_format($userProfile->daily_budget, 2) }}
                            @else
                                Not set
                            @endif
                        </p>
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fitness Goal</label>
                        <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->fitnessGoal->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                        <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->experienceLevel->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Workout Type</label>
                        <p class="text-gray-900 bg-white px-3 py-2 rounded-md border">{{ $userProfile->preferredWorkoutType->name }}</p>
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Known Allergies</label>
                    <div class="bg-white px-3 py-2 rounded-md border min-h-[42px]">
                        @if($userAllergies->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($userAllergies as $allergy)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ $allergy->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No allergies specified</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Last Updated -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                Last updated: {{ $userProfile->last_profile_update->format('F j, Y \a\t g:i A') }}
            </p>
        </div>
    </div>
</div>
@endsection