@extends('layout.user')
@section('title', 'Meal Ideas - Budget-Based Suggestions')
@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="">
        <!-- Header Section -->
        <div class="mb-6">
            <!-- Header -->
            <div class="px-6 py-3 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Discover Budget-Friendly Meals</h1>
                <!-- Sub Header -->
                <p class="text-center mt-3 text-gray-500">Find affordable meal options that align with your budget and fitness goals</p>  
            </div>

            <!-- Budget Input Section -->
            <div class="px-6 py-5">
                <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-4">
                    <!-- Budget Input with Button Inside -->
                    <div class="relative w-full md:flex-1">
                        <form id="budget-form" class="relative">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-orange-500 lucide lucide-philippine-peso-icon lucide-philippine-peso"><path d="M20 11H4"/><path d="M20 7H4"/><path d="M7 21V4a1 1 0 0 1 1-1h4a1 1 0 0 1 0 12H7"/></svg>
                                </div>
                                <input 
                                    type="number" 
                                    id="budget" 
                                    name="budget" 
                                    min="1" 
                                    step="0.01" 
                                    value="{{ $defaultBudget }}"
                                    placeholder="Enter your meal budget..."
                                    class="w-full pl-10 pr-32 py-3 shadow-md text-lg border-2 border-orange-200 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-200 focus:border-orange-200 transition-all duration-200 bg-white"
                                    required
                                >
                                <button 
                                    type="submit" 
                                    id="find-meals-btn"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg id="search-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <div id="loading-spinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    <span id="button-text">Find Meals</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div id="results-section" class="mb-6" style="display: none;">
            <div class="px-6 py-3 text-center">
                <h2 id="results-title" class="text-xl font-semibold text-gray-800"></h2>
            </div>
            
            <div class="px-6 py-5">
                <div id="meal-ideas-container"></div>
            </div>
        </div>

        <!-- Initial State - No Budget Set -->
        <div id="initial-state" class="mb-6">
            <div class="px-6 py-5">
                <div class="flex flex-col items-center justify-center p-8">
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mb-4 lucide lucide-utensils-crossed-icon lucide-utensils-crossed"><path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/><path d="m2.1 21.8 6.4-6.3"/><path d="m19 5-7 7"/></svg>
                    <!-- Welcome message -->
                    <div class="text-gray-500 text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Ready to find your perfect meal?</h3>
                        <p>Enter your <span class="text-orange-500 font-medium">budget</span> above to discover delicious and affordable meal options.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Handle form submission
    $('#budget-form').on('submit', function(e) {
        e.preventDefault();
        
        const budget = $('#budget').val();
        const budgetNum = parseFloat(budget);
        
        if (!budget || budgetNum <= 0) {
            alert('Please enter a valid budget amount.');
            return;
        }
        
        // Show loading state
        showLoadingState();
        
        // Hide initial state and results
        $('#initial-state').fadeOut(300);
        $('#results-section').fadeOut(300, function() {
            // Make AJAX request
            $.ajax({
                url: '{{ route("meal-ideas.index") }}',
                method: 'GET',
                data: {
                    budget: budget,
                    ajax: true
                },
                success: function(response) {
                    hideLoadingState();
                    displayResults(response, budget);
                },
                error: function(xhr, status, error) {
                    hideLoadingState();
                    console.error('Error fetching meal ideas:', error);
                    alert('Something went wrong. Please try again.');
                    $('#initial-state').fadeIn(300);
                }
            });
        });
    });
    
    function showLoadingState() {
        const btn = $('#find-meals-btn');
        const searchIcon = $('#search-icon');
        const spinner = $('#loading-spinner');
        const buttonText = $('#button-text');
        
        btn.prop('disabled', true);
        searchIcon.addClass('hidden');
        spinner.removeClass('hidden');
        buttonText.text('Finding...');
    }
    
    function hideLoadingState() {
        const btn = $('#find-meals-btn');
        const searchIcon = $('#search-icon');
        const spinner = $('#loading-spinner');
        const buttonText = $('#button-text');
        
        btn.prop('disabled', false);
        searchIcon.removeClass('hidden');
        spinner.addClass('hidden');
        buttonText.text('Find Meals');
    }
    
    function displayResults(data, budget) {
        const formattedBudget = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(budget);
        
        $('#results-title').text(`Meal Ideas for ${formattedBudget}`);
        
        if (data.mealIdeas && data.mealIdeas.length > 0) {
            const mealGrid = generateMealGrid(data.mealIdeas, budget);
            $('#meal-ideas-container').html(mealGrid);
        } else {
            const emptyState = generateEmptyState(budget);
            $('#meal-ideas-container').html(emptyState);
        }
        
        // Show results with smooth animation
        $('#results-section').fadeIn(500).css('display', 'block');
        
        // Animate meal cards
        $('.meal-card').each(function(index) {
            $(this).css({
                opacity: 0,
                transform: 'translateY(20px)'
            }).delay(index * 100).animate({
                opacity: 1
            }, 400).css({
                transform: 'translateY(0px)',
                transition: 'transform 0.4s ease-out'
            });
        });
    }
    
    function generateMealGrid(mealIdeas, budget) {
        let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';
        
        mealIdeas.forEach(function(meal, index) {
            const totalCost = new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(meal.total_cost);
            
            html += `
                <div class="meal-card bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                    <!-- Meal Header -->
                    <div class="p-5 bg-white">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-lg font-semibold text-gray-900 tracking-tighter">
                                Meal Option ${index + 1}
                            </h4>
                            <span class="bg-green-100 text-green-500 text-sm font-medium px-3 py-1 rounded-full shadow-sm">
                                ${totalCost}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Food Items -->
                    <div class="p-5">
                        <div class="space-y-3">`;
            
            meal.items.forEach(function(item) {
                const itemCost = new Intl.NumberFormat('en-PH', {
                    style: 'currency',
                    currency: 'PHP'
                }).format(item.estimated_cost);
                
                const imageHtml = item.image_url ? 
                    `<img src="{{ asset('storage') }}/${item.image_url}" alt="${item.name}" class="w-12 h-12 object-cover rounded-lg shadow-sm">` :
                    `<div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                            <path d="M2 12h20"/>
                            <path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"/>
                            <path d="m4 8 16-4"/>
                            <path d="m8.86 6.78-.45-1.81a2 2 0 0 1 1.45-2.43l1.94-.48a2 2 0 0 1 2.43 1.46l.45 1.8"/>
                        </svg>
                    </div>`;
                
                html += `
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex-shrink-0">
                            ${imageHtml}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-medium text-gray-900 truncate">${item.name}</h5>
                            <p class="text-sm text-gray-500 truncate">${item.serving_size_description}</p>
                            <p class="text-sm font-medium text-green-600">${itemCost}</p>
                        </div>
                    </div>`;
            });
            
            const itemIds = meal.items.map(item => item.id).join(',');
            
            html += `
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="p-5 bg-gray-50 border-t border-gray-100">
                        <div class="flex gap-3">
                            <a 
                                href="{{ route('meal-ideas.show') }}?items=${itemIds}&budget=${budget}" 
                                class="open-meal-details flex-1 bg-gray-200 hover:bg-gray-300 text-gray-600 font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm text-center flex items-center justify-center gap-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                </svg>
                                View Details
                            </a>
                        </div>
                    </div>
                </div>`;
        });
        
        html += '</div>';
        return html;
    }
    
    function generateEmptyState(budget) {
        const suggestedBudget = parseFloat(budget) + 50;
        const formattedSuggestedBudget = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(suggestedBudget);
        
        return `
            <div id="empty-state" class="flex flex-col items-center justify-center p-8">
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mb-4">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                <!-- Empty message -->
                <div class="text-gray-500 text-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No meal ideas found</h3>
                    <p>Try increasing your budget or check if you have too many food allergies set.</p>
                </div>
                <!-- Suggestion Button -->
                <button 
                    onclick="$('#budget').val(${suggestedBudget}); $('#budget-form').submit();"
                    class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg transition duration-200 shadow-md"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/>
                        <path d="M12 5v14"/>
                    </svg>
                    Try ${formattedSuggestedBudget}
                </button>
            </div>`;
    }

    // Open details modal via AJAX when clicking View Details
    $(document).on('click', 'a.open-meal-details', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const $btn = $(this);
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).addClass('opacity-70 cursor-wait');

        $.get(url)
            .done(function(html) {
                // Remove existing modal if any
                $('#meal-details-modal').remove();
                // Append new modal to body
                $('body').append(html);
                bindMealDetailsModalHandlers();
            })
            .fail(function() {
                alert('Failed to load meal details. Please try again.');
            })
            .always(function() {
                $btn.prop('disabled', false).removeClass('opacity-70 cursor-wait').html(originalHtml);
            });
    });

    function bindMealDetailsModalHandlers() {
        const $modal = $('#meal-details-modal');
        // Close on button
        $modal.on('click', '#close-meal-details', function() {
            $modal.remove();
        });
        // Close on backdrop click
        $modal.on('click', function(e) {
            if (e.target === this) {
                $modal.remove();
            }
        });
        // Close on ESC
        $(document).on('keydown.mealmodal', function(e) {
            if (e.key === 'Escape') {
                $modal.remove();
                $(document).off('keydown.mealmodal');
            }
        });
    }
});
</script>
@endsection