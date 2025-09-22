@extends('layout.user')

@section('title', 'Progress Dashboard')

@section('content')

<style>
    .modal-overlay {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    transform: scale(0.7) translateY(-50px);
    opacity: 0;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
}

.modal-overlay.show .modal-content {
    transform: scale(1) translateY(0);
    opacity: 1;
}

.modal-overlay.closing {
    opacity: 0;
    visibility: hidden;
}

.modal-overlay.closing .modal-content {
    transform: scale(0.7) translateY(-50px);
    opacity: 0;
}

</style>


    <div class="max-w-[90rem] mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-2xl font-bold text-gray-800 ">Your Fitness Progress</h2>
                    <p class="text-gray-600">Track your weight, BMI, and fitness journey over time</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Log Weight Button -->
                  <button type="button"
                        onclick="openCreateModal()"
                        class="inline-flex items-center px-4 py-2 bg-orange-600 border border-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 hover:border-orage-600 transition-all duration-200 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                            class="text-white w-4 h-4 mr-2 lucide lucide-plus">
                            <path d="M5 12h14"/>
                            <path d="M12 5v14"/>
                        </svg>
                        Log New Weight
                    </button>


            <a href="{{ route('progress.weight-history') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2 lucide lucide-calendar-check-icon lucide-calendar-check"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
                Weight History
            </a>
                </div>
            </div>
        </div>

                 @include('user.my-progress.create-modal')


        <!-- Date Range Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Progress Data</h3>
            <form id="dateFilterForm" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit" id="filterButton" 
                        class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 text-sm font-medium rounded-lg  transition-colors">
                    <span class="filter-text">Apply Filter</span>
                    <span class="filter-loading hidden">Filtering...</span>
                </button>
            </form>
        </div>

        <!-- Progress Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Current Weight -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-orange-600 lucide lucide-weight-icon lucide-weight"><circle cx="12" cy="5" r="3"/><path d="M6.5 8a2 2 0 0 0-1.905 1.46L2.1 18.5A2 2 0 0 0 4 21h16a2 2 0 0 0 1.925-2.54L19.4 9.5A2 2 0 0 0 17.48 8Z"/></svg>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Current Weight</h3>
                        <p class="text-2xl font-bold text-orange-600">{{ number_format($userProfile->current_weight_kg ?? 0, 1) }} kg</p>
                    </div>
                </div>
            </div>

            <!-- Weight Change -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 {{ $progressMetrics['weight_change'] >= 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-lg">
                        <svg class="w-6 h-6 {{ $progressMetrics['weight_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($progressMetrics['weight_change'] >= 0)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            @endif
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Weight Change</h3>
                        <p class="text-2xl font-bold {{ $progressMetrics['weight_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $progressMetrics['weight_change'] >= 0 ? '+' : '' }}{{ number_format($progressMetrics['weight_change'], 1) }} kg
                        </p>
                    </div>
                </div>
            </div>

            <!-- Current BMI -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-orange-600 lucide lucide-chart-line-icon lucide-chart-line"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Current BMI</h3>
                        <p class="text-2xl font-bold text-orange-600">{{ number_format($progressMetrics['current_bmi'], 1) }}</p>
                        <p class="text-sm text-gray-600">{{ $progressMetrics['bmi_category'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Days Tracked -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Days Tracked</h3>
                        <p class="text-2xl font-bold text-orange-600">{{ $progressMetrics['days_tracked'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Workout Streak & Goals Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Workout Streak Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Workout Streak</h3>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <!-- Current Streak -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-2xl font-bold text-orange-600">{{ $workoutStreakData['current_streak'] }}</p>
                            <p class="text-sm text-gray-600">Current Streak (days)</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-semibold text-gray-700">{{ $workoutStreakData['longest_streak'] }}</p>
                            <p class="text-sm text-gray-600">Longest Streak</p>
                        </div>
                    </div>
                    
                    <!-- Completion Rate -->
                    <div class="mt-4">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Completion Rate</span>
                            <span class="text-sm text-gray-500">{{ $workoutStreakData['completion_rate'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-600 h-2 rounded-full" style="width: {{ $workoutStreakData['completion_rate'] }}%"></div>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-100">
                        <div class="text-center">
                            <p class="text-lg font-semibold text-gray-800">{{ $workoutStreakData['completed_workouts'] }}</p>
                            <p class="text-xs text-gray-600">Completed</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-semibold text-gray-800">{{ $workoutStreakData['skipped_workouts'] }}</p>
                            <p class="text-xs text-gray-600">Skipped</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-semibold text-gray-800">{{ $workoutStreakData['total_workouts'] }}</p>
                            <p class="text-xs text-gray-600">Total</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Goal Adherence Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Goal Adherence</h3>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                
                @if($goalAdherenceData['goal_type'])
                    <div class="space-y-4">
                        <!-- Goal Status -->
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $goalAdherenceData['status'] }}</p>
                            <p class="text-sm text-gray-600">{{ $goalAdherenceData['goal_type'] }}</p>
                        </div>
                        
                        <!-- Adherence Percentage -->
                        <div class="mt-4">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Progress</span>
                                <span class="text-sm text-gray-500">{{ number_format($goalAdherenceData['adherence_percentage'], 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-600 h-3 rounded-full" style="width: {{ min($goalAdherenceData['adherence_percentage'], 100) }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Progress Details -->
                        <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-100">
                            <div class="text-center">
                                <p class="text-lg font-semibold {{ $goalAdherenceData['weight_progress'] < 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $goalAdherenceData['weight_progress'] >= 0 ? '+' : '' }}{{ number_format($goalAdherenceData['weight_progress'], 1) }}kg
                                </p>
                                <p class="text-xs text-gray-600">Total Change</p>
                            </div>
                            <div class="text-center">
                                <p class="text-lg font-semibold text-gray-800">{{ number_format($goalAdherenceData['actual_rate'], 2) }}</p>
                                <p class="text-xs text-gray-600">kg/week</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No fitness goal set</h3>
                        <p class="mt-1 text-sm text-gray-500">Set a fitness goal to track your adherence.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Nutrition Consistency & Weekly Progress -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Nutrition Consistency -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Nutrition Tracking</h3>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 11-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <!-- Consistency Rate -->
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Consistency</span>
                            <span class="text-sm text-gray-500">{{ $nutritionConsistency['consistency_rate'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-600 h-2 rounded-full" style="width: {{ $nutritionConsistency['consistency_rate'] }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">{{ $nutritionConsistency['days_logged'] }}/{{ $nutritionConsistency['total_days'] }} days logged</p>
                    </div>
                    
                    @if($nutritionConsistency['has_goals'])
                        <!-- Average vs Goals -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-2">Daily Averages</p>
                                <div class="space-y-1">
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Calories:</span>
                                        <span class="text-xs font-medium">{{ $nutritionConsistency['avg_calories'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Protein:</span>
                                        <span class="text-xs font-medium">{{ $nutritionConsistency['avg_protein'] }}g</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Carbs:</span>
                                        <span class="text-xs font-medium">{{ $nutritionConsistency['avg_carbs'] }}g</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Fat:</span>
                                        <span class="text-xs font-medium">{{ $nutritionConsistency['avg_fat'] }}g</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-2">Your Goals</p>
                                <div class="space-y-1">
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Calories:</span>
                                        <span class="text-xs font-medium">{{ $nutritionConsistency['goals']['calories'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Protein:</span>
                                        <span class="text-xs font-medium">{{ $nutritionConsistency['goals']['protein'] }}g</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Carbs:</span>
                                        <span class="text-xs font-medium">{{ $nutritionConsistency['goals']['carbs'] }}g</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-600">Fat:</span>
                                        <span class="text-xs font-medium">{{ $nutritionConsistency['goals']['fat'] }}g</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-sm text-gray-600">Set nutrition goals to compare your progress</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Weekly Progress Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Weekly Progress</h3>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                
                @if(count($weeklyProgress) > 0)
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($weeklyProgress as $week)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">{{ $week['week_start'] }} - {{ $week['week_end'] }}</p>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="text-xs text-gray-600">
                                            Workouts: {{ $week['workouts_completed'] }}/{{ $week['workouts_scheduled'] }}
                                        </span>
                                        <span class="text-xs text-gray-600">
                                            Nutrition: {{ $week['nutrition_days'] }} days
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center space-x-2">
                                        @if($week['weight_change'] != 0)
                                            <span class="text-xs {{ $week['weight_change'] < 0 ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $week['weight_change'] > 0 ? '+' : '' }}{{ number_format($week['weight_change'], 1) }}kg
                                            </span>
                                        @endif
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                            {{ $week['week_score'] >= 80 ? 'bg-green-100 text-green-800' : 
                                               ($week['week_score'] >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $week['week_score'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-600">No weekly data available for the selected period</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Charts Section -->
        @if($chartData['labels'])
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Weight Trend Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Weight Trend</h3>
                    <div class="relative h-64">
                        <canvas id="weightChart"></canvas>
                    </div>
                </div>

                <!-- BMI Trend Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">BMI Trend</h3>
                    <div class="relative h-64">
                        <canvas id="bmiChart"></canvas>
                    </div>
                </div>
            </div>
        @endif


    <!-- Chart.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <script>

  // Create Modal
            function openCreateModal() {
                const modal = document.getElementById('create-modal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => modal.classList.add('show'), 10);
            }

            function closeCreateModal() {
                const modal = document.getElementById('create-modal');
                modal.classList.add('closing');
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex', 'closing');
                }, 300);
            }

            // Edit Modal (requires an ID), same approach in Delete and Show 
                function openEditModal(id) {
                    const modal = document.getElementById(`edit-modal-${id}`);
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    setTimeout(() => modal.classList.add('show'), 10);
                }

                function closeEditModal(id) {
                    const modal = document.getElementById(`edit-modal-${id}`);
                    modal.classList.add('closing');
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex', 'closing');
                    }, 300);
                }

        // Chart data from server
        const chartData = @json($chartData);
        let weightChart, bmiChart;
        
        // Initialize charts if data exists
        if (chartData.labels && chartData.labels.length > 0) {
            initializeCharts();
        }
        
        function initializeCharts() {
            // Weight Chart
            const weightCtx = document.getElementById('weightChart');
            if (weightCtx) {
                weightChart = new Chart(weightCtx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Weight (kg)',
                            data: chartData.weight,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Weight (kg)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
            
            // BMI Chart
            const bmiCtx = document.getElementById('bmiChart');
            if (bmiCtx) {
                bmiChart = new Chart(bmiCtx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'BMI',
                            data: chartData.bmi,
                            borderColor: 'rgb(147, 51, 234)',
                            backgroundColor: 'rgba(147, 51, 234, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'BMI'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        }
        
        // Date filter form handling
        document.getElementById('dateFilterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const filterButton = document.getElementById('filterButton');
            const filterText = filterButton.querySelector('.filter-text');
            const filterLoading = filterButton.querySelector('.filter-loading');
            
            // Show loading state
            filterButton.disabled = true;
            filterText.classList.add('hidden');
            filterLoading.classList.remove('hidden');
            
            // Get form data
            const formData = new FormData(this);
            const params = new URLSearchParams();
            params.append('start_date', formData.get('start_date'));
            params.append('end_date', formData.get('end_date'));
            
            // Redirect with new parameters
            window.location.href = '{{ route("progress.index") }}?' + params.toString();
        });
        
        // Delete weight entry function
        function deleteWeightEntry(entryId) {
            if (!confirm('Are you sure you want to delete this weight entry? This action cannot be undone.')) {
                return;
            }
            
            const deleteUrl = '{{ route('progress.destroy', ['id' => '__ID__']) }}'.replace('__ID__', entryId);
            fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    console.error('Delete failed:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
@endsection