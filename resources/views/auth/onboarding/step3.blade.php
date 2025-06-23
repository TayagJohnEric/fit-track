@extends('layout.onboarding')

@section('title', 'Step 3 - Final Details')
@section('subtitle', 'Almost done! Just a few more details')

@section('content')
<div class="space-y-6">
    <!-- Step Header -->
    <div class="text-center">
        <h2 class="text-xl font-bold text-gray-900">Final Details</h2>
        <p class="text-sm text-gray-600 mt-1">Step 3 of 3</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('onboarding.store.step3') }}" class="space-y-6">
        @csrf

        <!-- Allergies -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Do you have any food allergies? (Optional)
            </label>
            <p class="text-xs text-gray-500 mb-4">Select all that apply to help us recommend suitable meals</p>
            
            <div class="grid grid-cols-2 gap-2">
                @foreach($allergies as $allergy)
                <label class="relative flex cursor-pointer">
                    <input type="checkbox" name="allergies[]" value="{{ $allergy->id }}" 
                           class="sr-only peer"
                           {{ in_array($allergy->id, old('allergies', [])) ? 'checked' : '' }}>
                    <div class="w-full px-3 py-2 text-sm text-center text-gray-700 bg-white border border-gray-300 rounded-lg peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 hover:bg-gray-50 peer-checked:hover:bg-primary-700 transition-colors">
                        {{ $allergy->name }}
                    </div>
                </label>
                @endforeach
            </div>
            @error('allergies')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Daily Budget -->
        <div>
            <label for="daily_budget" class="block text-sm font-medium text-gray-700 mb-1">
                Daily Food Budget (Optional)
            </label>
            <p class="text-xs text-gray-500 mb-3">Help us suggest meals within your budget</p>
            
            <div class="relative">
                <span class="absolute left-3 top-2 text-gray-500">₱</span>
                <input type="number" id="daily_budget" name="daily_budget" step="0.01" min="0"
                       value="{{ old('daily_budget') }}"
                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('daily_budget') border-red-300 @enderror"
                       placeholder="e.g., 500.00">
            </div>
            @error('daily_budget')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Summary Card -->
        <div class="bg-gray-50 rounded-lg p-4 mt-6">
            <h3 class="font-medium text-gray-900 mb-2">Setup Summary</h3>
            <div class="text-sm text-gray-600 space-y-1">
                <p>✓ Personal information completed</p>
                <p>✓ Fitness preferences set</p>
                <p>✓ Ready to create your personalized plan</p>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <a href="{{ route('onboarding.step2') }}" 
               class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                ← Previous
            </a>

            <button type="submit" 
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-200 flex items-center space-x-2">
                <span>Complete Setup</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
        </div>
    </form>
</div>

<script>
// Auto-format currency input
document.getElementById('daily_budget').addEventListener('input', function(e) {
    let value = e.target.value;
    if (value && !isNaN(value)) {
        // Optional: Add any formatting logic here
    }
});
</script>
@endsection