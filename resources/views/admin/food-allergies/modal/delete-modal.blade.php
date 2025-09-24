<!-- Delete Confirmation Modal Wrapper -->
<div id="delete-modal-{{ $item->id }}" class="modal-overlay fixed inset-0 hidden items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <button onclick="closeDeleteModal({{ $item->id }})" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.764 0L3.049 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Remove All Allergies</h2>
        </div>
        
        <div class="mb-4">
            <p class="mb-2 text-gray-700">Are you sure you want to remove all allergies from:</p>
            <div class="bg-gray-50 rounded-lg p-3 border">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center mr-3">
                        @if($item->image_url)
                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" class="h-full w-full object-cover rounded-lg">
                        @else
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m8.5-5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm">{{ $item->name }}</div>
                        <div class="text-xs text-gray-600">{{ $item->serving_size_description }}</div>
                    </div>
                </div>
            </div>
            
            @if($item->allergies->count() > 0)
                <div class="mt-3">
                    <p class="text-sm text-gray-600 mb-2">Current allergies that will be removed:</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach($item->allergies as $allergy)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $allergy->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        <p class="mb-6 text-gray-600 text-sm">This action cannot be undone.</p>

        <form action="{{ route('admin.food_item_allergies.destroy', $item->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeDeleteModal({{ $item->id }})" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Remove All Allergies</button>
            </div>
        </form>
    </div>
</div>