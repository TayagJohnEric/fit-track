<div id="create-modal" class="modal-overlay fixed inset-0 hidden items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl relative">
        <button onclick="closeCreateModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add Exercise</h2>

        <form method="POST" action="{{ route('exercises.store') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="muscle_group" class="block text-sm font-medium text-gray-700 mb-1">Muscle Group</label>
                <input type="text" id="muscle_group" name="muscle_group" value="{{ old('muscle_group') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                @error('muscle_group') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="equipment_needed" class="block text-sm font-medium text-gray-700 mb-1">Equipment Needed</label>
                <input type="text" id="equipment_needed" name="equipment_needed" value="{{ old('equipment_needed') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                @error('equipment_needed') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1">YouTube Video URL (optional)</label>
                <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                @error('video_url') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Image URL (optional)</label>
                <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://img.youtube.com/vi/xxxxxxx/hqdefault.jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
                @error('image_url') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg shadow hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>