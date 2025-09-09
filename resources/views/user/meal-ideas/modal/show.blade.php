<div id="meal-details-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Meal Details</h2>
            <button id="close-meal-details" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <div class="p-6">
            <!-- Meal Items -->
            <div class="space-y-4 mb-6">
                @foreach ($items as $item)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                @if(!empty($item->image_url))
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-lg" />
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
                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-gray-100 rounded-lg p-3">
                            <div class="text-center">
                                <div class="text-gray-700 font-bold text-lg">{{ $item->calories_per_serving }}</div>
                                <div class="text-gray-500">Calories</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-700 font-bold text-lg">{{ number_format($item->protein_grams_per_serving, 1) }}g</div>
                                <div class="text-gray-500">Protein</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-700 font-bold text-lg">{{ number_format($item->carb_grams_per_serving, 1) }}g</div>
                                <div class="text-gray-500">Carbs</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-700 font-bold text-lg">{{ number_format($item->fat_grams_per_serving, 1) }}g</div>
                                <div class="text-gray-500">Fats</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Total Nutrition Summary -->
            <div class="bg-gray-100 rounded-lg p-6 mb-6">
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
        </div>
    </div>
</div>

