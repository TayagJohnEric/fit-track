@extends('layout.user')
@section('title', 'Meal Ideas - Budget-Based Suggestions')
@section('content')
<div class="max-w-[90rem] mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Meal Ideas</h2>
        <p class="text-gray-600 mb-6">Discover affordable meal options that align with your budget and fitness goals.</p>
        
        <!-- Budget Input Form -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-6">
            <form method="GET" action="{{ route('meal-ideas.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">
                        Budget per meal (₱)
                    </label>
                    <input 
                        type="number" 
                        id="budget" 
                        name="budget" 
                        min="1" 
                        step="0.01" 
                        value="{{ $budget ?? $defaultBudget }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter your meal budget"
                        required
                    >
                </div>
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200 flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Find Meals
                </button>
            </form>
        </div>

        @if($budget)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Results for budget: ₱{{ number_format($budget, 2) }}
                </h3>
                
                @if($mealIdeas && count($mealIdeas) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($mealIdeas as $index => $meal)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                <!-- Meal Header -->
                                <div class="p-4 border-b border-gray-100">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-lg font-medium text-gray-900">
                                            Meal Option {{ $index + 1 }}
                                        </h4>
                                        <span class="bg-green-100 text-green-800 text-sm font-medium px-2 py-1 rounded">
                                            ₱{{ number_format($meal['total_cost'], 2) }}
                                        </span>
                                    </div>
                                    
                                    <!-- Nutrition Summary -->
                                    <div class="grid grid-cols-3 gap-4 text-sm">
                                        <div class="text-center">
                                            <div class="text-orange-600 font-semibold">{{ $meal['total_calories'] }}</div>
                                            <div class="text-gray-500">Calories</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-blue-600 font-semibold">{{ number_format($meal['total_protein'], 1) }}g</div>
                                            <div class="text-gray-500">Protein</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-green-600 font-semibold">{{ number_format($meal['total_carbs'], 1) }}g</div>
                                            <div class="text-gray-500">Carbs</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Food Items -->
                                <div class="p-4">
                                    <div class="space-y-3">
                                        @foreach($meal['items'] as $item)
                                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                                <div class="flex-shrink-0">
                                                    @if($item->image_url)
                                                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-12 h-12 object-cover rounded-lg">
                                                    @else
                                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h5 class="font-medium text-gray-900 truncate">{{ $item->name }}</h5>
                                                    <p class="text-sm text-gray-500">{{ $item->serving_size_description }}</p>
                                                    <p class="text-sm text-gray-600">₱{{ number_format($item->estimated_cost, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="p-4 border-t border-gray-100">
                                    <div class="flex gap-2">
                                        <a 
                                            href="{{ route('meal-ideas.show', ['items' => collect($meal['items'])->pluck('id')->toArray(), 'budget' => $budget]) }}" 
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm text-center"
                                        >
                                            View Details
                                        </a>
                                        <a 
                                            href="{{ route('meal-ideas.log-form', ['items' => collect($meal['items'])->pluck('id')->toArray(), 'budget' => $budget]) }}" 
                                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm text-center"
                                        >
                                            Log Meal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No meal ideas found</h3>
                        <p class="text-gray-500 mb-4">Try increasing your budget or check if you have too many food allergies set.</p>
                        <form method="GET" action="{{ route('meal-ideas.index') }}" class="inline">
                            <input type="hidden" name="budget" value="{{ $budget + 50 }}">
                            <button 
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                            >
                                Try ₱{{ number_format($budget + 50, 2) }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection