@extends('layout.admin')

@section('title', 'Edit Fitness Motivation')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Fitness Motivation</h2>

        <form method="POST" action="{{ route('fitness-motivations.update', $fitnessMotivation->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Quote</label>
                <textarea name="quote" required class="w-full border rounded p-2">{{ old('quote', $fitnessMotivation->quote) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Author (optional)</label>
                <input type="text" name="author" class="w-full border rounded p-2" value="{{ old('author', $fitnessMotivation->author) }}">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('fitness-motivations.index') }}" class="text-gray-600 underline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
