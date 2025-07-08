@extends('layout.admin')

@section('title', 'Fitness Motivation')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Fitness Motivations</h2>
        <p class="text-gray-600 mb-4">Manage all motivational quotes for fitness inspiration.</p>

        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
        @endif

        <!-- Top Bar -->
        <div class="flex items-center justify-between mb-4">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('fitness-motivations.index') }}" class="flex gap-2">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                    class="border border-gray-300 p-2 rounded w-64" />
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
            </form>

            <!-- Add Button -->
            <a href="{{ route('fitness-motivations.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + Add Motivation
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-sm text-gray-600">
                        <th class="p-3">Quote</th>
                        <th class="p-3">Author</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($motivations as $motivation)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3 max-w-md break-words">{{ $motivation->quote }}</td>
                            <td class="p-3">{{ $motivation->author ?? '—' }}</td>
                            <td class="p-3 text-center space-x-2">
                                <!-- Edit -->
                                <a href="{{ route('fitness-motivations.edit', $motivation->id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>

                                <!-- Delete -->
                                <form action="{{ route('fitness-motivations.destroy', $motivation->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this motivation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 p-4">No motivations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $motivations->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection
