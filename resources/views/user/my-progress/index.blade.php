@extends('layout.user')

@section('title', 'Progress Dashboard')

@section('content')
    <div class="max-w-[90rem] mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Your Fitness Progress</h2>
                    <p class="text-gray-600">Track your weight, BMI, and fitness journey over time</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('progress.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Log New Weight
                    </a>
                </div>
            </div>
        </div>

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
                        class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
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
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Current Weight</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($userProfile->current_weight_kg ?? 0, 1) }} kg</p>
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
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Current BMI</h3>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($progressMetrics['current_bmi'], 1) }}</p>
                        <p class="text-sm text-gray-600">{{ $progressMetrics['bmi_category'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Days Tracked -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800">Days Tracked</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $progressMetrics['days_tracked'] }}</p>
                    </div>
                </div>
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

        <!-- Insights Section -->
        @if($insights)
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Progress Insights</h3>
                <div class="space-y-3">
                    @foreach($insights as $insight)
                        <div class="flex items-start space-x-3 p-3 rounded-lg 
                            {{ $insight['type'] === 'success' ? 'bg-green-50 border-l-4 border-green-400' : 
                               ($insight['type'] === 'warning' ? 'bg-yellow-50 border-l-4 border-yellow-400' : 'bg-blue-50 border-l-4 border-blue-400') }}">
                            <div class="flex-shrink-0">
                                @if($insight['type'] === 'success')
                                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @elseif($insight['type'] === 'warning')
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <p class="text-sm {{ $insight['type'] === 'success' ? 'text-green-700' : 
                                  ($insight['type'] === 'warning' ? 'text-yellow-700' : 'text-blue-700') }}">
                                {{ $insight['message'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Weight History Table -->
        @if($weightHistory->isNotEmpty())
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Weight Entries</h3>
                    <p class="text-sm text-gray-600">{{ $weightHistory->count() }} entries found</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight (kg)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BMI</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($weightHistory->reverse() as $index => $entry)
                                @php
                                    $bmi = 0;
                                    if ($userProfile && $userProfile->height_cm > 0) {
                                        $heightM = $userProfile->height_cm / 100;
                                        $bmi = $entry->weight_kg / ($heightM * $heightM);
                                    }
                                    
                                    $previousEntry = $weightHistory->reverse()->get($index + 1);
                                    $weightChange = $previousEntry ? $entry->weight_kg - $previousEntry->weight_kg : 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->log_date->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ number_format($entry->weight_kg, 1) }} kg
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $bmi > 0 ? number_format($bmi, 1) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($weightChange != 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $weightChange > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $weightChange > 0 ? '+' : '' }}{{ number_format($weightChange, 1) }} kg
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('progress.edit', $entry->id) }}" 
                                               class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <button onclick="deleteWeightEntry({{ $entry->id }})" 
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No weight entries found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by logging your first weight entry.</p>
                    <div class="mt-6">
                        <a href="{{ route('progress.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Log Your First Weight
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <script>
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