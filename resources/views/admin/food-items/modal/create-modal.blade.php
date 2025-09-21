<div id="create-modal" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
        <button onclick="closeCreateModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add Food Item</h2>

        <form method="POST" action="{{ route('food_items.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="serving_size_description" class="block text-sm font-medium text-gray-700 mb-1">Serving Size Description</label>
                    <input type="text" id="serving_size_description" name="serving_size_description" value="{{ old('serving_size_description') }}" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('serving_size_description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="serving_size_grams" class="block text-sm font-medium text-gray-700 mb-1">Serving Size (grams)</label>
                    <input type="number" id="serving_size_grams" name="serving_size_grams" value="{{ old('serving_size_grams') }}" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('serving_size_grams') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="calories_per_serving" class="block text-sm font-medium text-gray-700 mb-1">Calories per Serving</label>
                    <input type="number" id="calories_per_serving" name="calories_per_serving" value="{{ old('calories_per_serving') }}" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('calories_per_serving') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="protein_grams_per_serving" class="block text-sm font-medium text-gray-700 mb-1">Protein (g)</label>
                    <input type="number" step="0.1" id="protein_grams_per_serving" name="protein_grams_per_serving" value="{{ old('protein_grams_per_serving') }}" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('protein_grams_per_serving') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="carb_grams_per_serving" class="block text-sm font-medium text-gray-700 mb-1">Carbs (g)</label>
                    <input type="number" step="0.1" id="carb_grams_per_serving" name="carb_grams_per_serving" value="{{ old('carb_grams_per_serving') }}" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('carb_grams_per_serving') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="fat_grams_per_serving" class="block text-sm font-medium text-gray-700 mb-1">Fat (g)</label>
                    <input type="number" step="0.1" id="fat_grams_per_serving" name="fat_grams_per_serving" value="{{ old('fat_grams_per_serving') }}" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('fat_grams_per_serving') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="estimated_cost" class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost (₱)</label>
                    <input type="number" step="0.01" id="estimated_cost" name="estimated_cost" value="{{ old('estimated_cost') }}" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('estimated_cost') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Upload Image (optional)</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                    @error('image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                @if(isset($foodItem) && $foodItem->image_url)
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 mt-2">Current Image:</p>
                        <img src="{{ asset('storage/' . $foodItem->image_url) }}" alt="Food Image" class="w-32 h-32 object-cover rounded mt-2 border">
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded-lg shadow hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>