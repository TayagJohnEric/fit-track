<div id="create-modal" class="modal-overlay fixed inset-0 hidden items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl relative">
        <button onclick="closeCreateModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add Exercise</h2>

        <form method="POST" action="{{ route('exercises.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded">
                @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded">{{ old('description') }}</textarea>
                @error('description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Muscle Group</label>
                <input type="text" name="muscle_group" value="{{ old('muscle_group') }}" class="w-full px-4 py-2 border rounded">
                @error('muscle_group') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Equipment Needed</label>
                <input type="text" name="equipment_needed" value="{{ old('equipment_needed') }}" class="w-full px-4 py-2 border rounded">
                @error('equipment_needed') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Upload Exercise Video (optional)</label>
                <input type="file" name="video" accept="video/*" class="w-full px-4 py-2 border rounded">
                @error('video') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Create</button>
            </div>
        </form>
    </div>
</div>