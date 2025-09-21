@extends('layout.user')

@section('title', $exercise->name . ' - Exercise Details')

@section('content')
    <div class="max-w-[90rem] mx-auto p-4 md:p-6">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('exercises-library.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-orange-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Exercise Library
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2">{{ $exercise->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Exercise Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Exercise Image/Video -->
                <div class="space-y-4">
                    @if($exercise->image_url)
                        <div class="relative rounded-xl overflow-hidden shadow-lg">
                            <img src="{{ $exercise->image_url }}" alt="{{ $exercise->name }}" class="w-full h-80 object-cover">
                            @if($exercise->video_url)
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center backdrop-blur-sm">
                                    <a href="{{ $exercise->video_url }}" target="_blank" class="bg-white bg-opacity-95 hover:bg-opacity-100 rounded-full p-5 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105">
                                        <svg class="w-12 h-12 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Default placeholder -->
                        <div class="w-full h-80 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                            <div class="text-center text-white">
                                <div class="w-20 h-20 mx-auto mb-4 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold">{{ ucwords($exercise->muscle_group) }} Exercise</h3>
                                <p class="text-orange-100 mt-2">{{ ucwords($exercise->equipment_needed) }} Required</p>
                            </div>
                        </div>
                    @endif

                    @if($exercise->video_url && !$exercise->image_url)
                        <div class="text-center">
                            <a href="{{ $exercise->video_url }}" target="_blank" class="inline-flex items-center bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                Watch Video Tutorial
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Exercise Information -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $exercise->name }}</h1>
                        
                        <!-- Tags -->
                        <div class="flex flex-wrap gap-3 mb-6">
                            <span class="bg-orange-50 text-orange-700 text-sm font-medium px-4 py-2 rounded-xl border border-orange-100 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                {{ ucwords($exercise->muscle_group) }}
                            </span>
                            <span class="bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-xl border border-gray-100 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                {{ ucwords($exercise->equipment_needed) }}
                            </span>
                        </div>

                        <!-- Description -->
                        <div class="prose prose-gray max-w-none">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $exercise->description }}</p>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-4 p-6 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">{{ ucwords($exercise->muscle_group) }}</div>
                            <div class="text-sm text-gray-500 font-medium">Primary Muscle</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-700">{{ ucwords($exercise->equipment_needed) }}</div>
                            <div class="text-sm text-gray-500 font-medium">Equipment</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Workout Templates -->
        @if($workoutTemplates->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Featured in Workout Templates</h2>
                    <span class="text-sm text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg">{{ $workoutTemplates->count() }} template(s)</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($workoutTemplates as $template)
                        <div class="border border-gray-100 rounded-xl p-5 hover:shadow-lg hover:border-orange-200 transition-all duration-300 bg-white">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="font-semibold text-gray-900 flex-1 pr-2 text-lg">{{ $template->name }}</h3>
                                <div class="flex gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $template->difficulty_level ? 'text-orange-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>

                            <p class="text-gray-500 text-sm mb-4 leading-relaxed">{{ Str::limit($template->description, 100) }}</p>

                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center bg-gray-50 px-3 py-1.5 rounded-lg">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                                    </svg>
                                    {{ $template->experienceLevel->name ?? 'N/A' }}
                                </span>
                                <span class="flex items-center bg-orange-50 text-orange-700 px-3 py-1.5 rounded-lg">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                    {{ $template->duration_minutes }} min
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <span class="bg-gray-100 text-gray-700 text-xs font-medium px-3 py-1.5 rounded-lg">
                                    {{ $template->workoutType->name ?? 'General' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Exercise Tips and Notes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Exercise Tips -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    Exercise Tips
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-4 p-3 bg-orange-50 rounded-lg border border-orange-100">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-3 flex-shrink-0"></div>
                        <p class="text-gray-700 leading-relaxed">Focus on proper form rather than heavy weight</p>
                    </div>
                    <div class="flex items-start space-x-4 p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-3 flex-shrink-0"></div>
                        <p class="text-gray-700 leading-relaxed">Control the movement throughout the entire range of motion</p>
                    </div>
                    <div class="flex items-start space-x-4 p-3 bg-orange-50 rounded-lg border border-orange-100">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-3 flex-shrink-0"></div>
                        <p class="text-gray-700 leading-relaxed">Breathe properly - exhale during exertion, inhale during relaxation</p>
                    </div>
                    <div class="flex items-start space-x-4 p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-3 flex-shrink-0"></div>
                        <p class="text-gray-700 leading-relaxed">Warm up adequately before starting the exercise</p>
                    </div>
                </div>
            </div>

            <!-- Safety Notes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                    </div>
                    Safety Notes
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-4 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-3 flex-shrink-0"></div>
                        <p class="text-gray-700 leading-relaxed">Consider consulting a trainer if you're new to this exercise</p>
                    </div>
                    <div class="flex items-start space-x-4 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-3 flex-shrink-0"></div>
                        <p class="text-gray-700 leading-relaxed">Maintain proper hydration throughout your workout</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Workout Modal -->
    <div id="addToWorkoutModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden backdrop-blur-sm">
        <div class="relative top-8 mx-auto p-4 border-0 w-11/12 md:w-1/2 lg:w-1/3 shadow-2xl rounded-xl bg-white my-8">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900">Add to Workout</h3>
                <button type="button" id="closeAddToWorkoutModal" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="mt-6">
                <form id="addToWorkoutForm" class="space-y-5">
                    <input type="hidden" name="exercise_id" value="{{ $exercise->id }}">
                    
                    <div>
                        <label for="sets" class="block text-sm font-medium text-gray-700 mb-2">Sets</label>
                        <input type="number" id="sets" name="sets" min="1" max="20" value="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                    </div>

                    <div>
                        <label for="reps" class="block text-sm font-medium text-gray-700 mb-2">Reps</label>
                        <input type="text" id="reps" name="reps" value="10-12" placeholder="e.g., 10-12 or 30 seconds" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                    </div>

                    <div>
                        <label for="rest_seconds" class="block text-sm font-medium text-gray-700 mb-2">Rest Between Sets (seconds)</label>
                        <select id="rest_seconds" name="rest_seconds" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                            <option value="30">30 seconds</option>
                            <option value="45">45 seconds</option>
                            <option value="60" selected>1 minute</option>
                            <option value="90">1.5 minutes</option>
                            <option value="120">2 minutes</option>
                            <option value="180">3 minutes</option>
                        </select>
                    </div>

                    <div>
                        <label for="duration_seconds" class="block text-sm font-medium text-gray-700 mb-2">Duration (optional)</label>
                        <input type="number" id="duration_seconds" name="duration_seconds" min="5" max="600" placeholder="Duration in seconds" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                        <p class="text-xs text-gray-400 mt-2">Leave empty for rep-based exercises</p>
                    </div>

                    <div class="flex gap-3 pt-6 border-t border-gray-100">
                        <button type="submit" id="submitAddToWorkout" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white py-3 px-6 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="btn-text flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Exercise
                            </span>
                            <span class="btn-loading hidden flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Adding...
                            </span>
                        </button>
                        <button type="button" id="cancelAddToWorkout" class="px-6 py-3 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   

    <script>
        $(document).ready(function() {
            const $addToWorkoutBtn = $('#addToWorkoutBtn');
            const $addToWorkoutModal = $('#addToWorkoutModal');
            const $addToWorkoutForm = $('#addToWorkoutForm');
            const $successMessage = $('#successMessage');

            // Open add to workout modal
            $addToWorkoutBtn.on('click', function() {
                $addToWorkoutModal.removeClass('hidden');
            });

            // Close modal handlers
            $('#closeAddToWorkoutModal, #cancelAddToWorkout, #addToWorkoutModal').on('click', function(e) {
                if (e.target === this) {
                    $addToWorkoutModal.addClass('hidden');
                }
            });

            // Handle form submission
            $addToWorkoutForm.on('submit', function(e) {
                e.preventDefault();
                
                const $submitBtn = $('#submitAddToWorkout');
                toggleLoadingButton($submitBtn, true);

                // Simulate API call - replace with actual endpoint
                setTimeout(function() {
                    // Show success message
                    showSuccessMessage();
                    
                    // Close modal
                    $addToWorkoutModal.addClass('hidden');
                    
                    // Reset form
                    $addToWorkoutForm[0].reset();
                    $addToWorkoutForm.find('input[name="sets"]').val('3');
                    $addToWorkoutForm.find('input[name="reps"]').val('10-12');
                    $addToWorkoutForm.find('select[name="rest_seconds"]').val('60');
                    
                    toggleLoadingButton($submitBtn, false);
                }, 1500);

                // Uncomment below for actual AJAX implementation
                /*
                $.ajax({
                    url: '/api/workouts/add-exercise',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .done(function(response) {
                    if (response.success) {
                        showSuccessMessage();
                        $addToWorkoutModal.addClass('hidden');
                        $addToWorkoutForm[0].reset();
                        $addToWorkoutForm.find('input[name="sets"]').val('3');
                        $addToWorkoutForm.find('input[name="reps"]').val('10-12');
                        $addToWorkoutForm.find('select[name="rest_seconds"]').val('60');
                    } else {
                        showErrorMessage(response.message || 'Failed to add exercise to workout.');
                    }
                })
                .fail(function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred while adding the exercise.';
                    showErrorMessage(errorMessage);
                })
                .always(function() {
                    toggleLoadingButton($submitBtn, false);
                });
                */
            });

            // Show success message
            function showSuccessMessage() {
                $successMessage.removeClass('translate-x-full').addClass('translate-x-0');
                setTimeout(function() {
                    $successMessage.removeClass('translate-x-0').addClass('translate-x-full');
                }, 3000);
            }

            // Show error message (if needed)
            function showErrorMessage(message) {
                // Create and show error message similar to success message
                console.error('Error:', message);
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

            // Auto-hide success message on page load (in case of redirect)
            if ($successMessage.hasClass('translate-x-0')) {
                setTimeout(function() {
                    $successMessage.removeClass('translate-x-0').addClass('translate-x-full');
                }, 3000);
            }
        });
    </script>

    <style>
        .prose h3 {
            margin-bottom: 0.75rem;
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

        /* Custom scrollbar for modal */
        #addToWorkoutModal .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        #addToWorkoutModal .overflow-y-auto::-webkit-scrollbar-track {
            background: #f8f9fa;
            border-radius: 3px;
        }

        #addToWorkoutModal .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        #addToWorkoutModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Enhanced hover effects */
        .exercise-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .exercise-card:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1), 0 10px 20px -6px rgba(0, 0, 0, 0.05);
        }

        /* Smooth animations for tips and safety cards */
        .bg-orange-50, .bg-yellow-50, .bg-gray-50 {
            transition: all 0.2s ease-in-out;
        }

        .bg-orange-50:hover {
            background-color: rgb(255 237 213 / 0.8);
            transform: translateX(2px);
        }

        .bg-yellow-50:hover {
            background-color: rgb(254 252 232 / 0.8);
            transform: translateX(2px);
        }

        .bg-gray-50:hover {
            background-color: rgb(249 250 251 / 0.8);
            transform: translateX(2px);
        }
    </style>
@endsection