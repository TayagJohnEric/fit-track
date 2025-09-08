@extends('layout.user')
@section('title', 'Workout History')
@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Workout History</h2>
            <div class="flex gap-3">
                <button id="refreshStats" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
                <a href="{{ route('workouts.today') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Today's Workout
                </a>
            </div>
        </div>
        
        @if($workoutHistory->count() > 0)
            <!-- Enhanced Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-6" id="statsCards">
                <!-- Completed Card -->
                <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Completed</p>
                            <p class="text-2xl font-bold text-green-600">{{ $workoutHistory->where('status', 'Completed')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Pending/Scheduled Card -->
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">Pending</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $workoutHistory->whereIn('status', ['Scheduled', 'Pending', 'In Progress'])->count() }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Manually Skipped Card -->
                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">Skipped</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $workoutHistory->where('status', 'Skipped')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Auto-Skipped Card -->
                <div class="bg-orange-50 rounded-lg p-4 border border-orange-100">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-orange-800">Auto-Skipped</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $workoutHistory->where('status', 'Auto-Skipped')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Completion Rate Card -->
                <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-purple-800">Success Rate</p>
                            <p class="text-2xl font-bold text-purple-600">
                                @php
                                    $totalWorkouts = $workoutHistory->whereNotIn('status', ['Pending', 'In Progress', 'Scheduled'])->count();
                                    $completedWorkouts = $workoutHistory->where('status', 'Completed')->count();
                                    $successRate = $totalWorkouts > 0 ? round(($completedWorkouts / $totalWorkouts) * 100) : 0;
                                @endphp
                                {{ $successRate }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter and Sort Options -->
            <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active px-3 py-2 text-sm font-medium rounded-lg border transition-colors" data-status="all">
                        All Workouts
                    </button>
                    <button class="filter-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors" data-status="Completed">
                        Completed
                    </button>
                    <button class="filter-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors" data-status="Skipped">
                        Skipped
                    </button>
                    <button class="filter-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors" data-status="Auto-Skipped">
                        Auto-Skipped
                    </button>
                    <button class="filter-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors" data-status="pending">
                        Pending
                    </button>
                </div>
                
                <div class="flex items-center gap-2">
                    <label for="sortBy" class="text-sm font-medium text-gray-700">Sort by:</label>
                    <select id="sortBy" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="date-desc">Date (Newest)</option>
                        <option value="date-asc">Date (Oldest)</option>
                        <option value="status">Status</option>
                        <option value="completion">Completion Status</option>
                    </select>
                </div>
            </div>
            
            <!-- Workout History List -->
            <div class="space-y-4" id="workoutList">
                @foreach($workoutHistory as $workout)
                    <div class="workout-item border border-gray-200 rounded-lg p-4 transition-all hover:shadow-md" 
                         data-status="{{ $workout->status }}" 
                         data-date="{{ $workout->assigned_date->format('Y-m-d') }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-semibold text-gray-800">{{ $workout->workoutTemplate->name }}</h3>
                                    
                                    <!-- Enhanced Status Badge -->
                                    @if($workout->status == 'Completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Completed
                                        </span>
                                    @elseif($workout->status == 'Skipped')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            Manually Skipped
                                        </span>
                                    @elseif($workout->status == 'Auto-Skipped')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Auto-Skipped
                                        </span>
                                    @elseif(in_array($workout->status, ['Scheduled', 'Pending', 'In Progress']))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $workout->status }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            {{ $workout->status ?? 'Unknown' }}
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-3">{{ $workout->workoutTemplate->description }}</p>
                                
                                <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $workout->assigned_date->format('M d, Y') }}
                                        @if($workout->assigned_date->isToday())
                                            <span class="ml-1 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">Today</span>
                                        @elseif($workout->assigned_date->isYesterday())
                                            <span class="ml-1 px-2 py-0.5 bg-gray-100 text-gray-700 text-xs rounded-full">Yesterday</span>
                                        @elseif($workout->assigned_date->isFuture())
                                            <span class="ml-1 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">Upcoming</span>
                                        @endif
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $workout->workoutTemplate->duration_minutes }} minutes
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Difficulty: {{ $workout->workoutTemplate->difficulty_level }}/5
                                    </span>
                                    @if($workout->completion_date)
                                        <span class="flex items-center text-green-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Completed: {{ $workout->completion_date->format('M d, Y \a\t g:i A') }}
                                        </span>
                                    @elseif($workout->status == 'Auto-Skipped' && $workout->skipped_date)
                                        <span class="flex items-center text-orange-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            Auto-skipped: {{ $workout->skipped_date->format('M d, Y \a\t g:i A') }}
                                        </span>
                                    @elseif($workout->status == 'Skipped' && $workout->skipped_date)
                                        <span class="flex items-center text-yellow-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                                            </svg>
                                            Skipped: {{ $workout->skipped_date->format('M d, Y \a\t g:i A') }}
                                        </span>
                                    @endif
                                </div>
                                
                                @if($workout->user_notes)
                                    <div class="mt-3 p-3 bg-gray-50 rounded-lg border">
                                        <p class="text-sm text-gray-700">
                                            <strong>Notes:</strong> 
                                            @if(str_contains($workout->user_notes, '[Auto-skipped due to inactivity]'))
                                                <span class="text-orange-600">{{ str_replace('[Auto-skipped due to inactivity]', '', $workout->user_notes) }}</span>
                                                <span class="text-orange-500 italic">[Auto-skipped due to inactivity]</span>
                                            @else
                                                {{ $workout->user_notes }}
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="ml-4">
                                @if(in_array($workout->status, ['Scheduled', 'Pending', 'In Progress']) && $workout->assigned_date->isToday())
                                    <a href="{{ route('workouts.today') }}" 
                                       class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m2-10l-2 2m0 0l-2-2m2 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h8l2 2z"></path>
                                        </svg>
                                        Start Workout
                                    </a>
                                @else
                                    <span class="text-xs text-gray-500">
                                        {{ $workout->assigned_date->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $workoutHistory->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Workout History</h3>
                <p class="text-gray-600">You haven't started any workouts yet. Begin your fitness journey today!</p>
            </div>
        @endif
    </div>
</div>

<!-- JavaScript for Enhanced Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const workoutItems = document.querySelectorAll('.workout-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-100', 'text-blue-700', 'border-blue-300');
                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
            });
            
            this.classList.add('active', 'bg-blue-100', 'text-blue-700', 'border-blue-300');
            this.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');

            const filterStatus = this.dataset.status;
            
            workoutItems.forEach(item => {
                const itemStatus = item.dataset.status;
                
                if (filterStatus === 'all') {
                    item.style.display = 'block';
                } else if (filterStatus === 'pending') {
                    if (['Scheduled', 'Pending', 'In Progress'].includes(itemStatus)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                } else {
                    if (itemStatus === filterStatus) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });

    // Sort functionality
    const sortSelect = document.getElementById('sortBy');
    const workoutList = document.getElementById('workoutList');

    sortSelect.addEventListener('change', function() {
        const sortBy = this.value;
        const items = Array.from(workoutItems);

        items.sort((a, b) => {
            switch (sortBy) {
                case 'date-desc':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'date-asc':
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                case 'status':
                    return a.dataset.status.localeCompare(b.dataset.status);
                case 'completion':
                    const statusOrder = { 'Completed': 1, 'Pending': 2, 'Scheduled': 2, 'In Progress': 2, 'Skipped': 3, 'Auto-Skipped': 4 };
                    return (statusOrder[a.dataset.status] || 5) - (statusOrder[b.dataset.status] || 5);
                default:
                    return 0;
            }
        });

        items.forEach(item => workoutList.appendChild(item));
    });

    // Refresh stats functionality
    const refreshButton = document.getElementById('refreshStats');
    if (refreshButton) {
        refreshButton.addEventListener('click', function() {
            // Add loading state
            const originalContent = this.innerHTML;
            this.innerHTML = `
                <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refreshing...
            `;
            this.disabled = true;

            // Simulate refresh (you can replace this with actual AJAX call)
            setTimeout(() => {
                location.reload();
            }, 1000);
        });
    }

    // Initialize active filter button styling
    const activeButton = document.querySelector('.filter-btn.active');
    if (activeButton) {
        activeButton.classList.add('bg-blue-100', 'text-blue-700', 'border-blue-300');
        activeButton.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
    }

    // Style all inactive filter buttons
    filterButtons.forEach(button => {
        if (!button.classList.contains('active')) {
            button.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
        }
    });
});
</script>

<style>
.filter-btn {
    transition: all 0.2s ease-in-out;
}

.filter-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.workout-item {
    animation: fadeIn 0.5s ease-out;
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
    transition: all 0.3s ease;
}

.workout-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>
@endsection