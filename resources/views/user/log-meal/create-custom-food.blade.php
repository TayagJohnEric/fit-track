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

    <div class=" p-6">
           <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
             <li class="inline-flex items-center">
                <a href="{{ route('nutrition.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200">
                    Nutrition
                </a>
            </li>
            <li class="inline-flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                <a href="{{ route('nutrition.create') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200">
                    Meal Log
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-orange-600">Add Custom Food</span>
                </div>
            </li>
        </ol>
    </nav>     
        <div class="flex items-center justify-between mt-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add Custom Food Item</h2>
        </div>

        <form method="POST" action="{{ route('nutrition.custom-food.store') }}" enctype="multipart/form-data" class="space-y-6">
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

            <!-- Food Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Food Image (optional)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image_url" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                <span>Upload a file</span>
                                <input id="image_url" name="image_url" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                <div id="image-preview" class="mt-4 hidden">
                    <img id="preview-img" src="" alt="Preview" class="max-w-xs h-32 object-cover rounded-lg border border-gray-300">
                    <button type="button" id="remove-image" class="mt-2 text-sm text-red-600 hover:text-red-800">Remove image</button>
                </div>
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-orange-600 border border-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 hover:border-orage-600 transition-all duration-200 shadow-sm">
                        Create Custom Food
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
    
    // Image upload preview functionality
    const imageInput = document.getElementById('image_url');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const removeImageBtn = document.getElementById('remove-image');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        previewImg.src = '';
    });
});
</script>
@endsection