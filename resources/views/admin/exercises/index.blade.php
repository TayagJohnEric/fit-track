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
    .exercise-card {
        transition: all 0.2s ease;
        border: 1px solid #f3f4f6;
    }
    .exercise-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #fbbf24;
    }
    .thumbnail-hover {
        transition: all 0.3s ease;
    }
    .thumbnail-hover:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px -5px rgba(234, 88, 12, 0.2);
    }
</style>

<div id="loading" class="loading-overlay hidden fixed inset-0 bg-white bg-opacity-80 flex items-center justify-center z-50">
    <div class="flex flex-col items-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-600 mb-3"></div>
        <div class="text-gray-700 text-sm font-medium">Loading...</div>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white py-6 sm:py-8">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center mb-3">
                <div class="w-1 h-8 bg-orange-600 rounded-full mr-4"></div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Exercise Management</h1>
            </div>
            <p class="text-gray-600 text-sm sm:text-base ml-6">Manage and organize your exercise database with ease</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-orange-50 to-amber-50 border-l-4 border-orange-600 px-6 py-4 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-orange-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-orange-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Controls Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('exercises.index') }}" class="flex-1 max-w-md">
                    <div class="relative group">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search exercises..." 
                               class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent transition-all duration-200 text-sm">
                        <svg class="absolute left-4 top-4 h-4 w-4 text-gray-400 group-focus-within:text-orange-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>
                
                <!-- Add Exercise Button -->
                <button onclick="openCreateModal()" 
                        class="inline-flex items-center px-6 py-3.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Add Exercise</span>
                    <span class="sm:hidden">Add</span>
                </button>
            </div>
        </div>

        <!-- Exercises Grid/List -->
        @if($exercises->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Preview
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Exercise Details
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Muscle Group
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Equipment
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($exercises as $exercise)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-100 last:border-b-0">
                                    <!-- Thumbnail -->
                                    <td class="px-6 py-5">
                                        <div class="flex-shrink-0">
                                            @if($exercise->image_url)
                                                <a href="{{ $exercise->video_url }}" target="_blank" class="block">
                                                    <img src="{{ $exercise->image_url }}" 
                                                         alt="Exercise thumbnail" 
                                                         class="w-20 h-12 object-cover rounded-lg shadow-sm thumbnail-hover border border-gray-200">
                                                </a>
                                            @else
                                                <div class="w-20 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center border border-gray-200">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Exercise Details -->
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-semibold text-gray-900">{{ $exercise->name }}</div>
                                    </td>
                                    
                                    <!-- Muscle Group -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                            {{ $exercise->muscle_group }}
                                        </span>
                                    </td>
                                    
                                    <!-- Equipment -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                            {{ $exercise->equipment_needed }}
                                        </span>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button onclick="openEditModal({{ $exercise->id }})" 
                                                    class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-transparent hover:border-blue-200"
                                                    title="Edit Exercise">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button type="button" 
                                                    onclick="openDeleteModal({{ $exercise->id }})" 
                                                    class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 border border-transparent hover:border-red-200"
                                                    title="Delete Exercise">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.exercises.modal.edit-modal', ['exercise' => $exercise])
                                @include('admin.exercises.modal.delete-modal', ['exercise' => $exercise])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4">
                @foreach($exercises as $exercise)
                    <div class="exercise-card bg-white rounded-2xl shadow-sm p-5">
                        <div class="flex items-start space-x-4">
                            <!-- Thumbnail -->
                            <div class="flex-shrink-0">
                                @if($exercise->image_url)
                                    <a href="{{ $exercise->video_url }}" target="_blank" class="block">
                                        <img src="{{ $exercise->image_url }}" 
                                             alt="Exercise thumbnail" 
                                             class="w-16 h-10 object-cover rounded-lg shadow-sm thumbnail-hover border border-gray-200">
                                    </a>
                                @else
                                    <div class="w-16 h-10 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center border border-gray-200">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-2 truncate">{{ $exercise->name }}</h3>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                        {{ $exercise->muscle_group }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        {{ $exercise->equipment_needed }}
                                    </span>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex items-center space-x-2">
                                    <button onclick="openEditModal({{ $exercise->id }})" 
                                            class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-transparent hover:border-blue-200"
                                            title="Edit Exercise">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" 
                                            onclick="openDeleteModal({{ $exercise->id }})" 
                                            class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 border border-transparent hover:border-red-200"
                                            title="Delete Exercise">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('admin.exercises.modal.edit-modal', ['exercise' => $exercise])
                    @include('admin.exercises.modal.delete-modal', ['exercise' => $exercise])
                @endforeach
            </div>

            <!-- Pagination -->
            @if($exercises->hasPages())
                <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
                    <div class="flex items-center justify-center">
                        {{ $exercises->withQueryString()->links() }}
                    </div>
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-16">
                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">No exercises found</h3>
                    <p class="text-gray-600 mb-6 max-w-md">Get started by creating your first exercise to build your workout database.</p>
                    <button onclick="openCreateModal()" 
                            class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Your First Exercise
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

@include('admin.exercises.modal.create-modal')

<script>
    function showLoading() {
        document.getElementById('loading').classList.remove('hidden');
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
        setTimeout(() => modal.classList.add('show'), 10);
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
        setTimeout(() => modal.classList.add('show'), 10);
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
        setTimeout(() => modal.classList.add('show'), 10);
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