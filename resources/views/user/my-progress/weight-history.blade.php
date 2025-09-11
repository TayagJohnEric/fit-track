@extends('layout.user')

@section('title', 'My Progress')

@section('content')

<style>
    .modal-overlay {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    transform: scale(0.7) translateY(-50px);
    opacity: 0;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
}

.modal-overlay.show .modal-content {
    transform: scale(1) translateY(0);
    opacity: 1;
}

.modal-overlay.closing {
    opacity: 0;
    visibility: hidden;
}

.modal-overlay.closing .modal-content {
    transform: scale(0.7) translateY(-50px);
    opacity: 0;
}

</style>



    <div class="max-w-[90rem] mx-auto">
       
      <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('progress.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200">
                   Progress
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-orange-600">Weight History</span>
                </div>
            </li>
        </ol>
    </nav>     

        <div class=" p-6">
            <h2 class="text-2xl font-bold text-gray-800 "> Progress</h2>
            <p class="text-gray-600 mb-6">Track your weight, BMI, and progress insights</p>


            <!-- Insights Section -->
            @if($insights)
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Progress Insights</h3>
                    <div class="space-y-3">
                        @foreach($insights as $insight)
                            <div class="flex items-start space-x-3 p-3 rounded-lg 
                                {{ $insight['type'] === 'success' ? 'bg-green-50 border-l-4 border-green-400' : 
                                   ($insight['type'] === 'warning' ? 'bg-yellow-50 border-l-4 border-yellow-400' : 'bg-blue-50 border-l-4 border-blue-400') }}">
                                <div class="flex-shrink-0">
                                    @if($insight['type'] === 'success')
                                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @elseif($insight['type'] === 'warning')
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-sm {{ $insight['type'] === 'success' ? 'text-green-700' : 
                                      ($insight['type'] === 'warning' ? 'text-yellow-700' : 'text-blue-700') }}">
                                    {{ $insight['message'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Weight History Table -->
            @if($weightHistory->isNotEmpty())
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Weight Entries</h3>
                        <p class="text-sm text-gray-600">{{ $weightHistory->count() }} entries found</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight (kg)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BMI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($weightHistory->reverse() as $index => $entry)
                                    @php
                                        $bmi = 0;
                                        if ($userProfile && $userProfile->height_cm > 0) {
                                            $heightM = $userProfile->height_cm / 100;
                                            $bmi = $entry->weight_kg / ($heightM * $heightM);
                                        }
                                        
                                        $previousEntry = $weightHistory->reverse()->get($index + 1);
                                        $weightChange = $previousEntry ? $entry->weight_kg - $previousEntry->weight_kg : 0;
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->log_date->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ number_format($entry->weight_kg, 1) }} kg
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $bmi > 0 ? number_format($bmi, 1) : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($weightChange != 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $weightChange > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $weightChange > 0 ? '+' : '' }}{{ number_format($weightChange, 1) }} kg
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <!-- Edit Icon -->
                                                <button type="button" onclick="openEditModal({{ $entry->id }})"
                                                    class="text-gray-600 hover:text-blue-700 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                                                </button>

                                                <!-- Delete Icon -->
                                                <button onclick="deleteWeightEntry({{ $entry->id }})"
                                                    class="text-gray-600 hover:text-red-700 transition-colors">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No weight entries found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by logging your first weight entry.</p>
                        <div class="mt-6">
                            <button type="button"
                        onclick="openCreateModal()"
                        class="inline-flex items-center px-4 py-2 bg-orange-500 border border-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 hover:border-orage-600 transition-all duration-200 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                            class="text-white w-4 h-4 mr-2 lucide lucide-plus">
                            <path d="M5 12h14"/>
                            <path d="M12 5v14"/>
                        </svg>
                        Log New Weight
                    </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

         @include('user.my-progress.create-modal')

        <!-- Render edit modals after the table to avoid invalid HTML nesting inside <tr> -->
        @if($weightHistory->isNotEmpty())
            @foreach($weightHistory->reverse() as $entry)
                @include('user.my-progress.edit-modal')
            @endforeach
        @endif
    </div>


    <script>

   // Create Modal
            function openCreateModal() {
                const modal = document.getElementById('create-modal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => modal.classList.add('show'), 10);
            }

            function closeCreateModal() {
                const modal = document.getElementById('create-modal');
                modal.classList.add('closing');
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex', 'closing');
                }, 300);
            }

            // Edit Modal (requires an ID), same approach in Delete and Show 
                function openEditModal(id) {
                    const modal = document.getElementById(`edit-modal-${id}`);
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    setTimeout(() => modal.classList.add('show'), 10);
                }

                function closeEditModal(id) {
                    const modal = document.getElementById(`edit-modal-${id}`);
                    modal.classList.add('closing');
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex', 'closing');
                    }, 300);
                }

    </script>
@endsection
