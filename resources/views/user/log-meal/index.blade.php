@extends('layout.user')
@section('title', 'Nutrition Tracking')
@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Daily Summary Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Today's Nutrition Summary</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-blue-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ number_format($todaysTotals['calories']) }}</div>
                <div class="text-sm text-gray-600">Calories</div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-600">{{ number_format($todaysTotals['protein'], 1) }}g</div>
                <div class="text-sm text-gray-600">Protein</div>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ number_format($todaysTotals['carbs'], 1) }}g</div>
                <div class="text-sm text-gray-600">Carbs</div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-purple-600">{{ number_format($todaysTotals['fat'], 1) }}g</div>
                <div class="text-sm text-gray-600">Fat</div>
            </div>
            <div class="bg-indigo-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600">₱{{ number_format($todaysTotals['cost'], 2) }}</div>
                <div class="text-sm text-gray-600">Cost</div>
            </div>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Log New Meal</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('nutrition.create', ['meal_type' => 'Breakfast']) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-4 rounded-lg text-center transition duration-200">
                <div class="text-2xl mb-1">🍳</div>
                Breakfast
            </a>
            <a href="{{ route('nutrition.create', ['meal_type' => 'Lunch']) }}" 
               class="bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg text-center transition duration-200">
                <div class="text-2xl mb-1">🥗</div>
                Lunch
            </a>
            <a href="{{ route('nutrition.create', ['meal_type' => 'Dinner']) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-lg text-center transition duration-200">
                <div class="text-2xl mb-1">🍽️</div>
                Dinner
            </a>
            <a href="{{ route('nutrition.create', ['meal_type' => 'Snack']) }}" 
               class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-lg text-center transition duration-200">
                <div class="text-2xl mb-1">🍎</div>
                Snack
            </a>
        </div>
    </div>

    <!-- Today's Meals -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Today's Meals</h3>
        
        @if($todaysMealLogs->isEmpty())
            <div class="text-center py-8">
                <div class="text-gray-400 text-4xl mb-4">🍽️</div>
                <p class="text-gray-600">No meals logged today. Start by adding your first meal!</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach(['Breakfast', 'Lunch', 'Dinner', 'Snack'] as $mealType)
                    @if($todaysMealLogs->has($mealType))
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-2">{{ $mealType }}</h4>
                            <div class="space-y-2">
                                @foreach($todaysMealLogs[$mealType] as $mealLog)
                                    @foreach($mealLog->mealLogEntries as $entry)
                                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                            <div class="flex-1">
                                                <div class="font-medium text-gray-800">{{ $entry->foodItem->name }}</div>
                                                <div class="text-sm text-gray-600">
                                                    Quantity: {{ $entry->quantity_consumed }} × {{ $entry->foodItem->serving_size_description }}
                                                </div>
                                            </div>
                                            <div class="text-right mr-4">
                                                <div class="text-sm font-medium text-gray-800">
                                                    {{ number_format($entry->foodItem->calories_per_serving * $entry->quantity_consumed) }} cal
                                                </div>
                                                <div class="text-xs text-gray-600">
                                                    P: {{ number_format($entry->foodItem->protein_grams_per_serving * $entry->quantity_consumed, 1) }}g |
                                                    C: {{ number_format($entry->foodItem->carb_grams_per_serving * $entry->quantity_consumed, 1) }}g |
                                                    F: {{ number_format($entry->foodItem->fat_grams_per_serving * $entry->quantity_consumed, 1) }}g
                                                </div>
                                            </div>
                                            <form method="POST" action="{{ route('nutrition.entry.destroy', $entry->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 p-1"
                                                        onclick="return confirm('Are you sure you want to remove this item?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection