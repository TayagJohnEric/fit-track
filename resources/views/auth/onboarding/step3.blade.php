@extends('layout.onboarding')

@section('title', 'Step 3 - Final Details')
@section('subtitle', 'Almost done! Just a few more details')

@section('content')
<div class="space-y-6">
    <!-- Step Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900">Final Details</h2>
        <p class="text-sm text-gray-600 mt-1">Add any last preferences so we can fine-tune your plan for you.</p>
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
                    <div class="w-full px-3 py-2 text-sm text-center text-gray-700 bg-white border border-gray-300 rounded-lg peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 hover:bg-gray-50 peer-checked:hover:bg-primary-500 transition-colors">
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
                       class="w-full pl-8 pr-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('daily_budget') border-red-300 @enderror"
                       placeholder="e.g., 500.00">
            </div>
            @error('daily_budget')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Summary Card -->
        <div class="bg-gray-50  rounded-lg  p-5 mt-6 ">
            <h3 class="font-semibold text-gray-800 text-lg mb-4">Setup Summary</h3>
            <div class="space-y-2">
                <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Personal information completed
                </div>
                <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Fitness preferences set
                </div>
                <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Ready to create your personalized plan
                </div>
            </div>
        </div>



        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <a href="{{ route('onboarding.step2') }}" 
            class="flex items-center text-sm gap-2 px-4 py-2 border border-gray-300 bg-gray-100 rounded-lg text-gray-600 hover:bg-gray-900 hover:text-white font-bold transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"/>
                    <path d="M19 12H5"/>
                </svg>
                Previous
            </a>

            <button type="submit" 
                    class="flex items-center text-sm gap-2 px-6 py-2 bg-primary-600 hover:bg-primary-500 text-white font-bold rounded-lg transition duration-200">
                Complete Setup✨
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