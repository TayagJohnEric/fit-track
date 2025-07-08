@extends('layout.admin')

@section('title', 'Fitness Facts')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Fitness Facts</h2>
        <p class="text-gray-600 mb-4">Manage motivational or educational fitness facts.</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex justify-between items-center">
            <form method="GET" class="w-full max-w-xs">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search facts..."
                    class="border border-gray-300 p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300">
            </form>
            <a href="{{ route('fitness-facts.create') }}"
                class="ml-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Add New
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Fact</th>
                        <th class="py-2 px-4">Category</th>
                        <th class="py-2 px-4">Created</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fitnessFacts as $fact)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $fact->id }}</td>
                            <td class="py-2 px-4">{{ $fact->fact_text }}</td>
                            <td class="py-2 px-4">{{ $fact->category ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $fact->created_at->format('M d, Y') }}</td>
                            <td class="py-2 px-4 flex gap-2">
                                <a href="{{ route('fitness-facts.edit', $fact->id) }}"
                                    class="text-blue-500 hover:underline">Edit</a>

                                <form action="{{ route('fitness-facts.destroy', $fact->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this fact?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No fitness facts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $fitnessFacts->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
