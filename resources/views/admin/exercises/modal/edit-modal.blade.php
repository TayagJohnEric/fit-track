<!-- Modal Wrapper -->
<div id="edit-modal-{{ $exercise->id }}" class="modal-overlay fixed inset-0 hidden items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl relative">
        <button onclick="closeEditModal({{ $exercise->id }})" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Exercise</h2>

        <form method="POST" action="{{ route('exercises.update', $exercise->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $exercise->name) }}" class="w-full px-4 py-2 border rounded">
                @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded">{{ old('description', $exercise->description) }}</textarea>
                @error('description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Muscle Group</label>
                <input type="text" name="muscle_group" value="{{ old('muscle_group', $exercise->muscle_group) }}" class="w-full px-4 py-2 border rounded">
                @error('muscle_group') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Equipment Needed</label>
                <input type="text" name="equipment_needed" value="{{ old('equipment_needed', $exercise->equipment_needed) }}" class="w-full px-4 py-2 border rounded">
                @error('equipment_needed') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Replace Exercise Video (optional)</label>
                <input type="file" name="video" accept="video/*" class="w-full px-4 py-2 border rounded">
                @error('video') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                @if ($exercise->video_url)
                    <p class="text-sm text-gray-500 mt-2">Current Video:</p>
                    <video width="320" height="240" controls class="mt-1">
                        <source src="{{ asset('storage/' . $exercise->video_url) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>