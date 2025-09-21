@extends('layout.user')

@section('title', 'Exercise Library')

@section('content')
    <div class="max-w-[90rem] mx-auto p-4 md:p-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Exercise Library</h2>
                    <p class="text-gray-500">Explore our comprehensive collection of exercises to build your perfect workout routine</p>
                </div>
                <div class="text-sm text-gray-400 bg-gray-50 rounded-lg px-3 py-2">
                    Showing {{ $exercises->firstItem() ?? 0 }} to {{ $exercises->lastItem() ?? 0 }} of {{ $exercises->total() }} exercises
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form id="exerciseSearchForm" class="space-y-6">
                <!-- Search Input -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="searchInput" 
                        name="search" 
                        value="{{ $search }}"
                        placeholder="Search exercises by name, description, muscle group, or equipment..." 
                        class="block w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-gray-900 placeholder-gray-400"
                    >
                </div>

                <!-- Filter Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Muscle Group Filter -->
                    <div>
                        <label for="muscleGroupFilter" class="block text-sm font-medium text-gray-700 mb-2">Muscle Group</label>
                        <select id="muscleGroupFilter" name="muscle_group" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-gray-900">
                            <option value="">All Muscle Groups</option>
                            @foreach($muscleGroups as $group)
                                <option value="{{ $group }}" {{ $muscleGroup === $group ? 'selected' : '' }}>
                                    {{ ucwords($group) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Equipment Filter -->
                    <div>
                        <label for="equipmentFilter" class="block text-sm font-medium text-gray-700 mb-2">Equipment</label>
                        <select id="equipmentFilter" name="equipment" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-gray-900">
                            <option value="">All Equipment</option>
                            @foreach($equipmentTypes as $equipmentType)
                                <option value="{{ $equipmentType }}" {{ $equipment === $equipmentType ? 'selected' : '' }}>
                                    {{ ucwords($equipmentType) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Results Per Page -->
                    <div>
                        <label for="perPageFilter" class="block text-sm font-medium text-gray-700 mb-2">Results Per Page</label>
                        <select id="perPageFilter" name="per_page" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-gray-900">
                            <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12</option>
                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                            <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36</option>
                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" id="clearFiltersBtn" class="inline-flex items-center justify-center px-6 py-3 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Clear Filters
                    </button>
                    <button type="submit" id="searchBtn" class="inline-flex items-center justify-center px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <span class="btn-text flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </span>
                        <span class="btn-loading hidden flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Searching...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Exercise Cards Grid -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <!-- Loading Overlay -->
            <div id="loadingOverlay" class="hidden absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl z-10 backdrop-blur-sm">
                <div class="text-center">
                    <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-orange-600 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-600 mt-3 font-medium">Loading exercises...</p>
                </div>
            </div>

            <div id="exerciseGridContainer" class="relative">
                <!-- Exercise Grid -->
                <div id="exerciseGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @forelse($exercises as $exercise)
                        <div class="exercise-card group bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:border-orange-200" data-exercise-id="{{ $exercise->id }}">
                            <!-- Exercise Image/Video Thumbnail -->
                            <div class="relative h-48 bg-gradient-to-br from-orange-500 to-orange-600 overflow-hidden">
                                @if($exercise->image_url)
                                    <img src="{{ $exercise->image_url }}" alt="{{ $exercise->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <!-- Default placeholder with muscle group -->
                                    <div class="w-full h-full flex items-center justify-center text-white">
                                        <div class="text-center">
                                            <div class="w-16 h-16 mx-auto mb-3 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium">{{ ucwords($exercise->muscle_group) }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($exercise->video_url)
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-black bg-opacity-75 text-white px-3 py-1.5 rounded-lg text-xs flex items-center backdrop-blur-sm">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                            Video
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Exercise Details -->
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 truncate group-hover:text-orange-600 transition-colors duration-200" title="{{ $exercise->name }}">
                                    {{ $exercise->name }}
                                </h3>
                                
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($exercise->description, 100) }}
                                </p>

                                <!-- Tags -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="bg-orange-50 text-orange-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-orange-100">
                                        {{ ucwords($exercise->muscle_group) }}
                                    </span>
                                    <span class="bg-gray-50 text-gray-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-gray-100">
                                        {{ ucwords($exercise->equipment_needed) }}
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <a href="{{ route('exercises-library.show', $exercise) }}" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white flex items-center justify-center py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                    <button type="button" class="quick-view-btn w-12 h-12 flex items-center justify-center border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 hover:border-orange-300 hover:text-orange-600 transition-all duration-200" data-exercise-id="{{ $exercise->id }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <div class="text-gray-300 mb-6">
                                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 20.5a7.962 7.962 0 01-5.207-1.209m0 0L9 12m0 0L6.75 9.75M12 20.5a8.963 8.963 0 01-4.5-1.207"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">No exercises found</h3>
                            <p class="text-gray-500">Try adjusting your search criteria or filters to find exercises.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($exercises->hasPages())
                    <div id="paginationContainer" class="flex flex-col sm:flex-row items-center justify-between pt-6 border-t border-gray-100">
                        <div class="text-sm text-gray-500 mb-4 sm:mb-0">
                            Showing {{ $exercises->firstItem() ?? 0 }} to {{ $exercises->lastItem() ?? 0 }} of {{ $exercises->total() }} results
                        </div>
                        <div class="flex space-x-1">
                            {{ $exercises->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div id="quickViewModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden backdrop-blur-sm">
        <div class="relative top-8 mx-auto p-4 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white my-8">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900" id="modalExerciseName">Exercise Details</h3>
                <button type="button" id="closeModalBtn" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div id="modalContent" class="mt-6">
                <div class="flex justify-center py-12">
                    <svg class="animate-spin h-10 w-10 text-orange-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Search and Modal functionality -->
    <script>
        $(document).ready(function() {
            let searchTimeout;
            const $form = $('#exerciseSearchForm');
            const $searchInput = $('#searchInput');
            const $searchBtn = $('#searchBtn');
            const $clearBtn = $('#clearFiltersBtn');
            const $exerciseGrid = $('#exerciseGrid');
            const $loadingOverlay = $('#loadingOverlay');
            const $quickViewModal = $('#quickViewModal');

            // Real-time search with debouncing
            $searchInput.on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    performSearch();
                }, 500);
            });

            // Filter change handlers
            $('#muscleGroupFilter, #equipmentFilter, #perPageFilter').on('change', function() {
                performSearch();
            });

            // Form submission
            $form.on('submit', function(e) {
                e.preventDefault();
                performSearch();
            });

            // Clear filters
            $clearBtn.on('click', function() {
                $form[0].reset();
                performSearch();
            });

            // Quick view modal handlers
            $(document).on('click', '.quick-view-btn', function() {
                const exerciseId = $(this).data('exercise-id');
                showQuickView(exerciseId);
            });

            $('#closeModalBtn, #quickViewModal').on('click', function(e) {
                if (e.target === this) {
                    $quickViewModal.addClass('hidden');
                }
            });

            // Perform AJAX search
            function performSearch() {
                const formData = $form.serialize();
                
                // Update button state
                toggleLoadingButton($searchBtn, true);
                $loadingOverlay.removeClass('hidden');

                $.get('{{ route("exercises.search") }}', formData)
                    .done(function(response) {
                        if (response.success) {
                            updateExerciseGrid(response.data);
                            updatePagination(response.pagination);
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Search failed:', xhr.responseText);
                    })
                    .always(function() {
                        toggleLoadingButton($searchBtn, false);
                        $loadingOverlay.addClass('hidden');
                    });
            }

            // Show quick view modal
            function showQuickView(exerciseId) {
                $quickViewModal.removeClass('hidden');
                $('#modalContent').html(`
                    <div class="flex justify-center py-12">
                        <svg class="animate-spin h-10 w-10 text-orange-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                `);

                $.get(`/api/exercises/${exerciseId}/details`)
                    .done(function(response) {
                        if (response.success) {
                            const exercise = response.exercise;
                            $('#modalExerciseName').text(exercise.name);
                            
                            const relatedTemplates = exercise.related_templates.map(template => `
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                    <span class="text-sm text-gray-700 font-medium">${template.name}</span>
                                    <div class="flex gap-2">
                                        <span class="text-xs bg-gray-100 px-3 py-1 rounded-lg">${template.duration_minutes}min</span>
                                        <span class="text-xs bg-orange-100 text-orange-800 px-3 py-1 rounded-lg">Level ${template.difficulty_level}</span>
                                    </div>
                                </div>
                            `).join('');

                            $('#modalContent').html(`
                                <div class="space-y-6">
                                    ${exercise.image_url ? `<img src="${exercise.image_url}" alt="${exercise.name}" class="w-full h-56 object-cover rounded-xl">` : ''}
                                    
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-3">Description</h4>
                                        <p class="text-gray-600 text-sm leading-relaxed">${exercise.description}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-3">Muscle Group</h4>
                                            <span class="bg-orange-50 text-orange-700 text-sm font-medium px-4 py-2 rounded-xl border border-orange-100">${exercise.muscle_group}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-3">Equipment</h4>
                                            <span class="bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl border border-gray-100">${exercise.equipment_needed}</span>
                                        </div>
                                    </div>

                                    ${exercise.video_url ? `
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-3">Video Tutorial</h4>
                                            <a href="${exercise.video_url}" target="_blank" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                                Watch Video
                                            </a>
                                        </div>
                                    ` : ''}

                                    ${exercise.related_templates.length > 0 ? `
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-3">Related Workout Templates</h4>
                                            <div class="bg-gray-50 rounded-xl p-4">
                                                ${relatedTemplates}
                                            </div>
                                        </div>
                                    ` : ''}

                                    <div class="flex gap-3 pt-6 border-t border-gray-100">
                                        <a href="/exercises/${exercise.id}" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white text-center py-3 px-6 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                                            View Full Details
                                        </a>
                                        <button type="button" id="closeModalBtn" class="px-6 py-3 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            `);
                        }
                    })
                    .fail(function(xhr) {
                        $('#modalContent').html(`
                            <div class="text-center py-12">
                                <div class="text-red-500 mb-4">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-600">Failed to load exercise details. Please try again.</p>
                            </div>
                        `);
                    });
            }

            // Update exercise grid with new data
            function updateExerciseGrid(exercises) {
                if (exercises.length === 0) {
                    $exerciseGrid.html(`
                        <div class="col-span-full text-center py-16">
                            <div class="text-gray-300 mb-6">
                                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 20.5a7.962 7.962 0 01-5.207-1.209m0 0L9 12m0 0L6.75 9.75M12 20.5a8.963 8.963 0 01-4.5-1.207"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">No exercises found</h3>
                            <p class="text-gray-500">Try adjusting your search criteria or filters to find exercises.</p>
                        </div>
                    `);
                    return;
                }

                const exerciseCards = exercises.map(exercise => `
                    <div class="exercise-card group bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:border-orange-200" data-exercise-id="${exercise.id}">
                        <div class="relative h-48 bg-gradient-to-br from-orange-500 to-orange-600 overflow-hidden">
                            ${exercise.image_url ? 
                                `<img src="${exercise.image_url}" alt="${exercise.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">` :
                                `<div class="w-full h-full flex items-center justify-center text-white">
                                    <div class="text-center">
                                        <div class="w-16 h-16 mx-auto mb-3 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium">${exercise.muscle_group.charAt(0).toUpperCase() + exercise.muscle_group.slice(1)}</p>
                                    </div>
                                </div>`
                            }
                            
                            ${exercise.video_url ? `
                                <div class="absolute top-3 right-3">
                                    <span class="bg-black bg-opacity-75 text-white px-3 py-1.5 rounded-lg text-xs flex items-center backdrop-blur-sm">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Video
                                    </span>
                                </div>
                            ` : ''}
                        </div>

                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 truncate group-hover:text-orange-600 transition-colors duration-200" title="${exercise.name}">
                                ${exercise.name}
                            </h3>
                            
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">
                                ${exercise.description.length > 100 ? exercise.description.substring(0, 100) + '...' : exercise.description}
                            </p>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="bg-orange-50 text-orange-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-orange-100">
                                    ${exercise.muscle_group.charAt(0).toUpperCase() + exercise.muscle_group.slice(1)}
                                </span>
                                <span class="bg-gray-50 text-gray-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-gray-100">
                                    ${exercise.equipment_needed.charAt(0).toUpperCase() + exercise.equipment_needed.slice(1)}
                                </span>
                            </div>

                            <div class="flex gap-3">
                                <a href="/exercises/${exercise.id}" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white flex items-center justify-center py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </a>
                                <button type="button" class="quick-view-btn w-12 h-12 flex items-center justify-center border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 hover:border-orange-300 hover:text-orange-600 transition-all duration-200" data-exercise-id="${exercise.id}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');

                $exerciseGrid.html(exerciseCards);
            }

            // Update pagination display
            function updatePagination(pagination) {
                const resultText = `Showing ${pagination.from || 0} to ${pagination.to || 0} of ${pagination.total} results`;
                $('.text-sm.text-gray-500').first().text(resultText);
                
                // Update results count in header
                $('.text-sm.text-gray-400').text(`Showing ${pagination.from || 0} to ${pagination.to || 0} of ${pagination.total} exercises`);
            }

            // Toggle loading button state
            function toggleLoadingButton($button, isLoading) {
                const $btnText = $button.find('.btn-text');
                const $btnLoading = $button.find('.btn-loading');

                if (isLoading) {
                    $btnText.addClass('hidden');
                    $btnLoading.removeClass('hidden');
                    $button.prop('disabled', true);
                } else {
                    $btnText.removeClass('hidden');
                    $btnLoading.addClass('hidden');
                    $button.prop('disabled', false);
                }
            }
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .exercise-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .exercise-card:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1), 0 10px 20px -6px rgba(0, 0, 0, 0.05);
        }
        
        .exercise-card img {
            transition: transform 0.3s ease;
        }
        
        .exercise-card:hover img {
            transform: scale(1.05);
        }

        /* Custom focus styles for orange theme */
        .focus\:ring-orange-500:focus {
            --tw-ring-color: rgb(234 88 12 / 0.5);
        }

        .focus\:border-orange-500:focus {
            --tw-border-opacity: 1;
            border-color: rgb(234 88 12 / var(--tw-border-opacity));
        }
    </style>
@endsection