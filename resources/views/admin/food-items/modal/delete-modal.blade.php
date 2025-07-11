<!-- Delete Confirmation Modal Wrapper -->
<div id="delete-modal-{{ $item->id }}" class="modal-overlay fixed inset-0 hidden items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <button onclick="closeDeleteModal({{ $item->id }})" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-xl font-bold text-gray-800 mb-4">Delete Confirmation</h2>
        <p class="mb-6 text-gray-700">Are you sure you want to delete this item? This action cannot be undone.</p>

        <form action="{{ route('food_items.destroy', $item->id) }}"  method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeDeleteModal({{ $item->id }})" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>