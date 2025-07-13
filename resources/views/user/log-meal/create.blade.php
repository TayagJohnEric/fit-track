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

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Log {{ $mealType }} Meal</h2>
            <a href="{{ route('nutrition.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Back to Nutrition
            </a>
        </div>

        <!-- Food Search Section -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Food Items</label>
                    <input type="text" 
                           id="food-search" 
                           placeholder="Type to search for food items..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex-shrink-0">
                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                    <a href="{{ route('nutrition.custom-food.create') }}" 
                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200 inline-block">
                        Add Custom Food
                    </a>
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
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Selected Foods</h3>
            <div id="selected-foods" class="space-y-3">
                <div class="text-gray-500 text-center py-8" id="empty-message">
                    No foods selected yet. Search and add foods above.
                </div>
            </div>
        </div>

        <!-- Submit Form -->
        <form method="POST" action="{{ route('nutrition.store') }}" id="meal-form">
            @csrf
            <input type="hidden" name="meal_type" value="{{ $mealType }}">
            <input type="hidden" name="log_date" value="{{ $logDate }}">
            <div id="food-items-input">
                <!-- Food items will be added here via JavaScript -->
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        id="submit-btn"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200 disabled:opacity-50"
                        disabled>
                    Log Meal
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
            fetch(`{{ route('nutrition.search-food') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }, 300);
    });

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
                        <div>
                            <div class="font-medium text-gray-800">${food.name}</div>
                            <div class="text-sm text-gray-600">${food.serving_size_description} - ${food.calories_per_serving} cal</div>
                            ${food.has_allergy_warning ? 
                                `<div class="text-xs text-red-600 mt-1">⚠️ Contains: ${food.allergy_names.join(', ')}</div>` : ''}
                        </div>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            Add
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
            selectedFoods.innerHTML = '<div class="text-gray-500 text-center py-8" id="empty-message">No foods selected yet. Search and add foods above.</div>';
            submitBtn.disabled = true;
            return;
        }

        emptyMessage.classList.add('hidden');
        selectedFoods.innerHTML = '';
        submitBtn.disabled = false;

        selectedFoodItems.forEach((food, index) => {
            const foodDiv = document.createElement('div');
            foodDiv.className = 'bg-gray-50 rounded-lg p-4 flex items-center justify-between';
            foodDiv.innerHTML = `
                <div class="flex-1">
                    <div class="font-medium text-gray-800">${food.name}</div>
                    <div class="text-sm text-gray-600">${food.serving_size_description}</div>
                    ${food.has_allergy_warning ? 
                        `<div class="text-xs text-red-600 mt-1">⚠️ Contains: ${food.allergy_names.join(', ')}</div>` : ''}
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