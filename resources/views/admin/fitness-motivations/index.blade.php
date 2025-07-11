@extends('layout.admin')

@section('title', 'Fitness Motivation')

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
            <button onclick="openCreateModal()"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + Add Motivation
        </button>
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
                                <button onclick="openEditModal({{ $motivation->id }})"
                                   class="text-blue-600 hover:underline">Edit</button>

                                <!-- Delete -->      
                                    
                                    <button onclick="openDeleteModal({{ $motivation->id }})" class="text-red-600 hover:underline">Delete</button>
                                
                            </td>
                              @include('admin.fitness-motivations.modal.edit-modal')
                            @include('admin.fitness-motivations.modal.delete-modal')
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

                            @include('admin.fitness-motivations.modal.create-modal')


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
