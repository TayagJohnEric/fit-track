<!-- Create Modal Wrapper -->
<div id="create-modal" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="modal-content bg-white rounded-lg p-6 max-w-xl w-full relative">
        <!-- Close Button -->
        <button onclick="closeCreateModal()" class="absolute top-3 right-3 text-gray-600 hover:text-black text-2xl font-bold">&times;</button>

        <!-- Modal Content -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add New Fitness Motivation</h2>

        <form method="POST" action="{{ route('fitness-motivations.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Quote</label>
                <textarea name="quote" required class="w-full border rounded p-2">{{ old('quote') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Author (optional)</label>
                <input type="text" name="author" class="w-full border rounded p-2" value="{{ old('author') }}">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
                <button type="button" onclick="closeCreateModal()" class="text-gray-600 underline">Cancel</button>
            </div>
        </form>
    </div>
</div>
