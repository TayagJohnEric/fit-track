@extends('layout.admin')

@section('title', 'Fitness Facts')

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
            <button onclick="openCreateModal()"
                class="ml-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Add New
        </button>
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
                                <button onclick="openEditModal({{ $fact->id }})"
                                    class="text-blue-500 hover:underline">Edit</a>

                                
                                    <button onclick="openDeleteModal({{ $fact->id }})" class="text-red-500 hover:underline">Delete</button>
                           
                            </td>
                              @include('admin.fitness-facts.modal.edit-modal')
                                @include('admin.fitness-facts.modal.delete-modal')

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

  @include('admin.fitness-facts.modal.create-modal')


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
