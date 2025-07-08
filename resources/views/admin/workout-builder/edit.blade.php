@extends('layout.admin')

@section('title', 'Edit Workout Template Exercise')

@section('content')
<div class="max-w-[60rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Exercise in Template</h2>

        <form method="POST" action="{{ route('workout-template-exercises.update', $editing) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <select name="template_id" class="border p-2 rounded">
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}" {{ $editing->template_id == $template->id ? 'selected' : '' }}>
                            {{ $template->name }}
                        </option>
                    @endforeach
                </select>

                <select name="exercise_id" class="border p-2 rounded">
                    @foreach($allExercises as $exercise)
                        <option value="{{ $exercise->id }}" {{ $editing->exercise_id == $exercise->id ? 'selected' : '' }}>
                            {{ $exercise->name }}
                        </option>
                    @endforeach
                </select>

                <input type="number" name="sets" value="{{ $editing->sets }}" class="border p-2 rounded">
                <input type="text" name="reps" value="{{ $editing->reps }}" class="border p-2 rounded">
                <input type="number" name="duration_seconds" value="{{ $editing->duration_seconds }}" class="border p-2 rounded">
                <input type="number" name="rest_seconds" value="{{ $editing->rest_seconds }}" class="border p-2 rounded">
                <input type="number" name="order_in_workout" value="{{ $editing->order_in_workout }}" class="border p-2 rounded">

                <div class="col-span-2 flex justify-between">
                    <a href="{{ route('workout-template-exercises.index') }}" class="text-red-600 hover:underline">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
