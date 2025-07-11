<div id="edit-modal-{{ $item->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="modal-content bg-white rounded-lg p-6 max-w-4xl w-full">
                        <button onclick="closeEditModal({{ $item->id }})" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Exercise in Template</h2>

        <form method="POST" action="{{ route('workout-template-exercises.update', $item->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <select name="template_id" class="border p-2 rounded">
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}" {{$item->template_id == $template->id ? 'selected' : '' }}>
                            {{ $template->name }}
                        </option>
                    @endforeach
                </select>

                <select name="exercise_id" class="border p-2 rounded">
                    @foreach($allExercises as $exercise)
                        <option value="{{ $exercise->id }}" {{ $item->exercise_id == $exercise->id ? 'selected' : '' }}>
                            {{ $exercise->name }}
                        </option> 
                    @endforeach
                </select>

                <input type="number" name="sets" value="{{ $item->sets }}" class="border p-2 rounded">
                <input type="text" name="reps" value="{{ $item->reps }}" class="border p-2 rounded">
                <input type="number" name="duration_seconds" value="{{ $item->duration_seconds }}" class="border p-2 rounded">
                <input type="number" name="rest_seconds" value="{{ $item->rest_seconds }}" class="border p-2 rounded">
                <input type="number" name="order_in_workout" value="{{ $item->order_in_workout }}" class="border p-2 rounded">

                <div class="col-span-2 flex justify-between">
                    <button type="button" onclick="closeEditModal({{ $item->id }})" class="text-red-600 hover:underline">Cancel</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
