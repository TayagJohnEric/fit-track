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

    .user-card {
        transition: all 0.2s ease;
        border: 1px solid #f3f4f6;
    }

    .user-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #ea580c;
    }

    .profile-badge {
        transition: all 0.2s ease;
    }

    .profile-badge:hover {
        transform: scale(1.02);
    }
</style>

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white py-6 sm:py-8">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center mb-3">
                <div class="w-1 h-8 bg-orange-600 rounded-full mr-4"></div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manage Users</h1>
            </div>
            <p class="text-gray-600 text-sm sm:text-base ml-6">Manage all registered users and their profiles</p>
        </div>

        <!-- Success Message (if needed) -->
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
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex-1 max-w-md">
                    <div class="relative group">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by name or email..." 
                               class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent transition-all duration-200 text-sm">
                        <svg class="absolute left-4 top-4 h-4 w-4 text-gray-400 group-focus-within:text-orange-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>
                
                <!-- Optional: Add New User Button (if needed) -->
                <!-- 
                <button onclick="openCreateModal()" 
                        class="inline-flex items-center px-6 py-3.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Add New User</span>
                    <span class="sm:hidden">Add</span>
                </button>
                -->
            </div>
        </div>

        <!-- Users Content -->
        @if($users->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    User
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Email
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Profile
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-100 last:border-b-0">
                                    <!-- User Name -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            @if ($user->profile_image_url)
                                                <img src="{{ asset('storage/' . $user->profile_image_url) }}" alt="{{ $user->name }} profile" class="w-10 h-10 rounded-lg object-cover mr-3">
                                            @else
                                                <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center mr-3">
                                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    
                                    <!-- Email -->
                                    <td class="px-6 py-5">
                                        <span class="text-sm text-gray-600">{{ $user->email }}</span>
                                    </td>
                                    
                                    <!-- Profile -->
                                    <td class="px-6 py-5">
                                        @if ($user->userProfile)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                {{ $user->userProfile->first_name }} {{ $user->userProfile->last_name }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                                                No profile
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.users.show', $user->id) }}" 
                                               class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200 border border-transparent hover:border-gray-200"
                                               title="View User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            
                                            <button onclick="openEditModal({{ $user->id }})" 
                                                    class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-transparent hover:border-blue-200"
                                                    title="Edit User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            
                                            <button onclick="openDeleteModal({{ $user->id }})" 
                                                    class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 border border-transparent hover:border-red-200"
                                                    title="Delete User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @include('admin.manage-users.modal.edit-modal')
                                @include('admin.manage-users.modal.delete-modal')
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 p-8">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tablet/Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @forelse($users as $user)
                    <div class="user-card bg-white rounded-2xl shadow-sm p-5">
                        <div class="flex items-start justify-between mb-4">
                            <!-- User Header -->
                            <div class="flex items-center flex-1 min-w-0">
                                @if ($user->profile_image_url)
                                    <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }} profile" class="w-12 h-12 rounded-xl object-cover mr-3 flex-shrink-0">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h3 class="text-base font-semibold text-gray-900 truncate">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center space-x-2 ml-3">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="inline-flex items-center justify-center w-9 h-9 text-gray-600 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200 border border-transparent hover:border-gray-200"
                                   title="View User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                
                                <button onclick="openEditModal({{ $user->id }})" 
                                        class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-transparent hover:border-blue-200"
                                        title="Edit User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                
                                <button onclick="openDeleteModal({{ $user->id }})" 
                                        class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 border border-transparent hover:border-red-200"
                                        title="Delete User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Profile Info Badge -->
                        <div class="flex justify-start">
                            @if ($user->userProfile)
                                <div class="profile-badge bg-green-50 border border-green-200 rounded-lg px-3 py-2 inline-flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-green-700">{{ $user->userProfile->first_name }} {{ $user->userProfile->last_name }}</span>
                                </div>
                            @else
                                <div class="profile-badge bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 inline-flex items-center">
                                    <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-gray-500">No profile</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @include('admin.manage-users.modal.edit-modal')
                    @include('admin.manage-users.modal.delete-modal')
                @empty
                    <!-- Empty State -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-16">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">No users found</h3>
                            <p class="text-gray-600 mb-6 max-w-md">No users match your search criteria. Try adjusting your search terms.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
                    <div class="flex items-center justify-center">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-16">
                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">No users found</h3>
                    <p class="text-gray-600 mb-6 max-w-md">There are currently no registered users in the system.</p>
                </div>
            </div>
        @endif
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