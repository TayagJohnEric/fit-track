<div id="edit-modal-{{  $fact->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="modal-content bg-white rounded-lg p-6 max-w-4xl w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Fitness Fact</h2>

        <form method="POST" action="{{ route('fitness-facts.update', $fact->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Fact</label>
                <textarea name="fact_text" class="w-full p-2 border rounded" required>{{ old('fact_text', $fact->fact_text) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <input type="text" name="category" value="{{ old('category', $fact->category) }}" class="w-full p-2 border rounded">
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update
                </button>
                <button type="button" onclick="closeEditModal({{  $fact->id }})" class="text-gray-600 hover:underline">Cancel</button>
            </div>
        </form>
    </div>
</div>
