@extends('layout.admin')

@section('title', 'Edit Fitness Fact')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Fitness Fact</h2>

        <form method="POST" action="{{ route('fitness-facts.update', $fitnessFact->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Fact</label>
                <textarea name="fact_text" class="w-full p-2 border rounded" required>{{ old('fact_text', $fitnessFact->fact_text) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <input type="text" name="category" value="{{ old('category', $fitnessFact->category) }}"
                    class="w-full p-2 border rounded">
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('fitness-facts.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
