<div id="edit-modal-{{ $t->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
  <div class="modal-content bg-white rounded-lg p-6 max-w-2xl w-full relative">
    <button onclick="closeEditModal({{ $t->id }})" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>

    <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Workout Template</h2>

    <form method="POST" action="{{ route('workout_templates.update', $t->id) }}">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700">Name</label>
          <input type="text" name="name" value="{{ old('name', $t->name) }}" class="w-full border rounded px-4 py-2">
          @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="block text-gray-700">Description</label>
          <textarea name="description" rows="3" class="w-full border rounded px-4 py-2">{{ old('description', $t->description) }}</textarea>
          @error('description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="block text-gray-700">Experience Level</label>
          <select name="experience_level_id" class="w-full border rounded px-4 py-2">
            @foreach($levels as $id => $name)
              <option value="{{ $id }}" {{ old('experience_level_id', $t->experience_level_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
          @error('experience_level_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="block text-gray-700">Workout Type</label>
          <select name="workout_type_id" class="w-full border rounded px-4 py-2">
            @foreach($types as $id => $name)
              <option value="{{ $id }}" {{ old('workout_type_id', $t->workout_type_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
          @error('workout_type_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="block text-gray-700">Duration (minutes)</label>
          <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $t->duration_minutes) }}" class="w-full border rounded px-4 py-2">
          @error('duration_minutes') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="block text-gray-700">Difficulty Level (1–5)</label>
          <input type="number" name="difficulty_level" value="{{ old('difficulty_level', $t->difficulty_level) }}" min="1" max="5" class="w-full border rounded px-4 py-2">
          @error('difficulty_level') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>
      </div>

      <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
    </form>
  </div>
</div>
