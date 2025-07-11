<!-- Edit Fitness Motivation Modal -->
<div id="edit-modal-{{ $motivation->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="modal-content bg-white rounded-lg p-6 max-w-md w-full relative">
        <!-- Close Button -->
        <button onclick="closeEditModal({{ $motivation->id }})" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Fitness Motivation</h2>

        <form method="POST" action="{{ route('fitness-motivations.update', $motivation->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Quote</label>
                <textarea name="quote" required class="w-full border rounded p-2">{{ old('quote', $motivation->quote) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Author (optional)</label>
                <input type="text" name="author" class="w-full border rounded p-2" value="{{ old('author', $motivation->author) }}">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                <button type="button" onclick="closeEditModal({{ $motivation->id }})" class="text-gray-600 underline">Cancel</button>
            </div>
        </form>
    </div>
</div>
