@extends('layout.user')
@section('title', 'Log Meal')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Log Your Meal</h2>
            <a href="{{ route('meal-ideas.show', ['items' => $items->pluck('id')->toArray(), 'budget' => $budget]) }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Meal Details
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('meal-ideas.log-meal') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Hidden inputs for items and budget -->
            @foreach($items as $item)
                <input type="hidden" name="items[]" value="{{ $item->id }}">
            @endforeach
            <input type="hidden" name="budget" value="{{ $budget }}">

            <!-- Meal Preview -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-gray-900 mb-3">Meal Summary</h3>
                <div class="space-y-2">
                    @foreach($items as $item)
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                </svg>
                            </div>
                            <span class="font-medium">{{ $item->name }}</span>
                            <span class="text-gray-500">{{ $item->serving_size_description }}</span>
                            <span class="text-green-600 font-medium ml-auto">₱{{ number_format($item->estimated_cost, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-900">Total Cost:</span>
                        <span class="text-xl font-bold text-green-600">₱{{ number_format($totals['cost'], 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Meal Type -->
            <div>
                <label for="meal_type" class="block text-sm font-medium text-gray-700 mb-2">Meal Type</label>
                <select name="meal_type" id="meal_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select meal type</option>
                    <option value="breakfast" {{ old('meal_type') == 'Breakfast' ? 'selected' : '' }}>Breakfast</option>
                    <option value="lunch" {{ old('meal_type') == 'Lunch' ? 'selected' : '' }}>Lunch</option>
                    <option value="dinner" {{ old('meal_type') == 'Dinner' ? 'selected' : '' }}>Dinner</option>
                    <option value="snack" {{ old('meal_type') == 'Snack' ? 'selected' : '' }}>Snack</option>
                </select>
                @error('meal_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Consumed Date -->
            <div>
                <label for="consumed_date" class="block text-sm font-medium text-gray-700 mb-2">Date Consumed</label>
                <input type="date" name="consumed_date" id="consumed_date" required
                       value="{{ old('consumed_date', date('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('consumed_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Consumed Time -->
            <div>
                <label for="consumed_time" class="block text-sm font-medium text-gray-700 mb-2">Time Consumed</label>
                <input type="time" name="consumed_time" id="consumed_time" required
                       value="{{ old('consumed_time', date('H:i')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('consumed_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes (Optional) -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                <textarea name="notes" id="notes" rows="3" 
                          placeholder="Any additional notes about this meal..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Satisfaction Rating -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">How satisfied were you with this meal?</label>
                <div class="flex items-center gap-4">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="satisfaction_rating" value="{{ $i }}" 
                                   {{ old('satisfaction_rating') == $i ? 'checked' : '' }}
                                   class="text-yellow-400 focus:ring-yellow-500">
                            <div class="flex">
                                @for($j = 1; $j <= 5; $j++)
                                    <svg class="w-5 h-5 {{ $j <= $i ? 'text-yellow-400' : 'text-gray-300' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</span>
                        </label>
                    @endfor
                </div>
                @error('satisfaction_rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 justify-center pt-4">
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Log This Meal
                </button>
                <a href="{{ route('meal-ideas.show', ['items' => $items->pluck('id')->toArray(), 'budget' => $budget]) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-8 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-populate time based on meal type selection
document.getElementById('meal_type').addEventListener('change', function() {
    const timeInput = document.getElementById('consumed_time');
    const currentTime = new Date();
    
    switch(this.value) {
        case 'breakfast':
            timeInput.value = '07:00';
            break;
        case 'lunch':
            timeInput.value = '12:00';
            break;
        case 'dinner':
            timeInput.value = '18:00';
            break;
        case 'snack':
            // Keep current time for snacks
            timeInput.value = currentTime.toTimeString().slice(0, 5);
            break;
    }
});

// Interactive star rating
document.querySelectorAll('input[name="satisfaction_rating"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const rating = parseInt(this.value);
        const stars = document.querySelectorAll('.flex svg');
        
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    });
});
</script>
@endsection