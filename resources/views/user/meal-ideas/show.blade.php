@extends('layout.user')
@section('title', 'Meal Details')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Meal Details</h2>
            <a href="{{ route('meal-ideas.index', ['budget' => $budget]) }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Meal Ideas
            </a>
        </div>

        <!-- Meal Items -->
        <div class="space-y-4 mb-6">
            @foreach($items as $item)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 text-lg">{{ $item->name }}</h4>
                            <p class="text-sm text-gray-500 mb-2">{{ $item->serving_size_description }}</p>
                            <p class="text-sm font-medium text-green-600 mb-3">₱{{ number_format($item->estimated_cost, 2) }}</p>
                        </div>
                    </div>
                    
                    <!-- Nutrition Info -->
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-gray-50 rounded-lg p-3">
                        <div class="text-center">
                            <div class="font-medium text-orange-600">{{ $item->calories_per_serving }}</div>
                            <div class="text-gray-500">Calories</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-blue-600">{{ number_format($item->protein_grams_per_serving, 1) }}g</div>
                            <div class="text-gray-500">Protein</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-green-600">{{ number_format($item->carb_grams_per_serving, 1) }}g</div>
                            <div class="text-gray-500">Carbs</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-purple-600">{{ number_format($item->fat_grams_per_serving, 1) }}g</div>
                            <div class="text-gray-500">Fats</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total Nutrition Summary -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-gray-900 mb-4 text-lg">Total Nutrition</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ $totals['calories'] }}</div>
                    <div class="text-gray-600">Calories</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($totals['protein'], 1) }}g</div>
                    <div class="text-gray-600">Protein</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($totals['carbs'], 1) }}g</div>
                    <div class="text-gray-600">Carbs</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ number_format($totals['fats'], 1) }}g</div>
                    <div class="text-gray-600">Fats</div>
                </div>
            </div>
            <div class="mt-6 text-center border-t border-gray-200 pt-4">
                <div class="text-3xl font-bold text-green-600">₱{{ number_format($totals['cost'], 2) }}</div>
                <div class="text-gray-600">Total Cost</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 justify-center">
            <a href="{{ route('meal-ideas.log-form', ['items' => $items->pluck('id')->toArray(), 'budget' => $budget]) }}" 
               class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Log This Meal
            </a>
            <a href="{{ route('meal-ideas.index', ['budget' => $budget]) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Try Another Meal
            </a>
        </div>
    </div>
</div>
@endsection