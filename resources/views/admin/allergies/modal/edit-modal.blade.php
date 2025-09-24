<div id="edit-modal-{{ $allergy->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button onclick="closeEditModal({{ $allergy->id }})" class="absolute top-2 right-2 text-orange-600 hover:text-orange-800 text-xl">
            &times;
        </button>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Allergy</h2>

        <form method="POST" action="{{ route('admin.allergies.update', $allergy->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Allergy Name</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $allergy->name) }}" 
                       placeholder="e.g., Peanuts, Shellfish, Dairy"
                       class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Statistics Display -->
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Usage Statistics</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $allergy->users()->count() }}</div>
                        <div class="text-xs text-gray-500">Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $allergy->foodItems()->count() }}</div>
                        <div class="text-xs text-gray-500">Food Items</div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" 
                        onclick="closeEditModal({{ $allergy->id }})" 
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all duration-200">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>