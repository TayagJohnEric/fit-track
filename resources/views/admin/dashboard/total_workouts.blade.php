@extends('layout.admin')
@section('title', 'Total Workouts Logged')
@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Total Workouts Logged</h1>
                    <p class="mt-2 text-sm text-gray-600">Monitor and track completed workouts across your platform</p>
                </div>
                <div class="hidden sm:flex items-center space-x-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-medium text-gray-700">Live Activity</span>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Workouts</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $workouts->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Completed Today</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $filter === 'day' ? $workouts->count() : '--' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Avg. Per User</p>
                        <p class="text-2xl font-bold text-gray-900">2.4</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Card Header with Filters -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Workout Activity</h2>
                        <p class="mt-1 text-sm text-gray-500">Filter completed workouts by time period</p>
                    </div>
                    
                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-2">
                        @foreach (['day' => 'Today', 'week' => 'This Week', 'month' => 'This Month'] as $key => $label)
                            <a href="{{ route('admin.total-workouts', ['filter' => $key]) }}"
                               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2
                                      {{ $filter === $key 
                                         ? 'bg-orange-600 text-white shadow-md hover:bg-orange-700' 
                                         : 'bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                                @if($key === 'day')
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                @elseif($key === 'week')
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                @endif
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Workouts Table -->
            <div class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>User</span>
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>Workout</span>
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>Completed</span>
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($workouts as $index => $workout)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-sm font-medium text-gray-600">
                                            {{ $workouts->firstItem() + $index }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                                                    <span class="text-sm font-semibold text-white">
                                                        {{ strtoupper(substr(optional($workout->user->userProfile)->first_name ?? $workout->user->name ?? $workout->user->email, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ optional($workout->user->userProfile)->first_name }}
                                                    {{ optional($workout->user->userProfile)->last_name ?? $workout->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">ID: {{ $workout->user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 mr-3">
                                                <div class="h-8 w-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $workout->template->name ?? 'N/A' }}
                                                </div>
                                                @if($workout->template)
                                                    <div class="text-xs text-gray-500">Template ID: {{ $workout->template->id }}</div>
                                                @else
                                                    <div class="text-xs text-red-500">Template not found</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">
                                            {{ $workout->completion_date->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $workout->completion_date->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $hoursAgo = $workout->completion_date->diffInHours(now());
                                        @endphp
                                        @if($hoursAgo < 2)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5 animate-pulse"></div>
                                                Fresh
                                            </span>
                                        @elseif($hoursAgo < 24)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <div class="w-1.5 h-1.5 bg-orange-400 rounded-full mr-1.5"></div>
                                                Today
                                            </span>
                                        @elseif($hoursAgo < 168)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1.5"></div>
                                                This Week
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <div class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></div>
                                                Older
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            <h3 class="text-sm font-medium text-gray-900 mb-1">No workouts logged</h3>
                                            <p class="text-sm text-gray-500">No workouts have been completed during the selected time period.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($workouts->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($workouts->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $workouts->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    Previous
                                </a>
                            @endif

                            @if ($workouts->hasMorePages())
                                <a href="{{ $workouts->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    Next
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    Next
                                </span>
                            @endif
                        </div>

                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5">
                                    Showing
                                    <span class="font-medium">{{ $workouts->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $workouts->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $workouts->total() }}</span>
                                    results
                                </p>
                            </div>

                            <div>
                                {{ $workouts->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection