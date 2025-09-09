<!-- Weight Log Modal Component -->
<div id="weightModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                    Log Weight
                </h3>
                <button onclick="closeWeightModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('progress.log-weight') }}" id="weightForm">
                @csrf
                <input type="hidden" name="date_range" value="{{ request('date_range', $dateRange ?? '30') }}">
                <div class="mb-4">
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" step="0.1" min="20" max="500" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your weight">
                    <div class="text-sm text-gray-500 mt-1">Enter weight between 20-500 kg</div>
                </div>
                
                <div class="mb-6">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="text-sm text-gray-500 mt-1">Cannot select future dates</div>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeWeightModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 rounded-md transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Log Weight
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functions
function openWeightModal() {
    document.getElementById('weightModal').classList.remove('hidden');
    document.getElementById('weight').focus();
}

function closeWeightModal() {
    document.getElementById('weightModal').classList.add('hidden');
    document.getElementById('weightForm').reset();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('weightModal');
    if (event.target == modal) {
        closeWeightModal();
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeWeightModal();
    }
});
</script>