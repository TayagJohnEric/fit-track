@extends('layout.admin')

@section('title', 'Exercise List')

@section('content')
<style>
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
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }
</style>

<div id="loading" class="loading-overlay">
    <div class="text-gray-700 text-lg font-semibold">Loading...</div>
</div>

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
          <button onclick="openCreateModal()" 
            class="ml-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Add Exercise
          </button>
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
                               <button onclick="openEditModal({{ $exercise->id }})" class="text-blue-600 hover:underline">Edit</button>
                               <button type="button" class="text-red-600 hover:underline" onclick="openDeleteModal({{ $exercise->id }})">Delete</button>
                            </td>
                            @include('admin.exercises.modal.edit-modal', ['exercise' => $exercise])
                            @include('admin.exercises.modal.delete-modal', ['exercise' => $exercise])
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

@include('admin.exercises.modal.create-modal')

<script>
    function showLoading() {
        document.getElementById('loading').style.display = 'flex';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            if (form.method.toLowerCase() === 'post') {
                form.addEventListener('submit', () => {
                    showLoading();
                });
            }
        });
    });

    function openCreateModal() {
        const modal = document.getElementById('create-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeCreateModal() {
        const modal = document.getElementById('create-modal');
        modal.classList.add('closing');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'closing');
        }, 300);
    }

    function openEditModal(id) {
        const modal = document.getElementById('edit-modal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeEditModal(id) {
        const modal = document.getElementById('edit-modal-' + id);
        modal.classList.add('closing');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'closing');
        }, 300);
    }

    function openDeleteModal(id) {
        const modal = document.getElementById('delete-modal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeDeleteModal(id) {
        const modal = document.getElementById('delete-modal-' + id);
        modal.classList.add('closing');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'closing');
        }, 300);
    }
</script>
@endsection