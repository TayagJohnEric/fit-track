@extends('layout.user')
@section('title', 'Log ' . $mealType . ' Meal')
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

  <!-- Top contents -->
<div class="flex items-center justify-between mb-6">
    <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('nutrition.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200">
                    Nutrition
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-orange-600">Log {{ $mealType }} Meal</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

               

    <div class="">
        <!-- Food Search Section -->
        <div class="mb-6">
           <!-- Header -->
            <div class=" px-6 py-3 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2"> Log Your {{ $mealType }} Meal  </h1>
                  <!--Sub Header-->
                    <p class="text-center mt-3 text-gray-500">Search and add foods to track your nutrition</p>  
            </div>

          <!-- Search & Button Section -->
<div class="px-6 py-5">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-4">
        <!-- Search -->
        <div class="relative w-full md:flex-1">
             <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
            <input type="text" 
                   id="food-search" 
                   placeholder="Search for food items..."
                   class="w-full pl-10 pr-1 py-3 shadow-md text-lg border-2 border-orange-200 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-200 focus:border-orange-200 transition-all duration-200 bg-white">
        </div>

        <!-- Add Custom Food Button -->
        <div>
            <a href="{{ route('nutrition.custom-food.create') }}" 
               class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-3 rounded-full transition duration-200 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-salad">
                    <path d="M7 21h10"/>
                    <path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"/>
                    <path d="M11.38 12a2.4 2.4 0 0 1-.4-4.77 2.4 2.4 0 0 1 3.2-2.77 2.4 2.4 0 0 1 3.47-.63 2.4 2.4 0 0 1 3.37 3.37 2.4 2.4 0 0 1-1.1 3.7 2.51 2.51 0 0 1 .03 1.1"/>
                    <path d="m13 12 4-4"/>
                    <path d="M10.9 7.25A3.99 3.99 0 0 0 4 10c0 .73.2 1.41.54 2"/>
                </svg>
                <span>Add Custom Food</span>
            </a>
        </div>
    </div>
</div>

                 


            <!-- Search Results -->
            <div id="search-results" class="mt-4 hidden">
                <div class="border rounded-lg max-h-60 overflow-y-auto">
                    <!-- Results will be populated via JavaScript -->
                </div>
            </div>
        </div>

       <!-- Selected Foods Section -->
<div class="mb-6">
    <div class="px-6 py-3 text-center">
        
    </div>
    
    <div class="px-6 py-5">
        <div id="selected-foods" class="flex flex-col items-center justify-center p-6">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mb-3">
                <path d="M2 12h20"/>
                <path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"/>
                <path d="m4 8 16-4"/>
                <path d="m8.86 6.78-.45-1.81a2 2 0 0 1 1.45-2.43l1.94-.48a2 2 0 0 1 2.43 1.46l.45 1.8"/>
            </svg>
            <!-- Empty message -->
            <div class="text-gray-500 text-center" id="empty-message">
                No foods selected yet. <span class="text-orange-500 font-medium">Search</span> and add foods above.
            </div>
        </div>
    </div>
</div>


      <!--Concern can this just be show when i add the food?-->
        <!-- Submit Form -->
<form method="POST" action="{{ route('nutrition.store') }}" id="meal-form" class="hidden">
    @csrf
    <input type="hidden" name="meal_type" value="{{ $mealType }}">
    <input type="hidden" name="log_date" value="{{ $logDate }}">
    <div id="food-items-input">
        <!-- Food items will be added here via JavaScript -->
    </div>

    <div class="flex justify-end items-center gap-2 mt-4">
        <button type="submit" 
                id="submit-btn"
                class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg transition duration-200 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 lucide lucide-circle-check-big">
                <path d="M21.801 10A10 10 0 1 1 17 3.335"/>
                <path d="m9 11 3 3L22 4"/>
            </svg>
            <span>Log Meal</span>
        </button>
    </div>
</form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('food-search');
    const searchResults = document.getElementById('search-results');
    const selectedFoods = document.getElementById('selected-foods');
    const emptyMessage = document.getElementById('empty-message');
    const foodItemsInput = document.getElementById('food-items-input');
    const submitBtn = document.getElementById('submit-btn');
    const mealForm = document.getElementById('meal-form');
    
    let selectedFoodItems = [];
    let searchTimeout;

    // Search functionality
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }
        
        searchTimeout = setTimeout(() => {
            // Show loading state
            displaySearchLoading();
            
            fetch(`{{ route('nutrition.search-food') }}?query=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            throw new Error('Please log in to search for foods');
                        } else if (response.status === 419) {
                            throw new Error('Session expired. Please refresh the page');
                        } else {
                            throw new Error(`Search failed (${response.status})`);
                        }
                    }
                    return response.json();
                })
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    console.error('Search error:', error);
                    displaySearchError(error.message);
                });
        }, 300);
    });

    // Display search loading
    function displaySearchLoading() {
        const resultsContainer = searchResults.querySelector('div') || searchResults.appendChild(document.createElement('div'));
        resultsContainer.className = 'border rounded-lg max-h-60 overflow-y-auto';
        resultsContainer.innerHTML = `
            <div class="p-4 text-gray-600 text-center">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Searching for foods...</span>
                </div>
            </div>
        `;
        searchResults.classList.remove('hidden');
    }

    // Display search error
    function displaySearchError(message) {
        const resultsContainer = searchResults.querySelector('div') || searchResults.appendChild(document.createElement('div'));
        resultsContainer.className = 'border rounded-lg max-h-60 overflow-y-auto';
        resultsContainer.innerHTML = `
            <div class="p-4 text-red-600 text-center bg-red-50 border-red-200">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            </div>
        `;
        searchResults.classList.remove('hidden');
    }

    // Display search results
    function displaySearchResults(foods) {
        const resultsContainer = searchResults.querySelector('div') || searchResults.appendChild(document.createElement('div'));
        resultsContainer.className = 'border rounded-lg max-h-60 overflow-y-auto';
        resultsContainer.innerHTML = '';

        if (foods.length === 0) {
            resultsContainer.innerHTML = '<div class="p-4 text-gray-500 text-center">No foods found</div>';
        } else {
            foods.forEach(food => {
                const foodItem = document.createElement('div');
                foodItem.className = 'p-3 border-b hover:bg-gray-50 cursor-pointer';
                foodItem.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                           ${food.image_url ? 
                                `<img src="{{ asset('storage') }}/${food.image_url}" alt="${food.name}" class="w-12 h-12 object-cover rounded-lg">` : 
                                `<div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                        <path d="M2 12h20"/>
                                        <path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"/>
                                        <path d="m4 8 16-4"/>
                                        <path d="m8.86 6.78-.45-1.81a2 2 0 0 1 1.45-2.43l1.94-.48a2 2 0 0 1 2.43 1.46l.45 1.8"/>
                                    </svg>
                                </div>`
                            }

                            <div>
                                <div class="font-medium text-gray-800">${food.name}</div>
                                <div class="text-sm text-gray-600">${food.serving_size_description} - ${food.calories_per_serving} cal</div>
                                ${food.has_allergy_warning ? 
                                    `<div class="text-xs text-red-600 mt-1">⚠️ Contains: ${food.allergy_names.join(', ')}</div>` : ''}
                            </div>
                        </div>
                        <button class="flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md transition duration-200">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 lucide lucide-plus">
        <path d="M5 12h14"/>
        <path d="M12 5v14"/>
    </svg>
    <span>Add</span>
</button>
                    </div>
                `;
                
                foodItem.querySelector('button').addEventListener('click', () => {
                    addFoodToSelection(food);
                });
                
                resultsContainer.appendChild(foodItem);
            });
        }
        
        searchResults.classList.remove('hidden');
    }

    // Add food to selection
    function addFoodToSelection(food) {
        // Check if already selected
        if (selectedFoodItems.find(item => item.id === food.id)) {
            alert('This food is already selected!');
            return;
        }

        const foodItem = {
            id: food.id,
            name: food.name,
            serving_size_description: food.serving_size_description,
            calories_per_serving: food.calories_per_serving,
            protein_grams_per_serving: food.protein_grams_per_serving,
            carb_grams_per_serving: food.carb_grams_per_serving,
            fat_grams_per_serving: food.fat_grams_per_serving,
            image_url: food.image_url,
            quantity: 1,
            has_allergy_warning: food.has_allergy_warning,
            allergy_names: food.allergy_names || []
        };

        selectedFoodItems.push(foodItem);
        updateSelectedFoodsDisplay();
        updateFormInputs();
        
        // Clear search
        searchInput.value = '';
        searchResults.classList.add('hidden');
    }

    // Update selected foods display
    function updateSelectedFoodsDisplay() {
        if (selectedFoodItems.length === 0) {
            emptyMessage.classList.remove('hidden');
            selectedFoods.innerHTML = `
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mb-3">
                    <path d="M2 12h20"/>
                    <path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"/>
                    <path d="m4 8 16-4"/>
                    <path d="m8.86 6.78-.45-1.81a2 2 0 0 1 1.45-2.43l1.94-.48a2 2 0 0 1 2.43 1.46l.45 1.8"/>
                </svg>
                <!-- Empty message -->
                <div class="text-gray-500 text-center" id="empty-message">
                    No foods selected yet. <span class="text-orange-500 font-medium">Search</span> and add foods above.
                </div>
            `;
            selectedFoods.className = 'flex flex-col items-center justify-center rounded-xl p-6 bg-gray-50';
            mealForm.classList.add('hidden');
            return;
        }

        emptyMessage.classList.add('hidden');
        selectedFoods.className = 'space-y-4';
        selectedFoods.innerHTML = '';
        mealForm.classList.remove('hidden');

        selectedFoodItems.forEach((food, index) => {
            const foodDiv = document.createElement('div');
            foodDiv.className = 'bg-gray-50 rounded-lg p-4 flex items-center justify-between';
            foodDiv.innerHTML = `
                <div class="flex items-center space-x-3 flex-1">
                   ${food.image_url ? 
                        `<img src="{{ asset('storage') }}/${food.image_url}" alt="${food.name}" class="w-12 h-12 object-cover rounded-lg">` : 
                        `<div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                <path d="M2 12h20"/>
                                <path d="M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"/>
                                <path d="m4 8 16-4"/>
                                <path d="m8.86 6.78-.45-1.81a2 2 0 0 1 1.45-2.43l1.94-.48a2 2 0 0 1 2.43 1.46l.45 1.8"/>
                            </svg>
                        </div>`
                    }

                    <div>
                        <div class="font-medium text-gray-800">${food.name}</div>
                        <div class="text-sm text-gray-600">${food.serving_size_description}</div>
                        ${food.has_allergy_warning ? 
                            `<div class="text-xs text-red-600 mt-1">⚠️ Contains: ${food.allergy_names.join(', ')}</div>` : ''}
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <label class="text-sm text-gray-700">Quantity:</label>
                        <input type="number" 
                               value="${food.quantity}" 
                               min="0.1" 
                               step="0.1" 
                               class="w-20 px-2 py-1 border rounded text-sm"
                               onchange="updateQuantity(${index}, this.value)">
                    </div>
                    <div class="text-sm text-gray-600">
                        ${Math.round(food.calories_per_serving * food.quantity)} cal
                    </div>
                    <button onclick="removeFoodItem(${index})" 
                            class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            `;
            selectedFoods.appendChild(foodDiv);
        });
    }

    // Update form inputs
    function updateFormInputs() {
        foodItemsInput.innerHTML = '';
        selectedFoodItems.forEach((food, index) => {
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `food_items[${index}][id]`;
            idInput.value = food.id;
            
            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = `food_items[${index}][quantity]`;
            quantityInput.value = food.quantity;
            
            foodItemsInput.appendChild(idInput);
            foodItemsInput.appendChild(quantityInput);
        });
    }

    // Global functions for inline event handlers
    window.updateQuantity = function(index, quantity) {
        selectedFoodItems[index].quantity = parseFloat(quantity) || 0.1;
        updateSelectedFoodsDisplay();
        updateFormInputs();
    };

    window.removeFoodItem = function(index) {
        selectedFoodItems.splice(index, 1);
        updateSelectedFoodsDisplay();
        updateFormInputs();
    };

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchResults.contains(e.target) && !searchInput.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>
@endsection