<!-- Create Modal Wrapper -->
<div id="create-modal" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
  <div class="modal-content bg-white rounded-lg p-6 max-w-xl w-full relative">
    <!-- Close Button -->
    <button onclick="closeCreateModal()" class="absolute top-3 right-3 text-gray-600 hover:text-orange-600 text-2xl font-bold">&times;</button>

    <!-- Modal Content -->
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Add New Fitness Motivation</h2>

    <form method="POST" action="{{ route('fitness-motivations.store') }}" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-700">Quote</label>
        <textarea name="quote" required class="w-full border rounded p-2 focus:border-orange-600 focus:ring-2 focus:ring-orange-600">{{ old('quote') }}</textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Author (optional)</label>
        <input type="text" name="author" class="w-full border rounded p-2 focus:border-orange-600 focus:ring-2 focus:ring-orange-600" value="{{ old('author') }}">
      </div>

      <div class="flex gap-2 justify-end">
        <!-- Cancel button (gray) -->
        <button type="button" onclick="closeCreateModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
          Cancel
        </button>
        <!-- Save button (orange) -->
        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
          Save
        </button>
      </div>
    </form>
  </div>
</div>
