@extends('layout.user')
@section('title', 'Nutrition Tracking')
@section('content')
<div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Nutrition Tracking</h1>
        <p class="text-gray-600 text-lg">Track your daily nutrition for {{ date('F j, Y') }}</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
            <svg class="h-5 w-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center">
            <svg class="h-5 w-5 text-red-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Daily Summary Card -->
    <div class=" rounded-xl shadow-sm mb-8  ">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Today's Nutrition Summary</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 lg:gap-6">
            <div class="bg-orange-50 rounded-xl p-4 text-center hover:bg-orange-100 transition-colors duration-200 border border-orange-200">
                <div class="text-2xl font-bold text-orange-600 mb-1">{{ number_format($todaysTotals['calories']) }}</div>
                <div class="text-sm font-medium text-gray-600">Calories</div>
            </div>
            <div class="bg-orange-50 rounded-xl p-4 text-center hover:bg-orange-100 transition-colors duration-200 border border-orange-200">
                <div class="text-2xl font-bold text-orange-600 mb-1">{{ number_format($todaysTotals['protein'], 1) }}g</div>
                <div class="text-sm font-medium text-gray-600">Protein</div>
            </div>
            <div class="bg-orange-50 rounded-xl p-4 text-center hover:bg-orange-100 transition-colors duration-200 border border-orange-200">
                <div class="text-2xl font-bold text-orange-600 mb-1">{{ number_format($todaysTotals['carbs'], 1) }}g</div>
                <div class="text-sm font-medium text-gray-600">Carbs</div>
            </div>
            <div class="bg-orange-50 rounded-xl p-4 text-center hover:bg-orange-100 transition-colors duration-200 border border-orange-200">
                <div class="text-2xl font-bold text-orange-600 mb-1">{{ number_format($todaysTotals['fat'], 1) }}g</div>
                <div class="text-sm font-medium text-gray-600">Fat</div>
            </div>
            <div class="bg-orange-50 rounded-xl p-4 text-center hover:bg-orange-100 transition-colors duration-200 border border-orange-200">
                <div class="text-2xl font-bold text-orange-600 mb-1">₱{{ number_format($todaysTotals['cost'], 2) }}</div>
                <div class="text-sm font-medium text-gray-600">Cost</div>
            </div>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="rounded-xl mb-8">
        <div class="flex items-center mb-6">
            <div class="h-12 w-12 flex items-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-orange-600 lucide lucide-hand-platter-icon lucide-hand-platter"><path d="M12 3V2"/><path d="m15.4 17.4 3.2-2.8a2 2 0 1 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2l-1.302-1.464A1 1 0 0 0 6.151 19H5"/><path d="M2 14h12a2 2 0 0 1 0 4h-2"/><path d="M4 10h16"/><path d="M5 10a7 7 0 0 1 14 0"/><path d="M5 14v6a1 1 0 0 1-1 1H2"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Log New Meal</h3>
            
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
            <a href="{{ route('nutrition.create', ['meal_type' => 'Breakfast']) }}" 
               class="bg-white hover:bg-white-50 text-gray-900  shadow-sm border border-gray-100 font-medium py-4 px-4 rounded-xl text-center transition-all duration-200 hover:shadow-md hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                <div class="text-2xl mb-2">🍳</div>
                <div class="font-semibold">Breakfast</div>
            </a>
            <a href="{{ route('nutrition.create', ['meal_type' => 'Lunch']) }}" 
               class="bg-green-500 hover:bg-green-600 text-white font-medium py-4 px-4 rounded-xl text-center transition-all duration-200 hover:shadow-md hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <div class="text-2xl mb-2">🥗</div>
                <div class="font-semibold">Lunch</div>
            </a>
            <a href="{{ route('nutrition.create', ['meal_type' => 'Dinner']) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-4 px-4 rounded-xl text-center transition-all duration-200 hover:shadow-md hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <div class="text-2xl mb-2">🍽️</div>
                <div class="font-semibold">Dinner</div>
            </a>
            <a href="{{ route('nutrition.create', ['meal_type' => 'Snack']) }}" 
               class="bg-purple-500 hover:bg-purple-600 text-white font-medium py-4 px-4 rounded-xl text-center transition-all duration-200 hover:shadow-md hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <div class="text-2xl mb-2">🍎</div>
                <div class="font-semibold">Snack</div>
            </a>
        </div>
    </div>

    <!-- Today's Meals -->
    <div class="">
        <div class="flex items-center mb-6">
             <div class="h-12 w-12 flex items-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-orange-600 lucide lucide-utensils-crossed-icon lucide-utensils-crossed"><path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/><path d="m2.1 21.8 6.4-6.3"/><path d="m19 5-7 7"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Today's Meals</h3>
        </div>
        
        @if($todaysMealLogs->isEmpty())
            <div class="text-center py-12">
                <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2M7 2v20M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No meals logged today</h3>
                <p class="text-gray-600 mb-6">Start by adding your first meal!</p>
                <button class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                    Log Your First Meal
                </button>
            </div>
        @else
            <div class="space-y-6 lg:space-y-8">
                @foreach(['Breakfast', 'Lunch', 'Dinner', 'Snack'] as $mealType)
                    @if($todaysMealLogs->has($mealType))
                        <div class="border-l-4 border-orange-500 pl-6 bg-orange-50 rounded-r-xl py-4 pr-4 hover:bg-orange-100 transition-colors duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-bold text-gray-800 text-lg flex items-center">
                                    <div class="h-8 w-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                        @if($mealType === 'Breakfast') 🍳
                                        @elseif($mealType === 'Lunch') 🥗
                                        @elseif($mealType === 'Dinner') 🍽️
                                        @else 🍎
                                        @endif
                                    </div>
                                    {{ $mealType }}
                                </h4>
                                <span class="text-sm text-gray-600 bg-white px-3 py-1 rounded-full border border-gray-200">
                                    {{ $todaysMealLogs[$mealType]->sum(function($mealLog) { return $mealLog->mealLogEntries->count(); }) }} 
                                    {{ $todaysMealLogs[$mealType]->sum(function($mealLog) { return $mealLog->mealLogEntries->count(); }) === 1 ? 'item' : 'items' }}
                                </span>
                            </div>
                            <div class="space-y-3">
                                @foreach($todaysMealLogs[$mealType] as $mealLog)
                                    @foreach($mealLog->mealLogEntries as $entry)
                                        <div class="flex items-center justify-between bg-white rounded-xl p-4 hover:shadow-sm transition-all duration-200 border border-gray-100">
                                            <div class="flex items-start space-x-4 flex-1">
                                                <div class="h-10 w-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2M7 2v20M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-semibold text-gray-900 mb-1">{{ $entry->foodItem->name }}</div>
                                                    <div class="text-sm text-gray-600 mb-2">
                                                        Quantity: {{ $entry->quantity_consumed }} × {{ $entry->foodItem->serving_size_description }}
                                                    </div>
                                                    <div class="flex flex-wrap gap-4 text-xs">
                                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full border border-blue-200">
                                                            <strong>{{ number_format($entry->foodItem->calories_per_serving * $entry->quantity_consumed) }}</strong> cal
                                                        </span>
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full border border-green-200">
                                                            P: {{ number_format($entry->foodItem->protein_grams_per_serving * $entry->quantity_consumed, 1) }}g
                                                        </span>
                                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full border border-yellow-200">
                                                            C: {{ number_format($entry->foodItem->carb_grams_per_serving * $entry->quantity_consumed, 1) }}g
                                                        </span>
                                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full border border-purple-200">
                                                            F: {{ number_format($entry->foodItem->fat_grams_per_serving * $entry->quantity_consumed, 1) }}g
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <form method="POST" action="{{ route('nutrition.entry.destroy', $entry->id) }}" class="inline ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                                        onclick="return confirm('Are you sure you want to remove this item?')"
                                                        title="Remove item">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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