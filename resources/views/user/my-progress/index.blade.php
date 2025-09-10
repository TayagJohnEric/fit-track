@extends('layout.user')

@section('title', 'My Progress')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Header Section -->
        <div class="rounded-lg p-6 mb-6 text-black">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                 <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-1">
                    My Progress
                </h1>
                <p class="text-gray-600 text-sm sm:text-md">Track your journey and celebrate your achievements</p>
            </div>
            
            <!-- Controls -->
            <div class="flex flex-col sm:flex-row gap-3">
                <form method="GET" action="{{ route('progress.index') }}" class="flex gap-2">
                   <div class="relative inline-block">
                        <svg class="text-gray-800 absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 pointer-events-none" 
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 2v4"/>
                            <path d="M16 2v4"/>
                            <rect width="18" height="18" x="3" y="4" rx="2"/>
                            <path d="M3 10h18"/>
                        </svg>

                        <select name="date_range" onchange="this.form.submit()"
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-black appearance-none">
                            <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>Last 3 Months</option>
                            <option value="all" {{ $dateRange == 'all' ? 'selected' : '' }}>All Time</option>
                        </select>
                    </div>
                </form>
                
                <button onclick="openWeightModal()" class="text-white bg-gray-900 hover:bg-gray-800 text-black px-4 py-2 rounded-lg font-medium transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Log Weight
                </button>
            </div>
        </div>
    </div>


    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Quick Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Weight Change</p>
                    @php
                        $displayChange = $weightData['weight_change'];
                        if (isset($weightData['recent_change']) && $weightData['recent_change'] !== null && (float) $displayChange === 0.0) {
                            $displayChange = $weightData['recent_change'];
                        }
                    @endphp
                    <p class="text-lg font-semibold {{ $displayChange <= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $displayChange >= 0 ? '+' : '' }}{{ number_format($displayChange, 1) }} kg
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Nutrition Consistency</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $nutritionData['consistency_score'] }}%</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Workout Adherence</p>
                    <p class="text-lg font-semibold  text-gray-800">{{ $workoutData['adherence_rate'] }}%</p>
                </div>
            </div>
        </div>

       <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Days Tracked</p>
                    <p class="text-lg font-semibold  text-gray-800">{{ $nutritionData['total_days'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Weight & Body Composition Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        Weight & Body Composition
                    </h2>
                    <div class="flex gap-2">
                        <button onclick="toggleChart('weight')" id="weightBtn" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg font-medium">Weight</button>
                        @if($weightData['has_height'])
                        <button onclick="toggleChart('bmi')" id="bmiBtn" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg font-medium">BMI</button>
                        @endif
                    </div>
                </div>
                
                <!-- Weight Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4">
                        <div class="text-orange-600 text-sm font-medium">Starting Weight</div>
                        <div class="text-2xl font-bold text-orange-800">{{ number_format($weightData['starting_weight'], 1) }} kg</div>
                        @if($weightData['has_height'])
                        <div class="text-sm text-orange-600">BMI: {{ number_format($weightData['starting_bmi'], 1) }}</div>
                        @endif
                    </div>
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4">
                        <div class="text-orange-600 text-sm font-medium">Current Weight</div>
                        <div class="text-2xl font-bold text-orange-800">{{ number_format($weightData['current_weight'], 1) }} kg</div>
                        @if($weightData['has_height'])
                        <div class="text-sm text-orange-600">BMI: {{ number_format($weightData['current_bmi'], 1) }}</div>
                        @endif
                    </div>
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4">
                        <div class="text-orange-600 text-sm font-medium">Total Change</div>
                        @php
                            $displayChange = $weightData['weight_change'];
                            if (isset($weightData['recent_change']) && $weightData['recent_change'] !== null && (float) $displayChange === 0.0) {
                                $displayChange = $weightData['recent_change'];
                            }
                        @endphp
                        <div class="text-2xl font-bold {{ $displayChange <= 0 ? 'text-orange-800' : 'text-red-800' }}">
                            {{ $displayChange >= 0 ? '+' : '' }}{{ number_format($displayChange, 1) }} kg
                        </div>
                        <div class="text-sm text-orange-600">
                            {{ $displayChange >= 0 ? 'Gained' : 'Lost' }} weight
                        </div>
                    </div>
                </div>

                <!-- Charts Container -->
                <div class="space-y-6">
                    <!-- Weight Chart -->
                    <div id="weightChartContainer">
                        <h3 class="text-lg font-medium text-gray-700 mb-3">Weight Trend</h3>
                        <div class="bg-gray-50 rounded-lg p-4 h-64">
                            <canvas id="weightChart"></canvas>
                        </div>
                    </div>

                    <!-- BMI Chart -->
                    @if($weightData['has_height'])
                    <div id="bmiChartContainer" class="hidden">
                        <h3 class="text-lg font-medium text-gray-700 mb-3">BMI Trend</h3>
                        <div class="bg-gray-50 rounded-lg p-4 h-64">
                            <canvas id="bmiChart"></canvas>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Nutrition Goal Adherence -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Nutrition Goals
                </h2>
                
                @if($nutritionData['has_goals'])
                    <!-- Consistency Score -->
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-orange-600 text-sm font-medium">Consistency Score</div>
                                <div class="text-2xl font-bold text-orange-800">{{ $nutritionData['consistency_score'] }}%</div>
                                <div class="text-sm text-orange-600">{{ $nutritionData['consistent_days'] }}/{{ $nutritionData['total_days'] }} days on track</div>
                            </div>
                            <div class="w-16 h-16">
                                <div class="relative w-full h-full">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                        <path class="text-orange-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="text-orange-600" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="{{ $nutritionData['consistency_score'] }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Adherence (resets daily) -->
                    @if(isset($nutritionData['today']))
                    <div class="bg-white border border-orange-100 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <div class="text-orange-600 text-sm font-medium">Today's Adherence</div>
                                <div class="text-xs text-gray-500">Resets automatically every day</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Calories</div>
                                <div class="text-lg font-semibold text-orange-800">{{ $nutritionData['today']['adherence']['calories'] ?? 0 }}%</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div class="bg-orange-50 rounded-lg p-3">
                                <div class="flex justify-between text-sm text-gray-700">
                                    <span>Protein</span>
                                    <span class="font-semibold text-orange-800">{{ $nutritionData['today']['adherence']['protein'] ?? 0 }}%</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ number_format($nutritionData['today']['protein'] ?? 0, 0) }} / {{ number_format($nutritionData['goals']['protein'] ?? 0, 0) }} g</div>
                            </div>
                            <div class="bg-orange-50 rounded-lg p-3">
                                <div class="flex justify-between text-sm text-gray-700">
                                    <span>Carbs</span>
                                    <span class="font-semibold text-orange-800">{{ $nutritionData['today']['adherence']['carbs'] ?? 0 }}%</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ number_format($nutritionData['today']['carbs'] ?? 0, 0) }} / {{ number_format($nutritionData['goals']['carbs'] ?? 0, 0) }} g</div>
                            </div>
                            <div class="bg-orange-50 rounded-lg p-3">
                                <div class="flex justify-between text-sm text-gray-700">
                                    <span>Fat</span>
                                    <span class="font-semibold text-orange-800">{{ $nutritionData['today']['adherence']['fat'] ?? 0 }}%</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ number_format($nutritionData['today']['fat'] ?? 0, 0) }} / {{ number_format($nutritionData['goals']['fat'] ?? 0, 0) }} g</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Progress Bars -->
                    <div class="space-y-4">
                        @php
                            $macros = [
                                'calories' => ['color' => 'orange', 'unit' => 'kcal'],
                                'protein' => ['color' => 'orange', 'unit' => 'g'],
                                'carbs' => ['color' => 'orange', 'unit' => 'g'],
                                'fat' => ['color' => 'orange', 'unit' => 'g']
                            ];
                        @endphp
                        
                        @foreach($macros as $macro => $config)
                            @php
                                $average = $nutritionData['averages'][$macro] ?? 0;
                                $goal = $nutritionData['goals'][$macro] ?? 1;
                                $percentage = $goal > 0 ? min(($average / $goal) * 100, 100) : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700 capitalize">{{ $macro }}</span>
                                    <span class="text-sm text-gray-500">{{ number_format($average, 1) }}/{{ number_format($goal, 1) }} {{ $config['unit'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-{{ $config['color'] }}-500 h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ number_format($percentage, 1) }}% of goal</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500 mb-4">No nutrition goals set yet</p>
                        <a href="/nutrition/goals" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                            Set Goals
                        </a>
                    </div>
                @endif
            </div>


            <!-- Workout Streaks -->
            @if(isset($streak))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Workout Streaks
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4">
                        <div class="text-orange-600 text-sm font-medium">Current Streak</div>
                        <div class="text-2xl font-bold text-orange-800">{{ $streak['current_streak'] ?? 0 }} days</div>
                    </div>
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4">
                        <div class="text-orange-600 text-sm font-medium">Longest Streak</div>
                        <div class="text-2xl font-bold text-orange-800">{{ $streak['longest_streak'] ?? 0 }} days</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Progress Insights -->
            @if(isset($insights) && count($insights) > 0)
           <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Insights
                </h2>
                
                <div class="space-y-3">
                    @foreach($insights as $insight)
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 mt-0.5 {{ $insight['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($insight['icon'] === 'trending-up')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            @elseif($insight['icon'] === 'trending-down')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            @elseif($insight['icon'] === 'check-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @elseif($insight['icon'] === 'exclamation-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            @elseif($insight['icon'] === 'x-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @elseif($insight['icon'] === 'lightning-bolt')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            @elseif($insight['icon'] === 'clock')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @endif
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700">{{ $insight['message'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Include Weight Modal -->
@include('user.my-progress.modal.weight-modal')

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
// Chart data from PHP
const weightData = {!! json_encode($weightData['history']) !!};
const bmiData = {!! json_encode($weightData['bmi_data']) !!};

// Chart configurations
let weightChart, bmiChart;

// Initialize charts
document.addEventListener('DOMContentLoaded', function() {
    initializeWeightChart();
    @if($weightData['has_height'])
    initializeBMIChart();
    @endif
});

function initializeWeightChart() {
    const ctx = document.getElementById('weightChart').getContext('2d');
    
    weightChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: weightData.map(item => item.date),
            datasets: [{
                label: 'Weight (kg)',
                data: weightData.map(item => item.weight),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + ' kg';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    hoverBackgroundColor: 'rgb(59, 130, 246)'
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

@if($weightData['has_height'])
function initializeBMIChart() {
    const ctx = document.getElementById('bmiChart').getContext('2d');
    
    bmiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: bmiData.map(item => item.date),
            datasets: [{
                label: 'BMI',
                data: bmiData.map(item => item.bmi),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(34, 197, 94)',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(1);
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    hoverBackgroundColor: 'rgb(34, 197, 94)'
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}
@endif

// Chart toggle functionality
function toggleChart(chartType) {
    const weightBtn = document.getElementById('weightBtn');
    const bmiBtn = document.getElementById('bmiBtn');
    const weightContainer = document.getElementById('weightChartContainer');
    const bmiContainer = document.getElementById('bmiChartContainer');
    
    if (chartType === 'weight') {
        weightBtn.className = 'px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg font-medium';
        if (bmiBtn) bmiBtn.className = 'px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg font-medium';
        weightContainer.classList.remove('hidden');
        if (bmiContainer) bmiContainer.classList.add('hidden');
    } else if (chartType === 'bmi') {
        if (bmiBtn) bmiBtn.className = 'px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg font-medium';
        weightBtn.className = 'px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg font-medium';
        if (bmiContainer) bmiContainer.classList.remove('hidden');
        weightContainer.classList.add('hidden');
    }
}

// Weight modal functions (these are already in the modal file, but keeping for reference)
function openWeightModal() {
    document.getElementById('weightModal').classList.remove('hidden');
    document.getElementById('weight').focus();
}

function closeWeightModal() {
    document.getElementById('weightModal').classList.add('hidden');
    document.getElementById('weightForm').reset();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('weightModal');
    if (event.target == modal) {
        closeWeightModal();
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeWeightModal();
    }
});

// Add smooth scrolling for better UX
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll to top when clicking on progress cards
    const progressCards = document.querySelectorAll('.bg-white.rounded-lg.shadow-md');
    progressCards.forEach(card => {
        card.addEventListener('click', function() {
            if (this.scrollIntoView) {
                this.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
    
    // Add loading states for form submissions
    const weightForm = document.getElementById('weightForm');
    if (weightForm) {
        weightForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Logging...
                `;
            }
        });
    }
});

// Add responsive chart resizing
window.addEventListener('resize', function() {
    if (weightChart) {
        weightChart.resize();
    }
    if (bmiChart) {
        bmiChart.resize();
    }
});

// Add tooltip enhancements for better UX
function enhanceTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg';
            tooltip.textContent = this.getAttribute('title');
            tooltip.style.left = e.pageX + 10 + 'px';
            tooltip.style.top = e.pageY - 10 + 'px';
            document.body.appendChild(tooltip);
            
            this.addEventListener('mouseleave', function() {
                document.body.removeChild(tooltip);
            }, { once: true });
        });
    });
}

// Initialize tooltips when DOM is loaded
document.addEventListener('DOMContentLoaded', enhanceTooltips);
</script>

@endsection