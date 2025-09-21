<div id="edit-modal-{{ $item->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
        <button onclick="closeEditModal({{ $item->id }})" class="absolute top-2 right-2 text-orange-600 hover:text-orange-800">
            &times;
        </button>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Food Item</h2>

        <form method="POST" action="{{ route('food_items.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}" class="w-full border rounded px-4 py-2">
                    @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Serving Size Description</label>
                    <input type="text" name="serving_size_description" value="{{ old('serving_size_description', $item->serving_size_description) }}" class="w-full border rounded px-4 py-2">
                    @error('serving_size_description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Serving Size (grams)</label>
                    <input type="number" name="serving_size_grams" value="{{ old('serving_size_grams', $item->serving_size_grams) }}" class="w-full border rounded px-4 py-2">
                    @error('serving_size_grams') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Calories per Serving</label>
                    <input type="number" name="calories_per_serving" value="{{ old('calories_per_serving', $item->calories_per_serving) }}" class="w-full border rounded px-4 py-2">
                    @error('calories_per_serving') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Protein (g)</label>
                    <input type="number" step="0.1" name="protein_grams_per_serving" value="{{ old('protein_grams_per_serving', $item->protein_grams_per_serving) }}" class="w-full border rounded px-4 py-2">
                    @error('protein_grams_per_serving') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Carbs (g)</label>
                    <input type="number" step="0.1" name="carb_grams_per_serving" value="{{ old('carb_grams_per_serving', $item->carb_grams_per_serving) }}" class="w-full border rounded px-4 py-2">
                    @error('carb_grams_per_serving') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Fat (g)</label>
                    <input type="number" step="0.1" name="fat_grams_per_serving" value="{{ old('fat_grams_per_serving', $item->fat_grams_per_serving) }}" class="w-full border rounded px-4 py-2">
                    @error('fat_grams_per_serving') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Estimated Cost (₱)</label>
                    <input type="number" step="0.01" name="estimated_cost" value="{{ old('estimated_cost', $item->estimated_cost) }}" class="w-full border rounded px-4 py-2">
                    @error('estimated_cost') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700">Replace Image (optional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full border rounded px-4 py-2">
                    @error('image') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                    @if ($item->image_url)
                        <p class="text-sm text-gray-500 mt-2">Current Image:</p>
                        <img src="{{ asset('storage/' . $item->image_url) }}" alt="Food Image" class="w-32 h-32 object-cover rounded mt-2">
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500">Update</button>
            </div>
        </form>
    </div>
</div>