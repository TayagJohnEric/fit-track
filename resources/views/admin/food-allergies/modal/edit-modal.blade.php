<div id="edit-modal-{{ $item->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
        <button onclick="closeEditModal({{ $item->id }})" class="absolute top-2 right-2 text-orange-600 hover:text-orange-800">
            &times;
        </button>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Allergies for: {{ $item->name }}</h2>

        <form method="POST" action="{{ route('admin.food_item_allergies.update', $item->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <!-- Current Food Item Info -->
                <div class="bg-gray-50 rounded-lg p-4 border">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center mr-3">
                            @if($item->image_url)
                                <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="h-full w-full object-cover rounded-lg">
                            @else
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m8.5-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $item->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $item->serving_size_description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Allergies Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Allergies</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                        @foreach($allergies as $allergy)
                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-white rounded-lg p-2 transition-colors">
                                <input type="checkbox" 
                                       name="allergy_ids[]" 
                                       value="{{ $allergy->id }}" 
                                       {{ $item->allergies->contains($allergy->id) ? 'checked' : '' }}
                                       class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                <span class="text-sm text-gray-700">{{ $allergy->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('allergy_ids') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    @error('allergy_ids.*') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Current Allergies Info -->
                @if($item->allergies->count() > 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-red-800 mb-2">Currently Associated Allergies:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($item->allergies as $currentAllergy)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $currentAllergy->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    Update Allergies
                </button>
            </div>
        </form>
    </div>
</div>