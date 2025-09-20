@extends('layout.admin')
@section('title', 'Workout Templates')

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

    .template-card {
        transition: all 0.2s ease;
        border: 1px solid #f3f4f6;
    }

    .template-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #fbbf24;
    }

    .difficulty-stars {
        transition: all 0.2s ease;
    }

    .difficulty-stars:hover {
        transform: scale(1.05);
    }
</style>

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white py-6 sm:py-8">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center mb-3">
                <div class="w-1 h-8 bg-orange-600 rounded-full mr-4"></div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Workout Templates</h1>
            </div>
            <p class="text-gray-600 text-sm sm:text-base ml-6">Create and manage workout templates for different fitness levels</p>
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
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
                
                <!-- Filters Form -->
                <form method="GET" action="{{ route('workout_templates.index') }}" class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="relative group">
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search }}" 
                                   placeholder="Search templates..." 
                                   class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent transition-all duration-200 text-sm">
                            <svg class="absolute left-4 top-4 h-4 w-4 text-gray-400 group-focus-within:text-orange-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Experience Level Select -->
                        <div class="relative">
                            <select name="experience_level_id" 
                                    class="w-full px-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent transition-all duration-200 text-sm appearance-none">
                                <option value="">All Levels</option>
                                @foreach($levels as $id => $name)
                                    <option value="{{ $id }}" @selected($level == $id)>{{ $name }}</option>
                                @endforeach
                            </select>
                            <svg class="absolute right-3 top-4 h-4 w-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Workout Type Select -->
                        <div class="relative">
                            <select name="workout_type_id" 
                                    class="w-full px-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent transition-all duration-200 text-sm appearance-none">
                                <option value="">All Types</option>
                                @foreach($types as $id => $name)
                                    <option value="{{ $id }}" @selected($type == $id)>{{ $name }}</option>
                                @endforeach
                            </select>
                            <svg class="absolute right-3 top-4 h-4 w-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Filter Button -->
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                            </svg>
                            Filter
                        </button>
                    </div>
                </form>
                
                <!-- Add New Template Button -->
                <div class="xl:ml-4">
                    <button onclick="openCreateModal()" 
                            class="w-full xl:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="hidden sm:inline">Add New Template</span>
                        <span class="sm:hidden">Add Template</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Templates Content -->
        @if($templates->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Template
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Level
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Type
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Duration
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Difficulty
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($templates as $t)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-100 last:border-b-0">
                                    <!-- Template Name -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $t->name }}</div>
                                        </div>
                                    </td>
                                    
                                    <!-- Experience Level -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                            {{ $t->experienceLevel->name }}
                                        </span>
                                    </td>
                                    
                                    <!-- Workout Type -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                            {{ $t->workoutType->name }}
                                        </span>
                                    </td>
                                    
                                    <!-- Duration -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center text-sm text-gray-900">
                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $t->duration_minutes }} min
                                        </div>
                                    </td>
                                    
                                    <!-- Difficulty -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center difficulty-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $t->difficulty_level ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button onclick="openEditModal({{ $t->id }})" 
                                                    class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-transparent hover:border-blue-200"
                                                    title="Edit Template">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="openDeleteModal({{ $t->id }})" 
                                                    class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 border border-transparent hover:border-red-200"
                                                    title="Delete Template">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.workout-templates.modal.edit-modal')
                                @include('admin.workout-templates.modal.delete-modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @foreach($templates as $t)
                    <div class="template-card bg-white rounded-2xl shadow-sm p-5">
                        <div class="flex items-start justify-between mb-4">
                            <!-- Template Header -->
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base font-semibold text-gray-900 truncate">{{ $t->name }}</h3>
                                    <div class="flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm text-gray-600">{{ $t->duration_minutes }} min</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center space-x-2 ml-3">
                                <button onclick="openEditModal({{ $t->id }})" 
                                        class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-transparent hover:border-blue-200"
                                        title="Edit Template">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="openDeleteModal({{ $t->id }})" 
                                        class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 border border-transparent hover:border-red-200"
                                        title="Delete Template">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Template Info Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
                                <div class="text-xs font-medium text-blue-600 uppercase tracking-wide mb-1">Level</div>
                                <div class="text-sm font-bold text-blue-800">{{ $t->experienceLevel->name }}</div>
                            </div>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-3 text-center">
                                <div class="text-xs font-medium text-purple-600 uppercase tracking-wide mb-1">Type</div>
                                <div class="text-sm font-bold text-purple-800">{{ $t->workoutType->name }}</div>
                            </div>
                        </div>
                        
                        <!-- Difficulty Stars -->
                        <div class="flex items-center justify-center difficulty-stars">
                            <span class="text-xs font-medium text-gray-600 mr-2">Difficulty:</span>
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $t->difficulty_level ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    @include('admin.workout-templates.modal.edit-modal')
                    @include('admin.workout-templates.modal.delete-modal')
                @endforeach
            </div>

            <!-- Pagination -->
            @if($templates->hasPages())
                <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
                    <div class="flex items-center justify-center">
                        {{ $templates->withQueryString()->links() }}
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
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">No workout templates found</h3>
                    <p class="text-gray-600 mb-6 max-w-md">Create your first workout template to help users achieve their fitness goals.</p>
                    <button onclick="openCreateModal()" 
                            class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Your First Template
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

@include('admin.workout-templates.modal.create-modal')

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