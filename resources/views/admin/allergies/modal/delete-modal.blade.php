<div id="delete-modal-{{ $allergy->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button onclick="closeDeleteModal({{ $allergy->id }})" class="absolute top-2 right-2 text-red-600 hover:text-red-800 text-xl">
            &times;
        </button>

        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Delete Allergy</h2>
            <p class="text-gray-600">Are you sure you want to delete "<strong>{{ $allergy->name }}</strong>"?</p>
        </div>

        <!-- Warning Information -->
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-red-800 mb-1">Warning</h4>
                    <p class="text-sm text-red-700">This action cannot be undone. This will permanently delete the allergy and remove it from all associated users and food items.</p>
                </div>
            </div>
        </div>

        <!-- Statistics Display -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Impact Summary</h4>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $allergy->users()->count() }}</div>
                    <div class="text-xs text-gray-500">Affected Users</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $allergy->foodItems()->count() }}</div>
                    <div class="text-xs text-gray-500">Linked Food Items</div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.allergies.destroy', $allergy->id) }}">
            @csrf
            @method('DELETE')
            
            <div class="flex justify-end space-x-3">
                <button type="button" 
                        onclick="closeDeleteModal({{ $allergy->id }})" 
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200">
                    Delete Allergy
                </button>
            </div>
        </form>
    </div>
</div>