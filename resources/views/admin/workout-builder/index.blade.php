@extends('layout.admin')

@section('title', 'Workout Template Exercises')

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
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Workout Template Exercises</h2>
        <p class="text-gray-600 mb-4">Manage all exercises associated with workout templates.</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Bar -->
        <form method="GET" class="mb-4">
            <input type="text" name="search" placeholder="Search by exercise name..." value="{{ request('search') }}"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </form>

        <button onclick="openCreateModal()" class="inline-block bg-blue-600 text-white px-4 py-2 rounded mb-4 hover:bg-blue-700">Add New</button>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-200 text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-2">Template</th>
                        <th class="p-2">Exercise</th>
                        <th class="p-2">Sets</th>
                        <th class="p-2">Reps</th>
                        <th class="p-2">Duration</th>
                        <th class="p-2">Rest</th>
                        <th class="p-2">Order</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exercises as $item)
                        <tr class="border-t">
                            <td class="p-2">{{ $item->template->name ?? '-' }}</td>
                            <td class="p-2">{{ $item->exercise->name ?? '-' }}</td>
                            <td class="p-2">{{ $item->sets }}</td>
                            <td class="p-2">{{ $item->reps }}</td>
                            <td class="p-2">{{ $item->duration_seconds ?? '—' }}</td>
                            <td class="p-2">{{ $item->rest_seconds }}</td>
                            <td class="p-2">{{ $item->order_in_workout }}</td>
                            <td class="p-2 flex space-x-2">
                                <button onclick="openEditModal({{ $item->id }})" class="text-blue-600 hover:underline">Edit</button>
                                <button onclick="openDeleteModal({{ $item->id }})" class="text-red-600 hover:underline">Delete</button>
                            </td>

                             @include('admin.workout-builder.modal.edit-modal')
                            @include('admin.workout-builder.modal.delete-modal')

                        </tr>
                    @empty
                        <tr><td colspan="8" class="p-4 text-center text-gray-500">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $exercises->withQueryString()->links() }}
        </div>
    </div>
</div>
                            @include('admin.workout-builder.modal.create-modal')

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
