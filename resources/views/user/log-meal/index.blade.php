@extends('layout.user')
@section('title', 'Nutrition Tracking')
@section('content')
<div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header Section -->
    <div class="mb-6 sm:mb-8">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-1">Today's Nutrition Summary</h1>
        <p class="text-gray-600 text-sm sm:text-md">Track your daily nutrition for {{ date('F j, Y') }}</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="success-message" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm sm:text-base">{{ session('success') }}</span>
            </div>
            <button onclick="closeMessage('success-message')" class="text-green-600 hover:text-green-800 ml-3 flex-shrink-0">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div id="error-message" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span class="text-sm sm:text-base">{{ session('error') }}</span>
            </div>
            <button onclick="closeMessage('error-message')" class="text-red-600 hover:text-red-800 ml-3 flex-shrink-0">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    <!-- Daily Summary Card -->
    <div class="rounded-xl shadow-sm mb-6 sm:mb-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-4 sm:p-6">
                <div class="text-xl sm:text-2xl font-bold text-orange-500 mb-1">{{ number_format($todaysTotals['calories']) }}</div>
                <div class="text-xs sm:text-sm font-medium text-gray-600">Calories</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-4 sm:p-6">
                <div class="text-xl sm:text-2xl font-bold text-orange-600 mb-1">{{ number_format($todaysTotals['protein'], 1) }}g</div>
                <div class="text-xs sm:text-sm font-medium text-gray-600">Protein</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-4 sm:p-6">
                <div class="text-xl sm:text-2xl font-bold text-orange-600 mb-1">{{ number_format($todaysTotals['carbs'], 1) }}g</div>
                <div class="text-xs sm:text-sm font-medium text-gray-600">Carbs</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-4 sm:p-6">
                <div class="text-xl sm:text-2xl font-bold text-orange-600 mb-1">{{ number_format($todaysTotals['fat'], 1) }}g</div>
                <div class="text-xs sm:text-sm font-medium text-gray-600">Fat</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 p-4 sm:p-6 col-span-2 sm:col-span-1">
                <div class="text-xl sm:text-2xl font-bold text-green-600 mb-1">₱{{ number_format($todaysTotals['cost'], 2) }}</div>
                <div class="text-xs sm:text-sm font-medium text-gray-600">Cost</div>
            </div>
        </div>
    </div>

   <!-- Quick Action Buttons -->
<div class="rounded-xl mb-6 sm:mb-8 bg-white shadow-sm border border-gray-100 p-4 sm:p-6">
    <div class="flex items-center justify-between mb-4 sm:mb-6">
        <div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-800">Log New Meal</h3>
            <p class="text-gray-600 text-xs sm:text-sm mt-1">Choose a meal type to get started</p>
        </div>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
        @php
            $mealTypes = [
                'Breakfast' => [
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500 lucide lucide-egg-fried-icon lucide-egg-fried"><circle cx="11.5" cy="12.5" r="3.5"/><path d="M3 8c0-3.5 2.5-6 6.5-6 5 0 4.83 3 7.5 5s5 2 5 6c0 4.5-2.5 6.5-7 6.5-2.5 0-2.5 2.5-6 2.5s-7-2-7-5.5c0-3 1.5-3 1.5-5C3.5 10 3 9 3 8Z"/></svg>',
                    'label' => 'Breakfast',
                    'description' => 'Morning meal to start your day'
                ],
                'Lunch' => [
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500 lucide lucide-utensils-crossed-icon lucide-utensils-crossed"><path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/><path d="m2.1 21.8 6.4-6.3"/><path d="m19 5-7 7"/></svg>',
                    'label' => 'Lunch',
                    'description' => 'Midday meal to refuel your energy'
                ],
                'Dinner' => [
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500 lucide lucide-utensils-icon lucide-utensils"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg>',
                    'label' => 'Dinner',
                    'description' => 'Evening meal to end your day'
                ],
                'Snack' => [
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 sm:w-5 sm:h-5 text-orange-500 lucide lucide-apple-icon lucide-apple"><path d="M12 6.528V3a1 1 0 0 1 1-1h0"/><path d="M18.237 21A15 15 0 0 0 22 11a6 6 0 0 0-10-4.472A6 6 0 0 0 2 11a15.1 15.1 0 0 0 3.763 10 3 3 0 0 0 3.648.648 5.5 5.5 0 0 1 5.178 0A3 3 0 0 0 18.237 21"/></svg>',
                    'label' => 'Snack',
                    'description' => 'Light eating between main meals'
                ]
            ];
        @endphp
        
        @foreach($mealTypes as $type => $meal)
            <a href="{{ route('nutrition.create', ['meal_type' => $type]) }}" 
               class="bg-gray-100 rounded-xl p-3 sm:p-4 flex flex-col items-start space-y-2 hover:bg-gray-200 transition-colors duration-200 group">
                <div class="bg-white rounded-xl w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center mb-1 sm:mb-2">
                    {!! $meal['icon'] !!}
                </div>
                <div class="font-semibold text-gray-800 text-sm sm:text-base">{{ $meal['label'] }}</div>
                <div class="text-xs text-gray-500 hidden sm:block">{{ $meal['description'] }}</div>
            </a>
        @endforeach
    </div>
