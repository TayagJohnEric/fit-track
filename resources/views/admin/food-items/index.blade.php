@extends('layout.admin')

@section('title', 'Food Items')


<style>
    /* Modal Animation Styles */
    .modal-overlay {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .modal-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        transform: scale(0.7) translateY(-50px);
        opacity: 0;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
    }

    .modal-overlay.show .modal-content {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    .modal-overlay.closing {
        opacity: 0;
        visibility: hidden;
    }

    .modal-overlay.closing .modal-content {
        transform: scale(0.7) translateY(-50px);
        opacity: 0;
    }
</style>



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

           <button onclick="openCreateModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Add New Food Item
            </button>
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
                                <button onclick="openEditModal({{ $item->id }})"
                                   class="text-blue-600 hover:underline">Edit</button>           
                                    
                                    <button  onclick="openDeleteModal({{ $item->id }})"
                                            class="text-red-600 hover:underline">Delete</button>
                            </td>

                             @include('admin.food-items.modal.edit-modal', ['item'=> $item])
                             @include('admin.food-items.modal.delete-modal', ['item'=> $item])

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

  @include('admin.food-items.modal.create-modal')


<script>

function openCreateModal() {
    const modal = document.getElementById('create-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    // Trigger animation
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeCreateModal() {
    const modal = document.getElementById('create-modal');
    modal.classList.add('closing');
    modal.classList.remove('show');
    // Hide modal after animation completes
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'closing');
    }, 300);
}

 function openEditModal(id) {
        const modal = document.getElementById('edit-modal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Trigger animation
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeEditModal(id) {
        const modal = document.getElementById('edit-modal-' + id);
        modal.classList.add('closing');
        modal.classList.remove('show');
        // Hide modal after animation completes
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'closing');
        }, 300);
    }

    function openDeleteModal(id) {
        const modal = document.getElementById('delete-modal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Trigger animation
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeDeleteModal(id) {
        const modal = document.getElementById('delete-modal-' + id);
        modal.classList.add('closing');
        modal.classList.remove('show');
        // Hide modal after animation completes
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'closing');
        }, 300);
    }
</script>

@endsection
