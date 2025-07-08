@extends('layout.admin')

@section('title', 'Food Items')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Food Items</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <form method="GET" action="{{ route('food_items.index') }}" class="w-full max-w-sm">
                <input type="text" name="search" placeholder="Search food items..." value="{{ request('search') }}"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-300">
            </form>

            <a href="{{ route('food_items.create') }}" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Add New
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Calories</th>
                        <th class="px-4 py-2 border">Protein</th>
                        <th class="px-4 py-2 border">Carbs</th>
                        <th class="px-4 py-2 border">Fat</th>
                        <th class="px-4 py-2 border">Cost</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($foodItems as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->name }}</td>
                            <td class="border px-4 py-2">{{ $item->calories_per_serving }}</td>
                            <td class="border px-4 py-2">{{ $item->protein_grams_per_serving }}g</td>
                            <td class="border px-4 py-2">{{ $item->carb_grams_per_serving }}g</td>
                            <td class="border px-4 py-2">{{ $item->fat_grams_per_serving }}g</td>
                            <td class="border px-4 py-2">₱{{ number_format($item->estimated_cost, 2) }}</td>
                            <td class="border px-4 py-2 flex space-x-2">
                                <a href="{{ route('food_items.edit', $item->id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('food_items.destroy', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this item?')"
                                            class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-gray-500">No food items found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $foodItems->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
