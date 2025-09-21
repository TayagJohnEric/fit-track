<div id="create-modal" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
  <div class="modal-content bg-white rounded-lg p-6 max-w-4xl w-full relative">
    <!-- Close Button -->
    <button onclick="closeCreateModal()" class="absolute top-2 right-2 text-gray-600 hover:text-orange-600 text-2xl">&times;</button>

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Add Exercise to Template</h2>

    <form method="POST" action="{{ route('workout-template-exercises.store') }}">
      @csrf

      <div class="grid grid-cols-2 gap-4">
        <select name="template_id" class="border p-2 rounded focus:border-orange-600 focus:ring-2 focus:ring-orange-600">
          <option value="">Select Template</option>
          @foreach($templates as $template)
            <option value="{{ $template->id }}">{{ $template->name }}</option>
          @endforeach
        </select>

        <select name="exercise_id" class="border p-2 rounded focus:border-orange-600 focus:ring-2 focus:ring-orange-600">
          <option value="">Select Exercise</option>
          @foreach($allExercises as $exercise)
            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
          @endforeach
        </select>

        <input type="number" name="sets" placeholder="Sets" class="border p-2 rounded focus:border-orange-600 focus:ring-2 focus:ring-orange-600">
        <input type="text" name="reps" placeholder="Reps" class="border p-2 rounded focus:border-orange-600 focus:ring-2 focus:ring-orange-600">
        <input type="number" name="duration_seconds" placeholder="Duration (sec)" class="border p-2 rounded focus:border-orange-600 focus:ring-2 focus:ring-orange-600">
        <input type="number" name="rest_seconds" placeholder="Rest (sec)" class="border p-2 rounded focus:border-orange-600 focus:ring-2 focus:ring-orange-600">
        <input type="number" name="order_in_workout" placeholder="Order" class="border p-2 rounded focus:border-orange-600 focus:ring-2 focus:ring-orange-600">

        <div class="col-span-2 flex justify-end gap-2">
          <!-- Cancel Button -->
          <button type="button" onclick="closeCreateModal()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
            Cancel
          </button>
          <!-- Orange Submit Button -->
          <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
            Add Exercise
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