</div>

    <!-- Today's Meals -->
    <div class="rounded-xl mb-6 sm:mb-8 bg-white shadow-sm border border-gray-100 p-4 sm:p-6">
        <div class="flex items-center mb-4 sm:mb-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800">Today's Meals</h3>
        </div>
        
        @if($todaysMealLogs->isEmpty())
            <div class="text-center py-8 sm:py-12">
                <div class="h-12 w-12 sm:h-16 sm:w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2M7 2v20M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
                    </svg>
                </div>
                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">No meals logged today</h3>
                <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">Start by adding your first meal!</p>
                <a href="{{ route('nutrition.create') }}" class="bg-orange-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200 font-medium inline-block text-sm sm:text-base">
                    Log Your First Meal
                </a>
            </div>
        @else
            <div class="space-y-4 sm:space-y-6 lg:space-y-8">
                @foreach(['Breakfast', 'Lunch', 'Dinner', 'Snack'] as $mealType)
                    @if($todaysMealLogs->has($mealType))
                        <div class="pl-4 sm:pl-6 rounded-r-xl py-3 sm:py-4 pr-3 sm:pr-4">
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <h4 class="font-semibold text-gray-800 text-base sm:text-lg flex items-center">
                                    <div class="h-6 w-6 sm:h-8 sm:w-8 bg-orange-100 rounded-lg flex items-center justify-center mr-2 sm:mr-3">
                                        @if($mealType === 'Breakfast')
                                            {!! $mealTypes['Breakfast']['icon'] !!}
                                        @elseif($mealType === 'Lunch')
                                            {!! $mealTypes['Lunch']['icon'] !!}
                                        @elseif($mealType === 'Dinner')
                                            {!! $mealTypes['Dinner']['icon'] !!}
                                        @else
                                            {!! $mealTypes['Snack']['icon'] !!}
                                        @endif
                                    </div>
                                    {{ $mealType }}
                                </h4>
                                @php
                                    $itemCount = $todaysMealLogs[$mealType]->sum(function($mealLog) { 
                                        return $mealLog->mealLogEntries->count(); 
                                    });
                                @endphp
                                <span class="text-xs sm:text-sm text-gray-600 bg-white px-2 sm:px-3 py-1 rounded-full border border-gray-200">
                                    {{ $itemCount }} {{ $itemCount === 1 ? 'item' : 'items' }}
                                </span>
                            </div>
                            <div class="space-y-2 sm:space-y-3">
                                @foreach($todaysMealLogs[$mealType] as $mealLog)
                                    @foreach($mealLog->mealLogEntries as $entry)
                                        <div class="flex items-center justify-between rounded-xl mb-2 sm:mb-3 bg-gray-100 hover:shadow-md transition-shadow duration-200 p-4 sm:p-6">
                                            <div class="flex items-start space-x-3 sm:space-x-4 flex-1 min-w-0">
                                                <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-lg overflow-hidden flex-shrink-0">
                                                    @if($entry->foodItem->image_url)
                                                        <img src="{{ $entry->foodItem->image_url }}" alt="{{ $entry->foodItem->name }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 sm:h-6 sm:w-6 text-gray-400 lucide lucide-utensils-crossed-icon lucide-utensils-crossed"><path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/><path d="m2.1 21.8 6.4-6.3"/><path d="m19 5-7 7"/></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-semibold text-gray-900 mb-1 text-sm sm:text-base truncate">{{ $entry->foodItem->name }}</div>
                                                    <div class="text-xs text-gray-600 mb-2">
                                                        Quantity: {{ $entry->quantity_consumed }} × {{ $entry->foodItem->serving_size_description }}
                                                    </div>
                                                    <div class="flex flex-wrap gap-1 sm:gap-2 text-xs">
                                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full border border-blue-200 text-xs">
                                                            <strong>{{ number_format($entry->foodItem->calories_per_serving * $entry->quantity_consumed) }}</strong> cal
                                                        </span>
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full border border-green-200 text-xs">
                                                            P: {{ number_format($entry->foodItem->protein_grams_per_serving * $entry->quantity_consumed, 1) }}g
                                                        </span>
                                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full border border-yellow-200 text-xs">
                                                            C: {{ number_format($entry->foodItem->carb_grams_per_serving * $entry->quantity_consumed, 1) }}g
                                                        </span>
                                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full border border-purple-200 text-xs">
                                                            F: {{ number_format($entry->foodItem->fat_grams_per_serving * $entry->quantity_consumed, 1) }}g
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <form method="POST" action="{{ route('nutrition.entry.destroy', $entry->id) }}" class="inline ml-2 sm:ml-4 flex-shrink-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-gray-500 hover:text-red-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 p-1"
                                                        onclick="return confirm('Are you sure you want to remove this item?')"
                                                        title="Remove item">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

<script>
// Function to close message manually
function closeMessage(messageId) {
    const messageElement = document.getElementById(messageId);
    if (messageElement) {
        messageElement.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
        messageElement.style.opacity = '0';
        messageElement.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            messageElement.remove();
        }, 300);
    }
}

// Auto-close messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');
    
    if (successMessage) {
        setTimeout(() => {
            closeMessage('success-message');
        }, 5000);
    }
    
    if (errorMessage) {
        setTimeout(() => {
            closeMessage('error-message');
        }, 5000);
    }
});
</script>

@endsection