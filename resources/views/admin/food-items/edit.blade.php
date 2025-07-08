@extends('layout.admin')

@section('title', 'Edit Food Item')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Food Item</h2>

        <form method="POST" action="{{ route('food_items.update', $food_item->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $food_item->name) }}" class="w-full border rounded px-4 py-2">
                    @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Serving Size Description</label>
                    <input type="text" name="serving_size_description" value="{{ old('serving_size_description', $food_item->serving_size_description) }}"
                           class="w-full border rounded px-4 py-2">
                    @error('serving_size_description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Serving Size (grams)</label>
                    <input type="number" name="serving_size_grams" value="{{ old('serving_size_grams', $food_item->serving_size_grams) }}"
                           class="w-full border rounded px-4 py-2">
                    @error('serving_size_grams') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Calories per Serving</label>
                    <input type="number" name="calories_per_serving" value="{{ old('calories_per_serving', $food_item->calories_per_serving) }}"
                           class="w-full border rounded px-4 py-2">
                    @error('calories_per_serving') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Protein (g)</label>
                    <input type="number" step="0.1" name="protein_grams_per_serving" value="{{ old('protein_grams_per_serving', $food_item->protein_grams_per_serving) }}"
                           class="w-full border rounded px-4 py-2">
                    @error('protein_grams_per_serving') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Carbs (g)</label>
                    <input type="number" step="0.1" name="carb_grams_per_serving" value="{{ old('carb_grams_per_serving', $food_item->carb_grams_per_serving) }}"
                           class="w-full border rounded px-4 py-2">
                    @error('carb_grams_per_serving') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Fat (g)</label>
                    <input type="number" step="0.1" name="fat_grams_per_serving" value="{{ old('fat_grams_per_serving', $food_item->fat_grams_per_serving) }}"
                           class="w-full border rounded px-4 py-2">
                    @error('fat_grams_per_serving') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Estimated Cost (₱)</label>
                    <input type="number" step="0.01" name="estimated_cost" value="{{ old('estimated_cost', $food_item->estimated_cost) }}"
                           class="w-full border rounded px-4 py-2">
                    @error('estimated_cost') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700">Image URL (optional)</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $food_item->image_url) }}"
                           class="w-full border rounded px-4 py-2">
                    @error('image_url') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
</div>
@endsection
