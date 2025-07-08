@extends('layout.admin')

@section('title', 'Exercise List')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Exercises</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between mb-4">
            <form method="GET" action="{{ route('exercises.index') }}" class="w-full max-w-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-300">
            </form>
            <a href="{{ route('exercises.create') }}"
               class="ml-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Exercise</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Muscle Group</th>
                        <th class="px-4 py-2 border">Equipment</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exercises as $exercise)
                        <tr>
                            <td class="px-4 py-2 border">{{ $exercise->name }}</td>
                            <td class="px-4 py-2 border">{{ $exercise->muscle_group }}</td>
                            <td class="px-4 py-2 border">{{ $exercise->equipment_needed }}</td>
                            <td class="px-4 py-2 border flex space-x-2">
                                <a href="{{ route('exercises.edit', $exercise->id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('exercises.destroy', $exercise->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">No exercises found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $exercises->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
