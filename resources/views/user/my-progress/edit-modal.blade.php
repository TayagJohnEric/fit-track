<!-- Edit Weight Modal -->
<div id="edit-modal-{{ $entry->id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="modal-content bg-white rounded-lg p-6 max-w-md w-full relative">
        <!-- Close Button -->
        <button onclick="closeEditModal({{ $entry->id }})" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            ✕
        </button>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Weight Entry</h2>
        <p class="text-gray-600 mb-6">Update your weight entry for {{ $entry->log_date->format('F j, Y') }}</p>

        <!-- Weight Edit Form -->
        <form id="weightEditForm-{{ $entry->id }}">
            @csrf
            @method('PUT')

            <!-- Log Date Field -->
            <div class="mb-6">
                <label for="log_date-{{ $entry->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                    Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="log_date-{{ $entry->id }}" 
                       name="log_date" 
                       value="{{ $entry->log_date->format('Y-m-d') }}"
                       max="{{ date('Y-m-d') }}"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Weight Field -->
            <div class="mb-6">
                <label for="weight_kg-{{ $entry->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                    Weight (kg) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="weight_kg-{{ $entry->id }}" 
                       name="weight_kg" 
                       step="0.1" 
                       min="20" 
                       max="500" 
                       value="{{ $entry->weight_kg }}"
                       placeholder="Enter your weight"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- BMI Preview -->
            <div id="bmiPreview-{{ $entry->id }}" class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">BMI Preview</h4>
                <div class="flex items-center space-x-4">
                    <div>
                        <span class="text-lg font-semibold text-gray-800" id="bmiValue-{{ $entry->id }}">-</span>
                        <span class="text-sm text-gray-600 ml-1">BMI</span>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" id="bmiCategory-{{ $entry->id }}">
                            -
                        </span>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            <div id="errorMessages-{{$entry->id }}" class="mb-4 hidden">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 text-sm text-red-700">
                    <ul id="errorList-{{ $entry->id }}" class="list-disc pl-5 space-y-1"></ul>
                </div>
            </div>

            <!-- Success Message -->
            <div id="successMessage-{{ $entry->id }}" class="mb-4 hidden">
                <div class="bg-green-50 border-l-4 border-green-400 p-4 text-sm text-green-800">
                    <p id="successText-{{ $entry->id }}"></p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between">
                <button type="button" onclick="closeEditModal({{ $entry->id }})" class="text-gray-600 hover:text-gray-800 font-medium">
                    Cancel
                </button>
                <div class="flex space-x-3">
                    <button type="button" 
                            onclick="deleteEntry({{ $entry->id }})"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Delete Entry
                    </button>
                    <button type="submit" 
                            id="submitButton-{{ $entry->id }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <span class="submit-text">Update Weight</span>
                        <span class="submit-loading hidden">Updating...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    window.userProfile = window.userProfile || @json(auth()->user()->userProfile);

    (function () {
        const id = {{ $entry->id }};

        function init() {
            const weightInput = document.getElementById(`weight_kg-${id}`);
            const bmiValue = document.getElementById(`bmiValue-${id}`);
            const bmiCategory = document.getElementById(`bmiCategory-${id}`);

            function updateBMIPreview() {
                const weight = parseFloat(weightInput.value);
                if (weight && userProfile && userProfile.height_cm) {
                    const heightM = userProfile.height_cm / 100;
                    const bmi = weight / (heightM * heightM);
                    const category = getBMICategory(bmi);
                    bmiValue.textContent = bmi.toFixed(1);
                    bmiCategory.textContent = category.text;
                    bmiCategory.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${category.class}`;
                } else {
                    bmiValue.textContent = '-';
                    bmiCategory.textContent = '-';
                    bmiCategory.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                }
            }

            function getBMICategory(bmi) {
                if (bmi < 18.5) return { text: 'Underweight', class: 'bg-blue-100 text-blue-800' };
                if (bmi < 25) return { text: 'Normal Weight', class: 'bg-green-100 text-green-800' };
                if (bmi < 30) return { text: 'Overweight', class: 'bg-yellow-100 text-yellow-800' };
                return { text: 'Obese', class: 'bg-red-100 text-red-800' };
            }

            if (weightInput) {
                weightInput.addEventListener('input', updateBMIPreview);
                weightInput.addEventListener('change', updateBMIPreview);
                updateBMIPreview();
            }

            // Form submission
            const form = document.getElementById(`weightEditForm-${id}`);
            if (!form) return;
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitButton = document.getElementById(`submitButton-${id}`);
                const submitText = submitButton.querySelector('.submit-text');
                const submitLoading = submitButton.querySelector('.submit-loading');
                const errorMessages = document.getElementById(`errorMessages-${id}`);
                const successMessage = document.getElementById(`successMessage-${id}`);

                errorMessages.classList.add('hidden');
                successMessage.classList.add('hidden');

                submitButton.disabled = true;
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');

                const formData = new FormData(this);
                // Ensure method spoofing is sent
                formData.set('_method', 'PUT');

                const updateUrl = '{{ route('progress.update', ['id' => '__ID__']) }}'.replace('__ID__', id);
                fetch(updateUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`successText-${id}`).textContent = data.message;
                        successMessage.classList.remove('hidden');
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        const errorList = document.getElementById(`errorList-${id}`);
                        errorList.innerHTML = '';
                        if (data.errors) {
                            Object.values(data.errors).forEach(errorArray => {
                                errorArray.forEach(error => {
                                    const li = document.createElement('li');
                                    li.textContent = error;
                                    errorList.appendChild(li);
                                });
                            });
                        } else if (data.message) {
                            errorList.innerHTML = `<li>${data.message}</li>`;
                        }
                        errorMessages.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorList = document.getElementById(`errorList-${id}`);
                    errorList.innerHTML = '<li>An unexpected error occurred. Please try again.</li>';
                    errorMessages.classList.remove('hidden');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitText.classList.remove('hidden');
                    submitLoading.classList.add('hidden');
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();

    // Delete entry (define once)
    if (!window.deleteEntry) {
    window.deleteEntry = function(id) {
        if (!confirm('Are you sure you want to delete this weight entry? This action cannot be undone.')) return;

        const deleteUrl = '{{ route('progress.destroy', ['id' => '__ID__']) }}'.replace('__ID__', id);
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                const errorList = document.getElementById(`errorList-${id}`);
                errorList.innerHTML = `<li>${data.message || 'Failed to delete entry'}</li>`;
                document.getElementById(`errorMessages-${id}`).classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorList = document.getElementById(`errorList-${id}`);
            errorList.innerHTML = '<li>An unexpected error occurred while deleting. Please try again.</li>';
            document.getElementById(`errorMessages-${id}`).classList.remove('hidden');
        });
    }
    }
</script>
