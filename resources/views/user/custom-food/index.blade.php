@extends('layout.user')

@section('title', 'My Custom Foods')

@section('content')

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

    .food-card {
        transition: all 0.2s ease;
        border: 1px solid #f3f4f6;
    }

    .food-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #fbbf24;
    }

    .nutrition-badge {
        transition: all 0.2s ease;
    }

    .nutrition-badge:hover {
        transform: scale(1.02);
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white py-6 sm:py-8">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center mb-3">
                <div class="w-1 h-8 bg-orange-600 rounded-full mr-4"></div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">My Custom Foods</h1>
            </div>
            <p class="text-gray-600 text-sm sm:text-base ml-6">Manage your personal food items and nutrition database</p>
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
                <form method="GET" action="{{ route('custom-foods.index') }}" class="flex-1 max-w-md">
                    <div class="relative group">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search your custom foods..." 
                               class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent transition-all duration-200 text-sm">
                        <svg class="absolute left-4 top-4 h-4 w-4 text-gray-400 group-focus-within:text-orange-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>
                
                <!-- Add Custom Food Button -->
                <a href="{{ route('nutrition.custom-food.create') }}" 
                   class="inline-flex items-center px-6 py-3.5 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <path d="M7 21h10"/>
                        <path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"/>
                        <path d="M11.38 12a2.4 2.4 0 0 1-.4-4.77 2.4 2.4 0 0 1 3.2-2.77 2.4 2.4 0 0 1 3.47-.63 2.4 2.4 0 0 1 3.37 3.37 2.4 2.4 0 0 1-1.1 3.7 2.51 2.51 0 0 1 .03 1.1"/>
                        <path d="m13 12 4-4"/>
                        <path d="M10.9 7.25A3.99 3.99 0 0 0 4 10c0 .73.2 1.41.54 2"/>
                    </svg>
                    <span class="hidden sm:inline">Add Custom Food</span>
                    <span class="sm:hidden">Add</span>
                </a>
            </div>
        </div>

        <!-- Custom Foods Content -->
        @if($foods->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Food Item
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Serving Size
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Calories
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Protein
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Carbs
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Fat
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Cost
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($foods as $food)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-100 last:border-b-0">
                                    <!-- Food Item Name -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center mr-3 overflow-hidden">
                                                @if($food->image_url)
                                                    <img src="{{ asset('storage/' . $food->image_url) }}" alt="{{ $food->name }}" class="h-full w-full object-cover">
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-600">
                                                        <path d="M7 21h10"/>
                                                        <path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"/>
                                                        <path d="M11.38 12a2.4 2.4 0 0 1-.4-4.77 2.4 2.4 0 0 1 3.2-2.77 2.4 2.4 0 0 1 3.47-.63 2.4 2.4 0 0 1 3.37 3.37 2.4 2.4 0 0 1-1.1 3.7 2.51 2.51 0 0 1 .03 1.1"/>
                                                        <path d="m13 12 4-4"/>
                                                        <path d="M10.9 7.25A3.99 3.99 0 0 0 4 10c0 .73.2 1.41.54 2"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $food->name }}</div>
                                        </div>
                                    </td>
                                    
                                    <!-- Serving Size -->
                                    <td class="px-6 py-5">
                                        <span class="text-sm text-gray-600">{{ $food->serving_size_description }}</span>
                                    </td>
                                    
                                    <!-- Calories -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                            {{ $food->calories_per_serving }} cal
                                        </span>
                                    </td>
                                    
                                    <!-- Protein -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            {{ $food->protein_grams_per_serving }}g
                                        </span>
                                    </td>
                                    
                                    <!-- Carbs -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            {{ $food->carb_grams_per_serving }}g
                                        </span>
                                    </td>
                                    
                                    <!-- Fat -->
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            {{ $food->fat_grams_per_serving }}g
                                        </span>
                                    </td>
                                    
                                    <!-- Cost -->
                                    <td class="px-6 py-5">
                                        <span class="text-sm font-medium text-gray-900">
                                            ₱{{ number_format($food->estimated_cost, 2) }}
                                        </span>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('custom-foods.edit', $food) }}" 
                                               class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-transparent hover:border-blue-200"
                                               title="Edit Food Item">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button onclick="openDeleteModal({{ $food->id }})" 
                                                    class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 border border-transparent hover:border-red-200"
                                                    title="Delete Food Item">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @include('user.custom-food.modal.delete-modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tablet/Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @foreach($foods as $food)
                    <div class="food-card bg-white rounded-2xl shadow-sm p-5">
                        <div class="flex items-start justify-between mb-4">
                            <!-- Food Item Header -->
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl flex items-center justify-center mr-3 flex-shrink-0 overflow-hidden">
                                    @if($food->image_url)
                                        <img src="{{ asset('storage/' . $food->image_url) }}" alt="{{ $food->name }}" class="h-full w-full object-cover">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-600">
                                            <path d="M7 21h10"/>
                                            <path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"/>
                                            <path d="M11.38 12a2.4 2.4 0 0 1-.4-4.77 2.4 2.4 0 0 1 3.2-2.77 2.4 2.4 0 0 1 3.47-.63 2.4 2.4 0 0 1 3.37 3.37 2.4 2.4 0 0 1-1.1 3.7 2.51 2.51 0 0 1 .03 1.1"/>
                                            <path d="m13 12 4-4"/>
                                            <path d="M10.9 7.25A3.99 3.99 0 0 0 4 10c0 .73.2 1.41.54 2"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base font-semibold text-gray-900 truncate">{{ $food->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $food->serving_size_description }}</p>
                                    <p class="text-sm font-medium text-gray-600 mt-1">₱{{ number_format($food->estimated_cost, 2) }}</p>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center space-x-2 ml-3">
                                <a href="{{ route('custom-foods.edit', $food) }}" 
                                   class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200 border border-transparent hover:border-blue-200"
                                   title="Edit Food Item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="openDeleteModal({{ $food->id }})" 
                                        class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200 border border-transparent hover:border-red-200"
                                        title="Delete Food Item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Nutrition Info Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="nutrition-badge bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
                                <div class="text-xs font-medium text-blue-600 uppercase tracking-wide mb-1">Calories</div>
                                <div class="text-sm font-bold text-blue-800">{{ $food->calories_per_serving }}</div>
                            </div>
                            <div class="nutrition-badge bg-green-50 border border-green-200 rounded-lg p-3 text-center">
                                <div class="text-xs font-medium text-green-600 uppercase tracking-wide mb-1">Protein</div>
                                <div class="text-sm font-bold text-green-800">{{ $food->protein_grams_per_serving }}g</div>
                            </div>
                            <div class="nutrition-badge bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center">
                                <div class="text-xs font-medium text-yellow-600 uppercase tracking-wide mb-1">Carbs</div>
                                <div class="text-sm font-bold text-yellow-800">{{ $food->carb_grams_per_serving }}g</div>
                            </div>
                            <div class="nutrition-badge bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                                <div class="text-xs font-medium text-red-600 uppercase tracking-wide mb-1">Fat</div>
                                <div class="text-sm font-bold text-red-800">{{ $food->fat_grams_per_serving }}g</div>
                            </div>
                        </div>
                    </div>
                    @include('user.custom-food.modal.delete-modal')
                @endforeach
            </div>

            <!-- Pagination -->
            @if($foods->hasPages())
                <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
                    <div class="flex items-center justify-center">
                        {{ $foods->withQueryString()->links() }}
                    </div>
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-16">
                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-orange-600">
                            <path d="M7 21h10"/>
                            <path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"/>
                            <path d="M11.38 12a2.4 2.4 0 0 1-.4-4.77 2.4 2.4 0 0 1 3.2-2.77 2.4 2.4 0 0 1 3.47-.63 2.4 2.4 0 0 1 3.37 3.37 2.4 2.4 0 0 1-1.1 3.7 2.51 2.51 0 0 1 .03 1.1"/>
                            <path d="m13 12 4-4"/>
                            <path d="M10.9 7.25A3.99 3.99 0 0 0 4 10c0 .73.2 1.41.54 2"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">No custom foods yet</h3>
                    <p class="text-gray-600 mb-6 max-w-md">Start building your personal nutrition database by adding your first custom food item.</p>
                    <a href="{{ route('nutrition.custom-food.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <path d="M7 21h10"/>
                            <path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"/>
                            <path d="M11.38 12a2.4 2.4 0 0 1-.4-4.77 2.4 2.4 0 0 1 3.2-2.77 2.4 2.4 0 0 1 3.47-.63 2.4 2.4 0 0 1 3.37 3.37 2.4 2.4 0 0 1-1.1 3.7 2.51 2.51 0 0 1 .03 1.1"/>
                            <path d="m13 12 4-4"/>
                            <path d="M10.9 7.25A3.99 3.99 0 0 0 4 10c0 .73.2 1.41.54 2"/>
                        </svg>
                        Add Your First Custom Food
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
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