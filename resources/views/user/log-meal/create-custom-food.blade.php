@extends('layout.user')
@section('title', 'Add Custom Food Item')
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
            <h2 class="text-2xl font-bold text-gray-800">Add Custom Food Item</h2>
            <a href="{{ route('nutrition.create') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Back to Meal Log
            </a>
        </div>

        <form method="POST" action="{{ route('nutrition.custom-food.store') }}" class="space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Food Name *</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Serving Size Description *</label>
                    <input type="text" 
                           name="serving_size_description" 
                           value="{{ old('serving_size_description') }}"
                           placeholder="e.g., 1 medium apple, 1 cup cooked rice"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('serving_size_description') border-red-500 @enderror"
                           required>
                    @error('serving_size_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Serving Size and Calories -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Serving Size (grams) *</label>
                    <input type="number" 
                           name="serving_size_grams" 
                           value="{{ old('serving_size_grams') }}"
                           min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('serving_size_grams') border-red-500 @enderror"
                           required>
                    @error('serving_size_grams')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Calories per Serving *</label>
                    <input type="number" 
                           name="calories_per_serving" 
                           value="{{ old('calories_per_serving') }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('calories_per_serving') border-red-500 @enderror"
                           required>
                    @error('calories_per_serving')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Macronutrients -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Protein (grams) *</label>
                    <input type="number" 
                           name="protein_grams_per_serving" 
                           value="{{ old('protein_grams_per_serving') }}"
                           min="0"
                           step="0.1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('protein_grams_per_serving') border-red-500 @enderror"
                           required>
                    @error('protein_grams_per_serving')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Carbs (grams) *</label>
                    <input type="number" 
                           name="carb_grams_per_serving" 
                           value="{{ old('carb_grams_per_serving') }}"
                           min="0"
                           step="0.1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('carb_grams_per_serving') border-red-500 @enderror"
                           required>
                    @error('carb_grams_per_serving')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fat (grams) *</label>
                    <input type="number" 
                           name="fat_grams_per_serving" 
                           value="{{ old('fat_grams_per_serving') }}"
                           min="0"
                           step="0.1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fat_grams_per_serving') border-red-500 @enderror"
                           required>
                    @error('fat_grams_per_serving')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Cost -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Cost (₱) *</label>
                    <input type="number" 
                           name="estimated_cost" 
                           value="{{ old('estimated_cost') }}"
                           min="0"
                           step="0.01"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('estimated_cost') border-red-500 @enderror"
                           required>
                    @error('estimated_cost')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Allergies -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Allergies (if any)</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($allergies as $allergy)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" 
                                   name="allergies[]" 
                                   value="{{ $allergy->id }}"
                                   {{ in_array($allergy->id, old('allergies', [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">{{ $allergy->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('allergies')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nutrition Summary (Auto-calculated) -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-medium text-gray-800 mb-3">Nutrition Summary</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Calories:</span>
                        <span id="summary-calories" class="font-medium ml-2">0</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Protein:</span>
                        <span id="summary-protein" class="font-medium ml-2">0g</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Carbs:</span>
                        <span id="summary-carbs" class="font-medium ml-2">0g</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Fat:</span>
                        <span id="summary-fat" class="font-medium ml-2">0g</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('nutrition.create') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Create Food Item
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const caloriesInput = document.querySelector('input[name="calories_per_serving"]');
    const proteinInput = document.querySelector('input[name="protein_grams_per_serving"]');
    const carbsInput = document.querySelector('input[name="carb_grams_per_serving"]');
    const fatInput = document.querySelector('input[name="fat_grams_per_serving"]');
    
    const summaryCalories = document.getElementById('summary-calories');
    const summaryProtein = document.getElementById('summary-protein');
    const summaryCarbs = document.getElementById('summary-carbs');
    const summaryFat = document.getElementById('summary-fat');
    
    function updateSummary() {
        const calories = parseFloat(caloriesInput.value) || 0;
        const protein = parseFloat(proteinInput.value) || 0;
        const carbs = parseFloat(carbsInput.value) || 0;
        const fat = parseFloat(fatInput.value) || 0;
        
        summaryCalories.textContent = calories.toFixed(0);
        summaryProtein.textContent = protein.toFixed(1) + 'g';
        summaryCarbs.textContent = carbs.toFixed(1) + 'g';
        summaryFat.textContent = fat.toFixed(1) + 'g';
    }
    
    // Update summary on input change
    [caloriesInput, proteinInput, carbsInput, fatInput].forEach(input => {
        input.addEventListener('input', updateSummary);
    });
    
    // Initial update
    updateSummary();
});
</script>
@endsection