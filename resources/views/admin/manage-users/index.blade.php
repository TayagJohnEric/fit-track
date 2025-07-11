@extends('layout.admin')

@section('title', 'Manage Users')

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
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Users</h2>
        <p class="text-gray-600 mb-4">Manage all registered users (role: user).</p>

        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
            <input type="text" name="search" placeholder="Search by name or email"
                value="{{ request('search') }}"
                class="border rounded p-2 w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </form>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-200 mt-4">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Profile</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $user->id }}</td>
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">
                            @if ($user->userProfile)
                                {{ $user->userProfile->first_name }} {{ $user->userProfile->last_name }}
                            @else
                                <span class="text-gray-400 italic">No profile</span>
                            @endif
                        </td>
                        <td class="p-3 flex flex-wrap gap-2">
                            <a href="{{ route('admin.users.show', $user->id) }}"
                               class="px-3 py-1 text-sm bg-gray-500 text-white rounded hover:bg-gray-600">View</a>

                            <button onclick="openEditModal({{ $user->id }})"
                               class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>

                            
                            <button onclick="openDeleteModal({{ $user->id }})" class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                           
                        </td>
                         @include('admin.manage-users.modal.edit-modal')
                            @include('admin.manage-users.modal.delete-modal')
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 p-4">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>

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
 