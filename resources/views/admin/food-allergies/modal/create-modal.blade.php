<div id="create-modal" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
        <button onclick="closeCreateModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add Food Item Allergies</h2>

        <form method="POST" action="{{ route('admin.food_item_allergies.store') }}">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <!-- Food Item Selection -->
                <div>
                    <label for="food_item_id" class="block text-sm font-medium text-gray-700 mb-1">Select Food Item</label>
                    <select id="food_item_id" name="food_item_id" class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                        <option value="">Choose a food item...</option>
                        @foreach($foodItems as $foodItem)
                            <option value="{{ $foodItem->id }}" {{ old('food_item_id') == $foodItem->id ? 'selected' : '' }}>
                                {{ $foodItem->name }} ({{ $foodItem->serving_size_description }})
                            </option>
                        @endforeach
                    </select>
                    @error('food_item_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Allergies Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Allergies to Associate</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                        @foreach($allergies as $allergy)
                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-white rounded-lg p-2 transition-colors">
                                <input type="checkbox" 
                                       name="allergy_ids[]" 
                                       value="{{ $allergy->id }}" 
                                       {{ in_array($allergy->id, old('allergy_ids', [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                <span class="text-sm text-gray-700">{{ $allergy->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('allergy_ids') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    @error('allergy_ids.*') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded-lg shadow hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    Add Allergies
                </button>
            </div>
        </form>
    </div>
</div>