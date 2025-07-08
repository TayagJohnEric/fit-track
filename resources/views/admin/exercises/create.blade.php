@extends('layout.admin')

@section('title', 'Add Exercise')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add Exercise</h2>

        <form method="POST" action="{{ route('exercises.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-2 border rounded">
                @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border rounded">{{ old('description') }}</textarea>
                @error('description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Muscle Group</label>
                <input type="text" name="muscle_group" value="{{ old('muscle_group') }}"
                       class="w-full px-4 py-2 border rounded">
                @error('muscle_group') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Equipment Needed</label>
                <input type="text" name="equipment_needed" value="{{ old('equipment_needed') }}"
                       class="w-full px-4 py-2 border rounded">
                @error('equipment_needed') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Video URL (optional)</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}"
                       class="w-full px-4 py-2 border rounded">
                @error('video_url') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Create</button>
        </form>
    </div>
</div>
@endsection
