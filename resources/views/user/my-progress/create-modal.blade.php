<!-- Log Weight Modal -->
<div id="create-modal" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="modal-content bg-white rounded-lg p-6 max-w-md w-full">
        <!-- Modal Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Log New Weight</h2>
                <p class="text-gray-600">Track your weight progress by logging your current weight</p>
            </div>
            <button onclick="document.getElementById('create-modal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800 font-medium">
                ✕
            </button>
        </div>

        <!-- Weight Logging Form -->
        <form id="weightForm" class="max-w-md">
            @csrf
            
            <!-- Log Date Field -->
            <div class="mb-6">
                <label for="log_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="log_date" 
                       name="log_date" 
                       value="{{ date('Y-m-d') }}"
                       max="{{ date('Y-m-d') }}"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Select the date for this weight entry</p>
            </div>
            
            <!-- Weight Field -->
            <div class="mb-6">
                <label for="weight_kg" class="block text-sm font-medium text-gray-700 mb-2">
                    Weight (kg) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="weight_kg" 
                       name="weight_kg" 
                       step="0.1" 
                       min="20" 
                       max="500" 
                       placeholder="Enter your weight"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Enter your weight in kilograms (20-500 kg)</p>
            </div>
            
            <!-- BMI Preview -->
            <div id="bmiPreview" class="mb-6 p-4 bg-gray-50 rounded-lg hidden">
                <h4 class="text-sm font-medium text-gray-700 mb-2">BMI Preview</h4>
                <div class="flex items-center space-x-4">
                    <div>
                        <span class="text-lg font-semibold text-gray-800" id="bmiValue">-</span>
                        <span class="text-sm text-gray-600 ml-1">BMI</span>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" id="bmiCategory">
                            -
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Error Messages -->
            <div id="errorMessages" class="mb-4 hidden">
                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul id="errorList" class="list-disc pl-5 space-y-1"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Success Message -->
            <div id="successMessage" class="mb-4 hidden">
                <div class="bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800" id="successText"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-between">
                <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800 font-medium">
                    Cancel
                </button>
                <button type="submit" 
                        id="submitButton"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <span class="submit-text">Log Weight</span>
                    <span class="submit-loading hidden">Logging...</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const userProfile = @json(auth()->user()->userProfile);
    
    document.addEventListener('DOMContentLoaded', function() {
        const weightInput = document.getElementById('weight_kg');
        const bmiPreview = document.getElementById('bmiPreview');
        const bmiValue = document.getElementById('bmiValue');
        const bmiCategory = document.getElementById('bmiCategory');

        function updateBMIPreview() {
            const weight = parseFloat(weightInput.value);
            if (weight && userProfile && userProfile.height_cm) {
                const heightM = userProfile.height_cm / 100;
                const bmi = weight / (heightM * heightM);
                const category = getBMICategory(bmi);
                
                bmiValue.textContent = bmi.toFixed(1);
                bmiCategory.textContent = category.text;
                bmiCategory.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${category.class}`;
                
                bmiPreview.classList.remove('hidden');
            } else {
                bmiPreview.classList.add('hidden');
            }
        }

        function getBMICategory(bmi) {
            if (bmi < 18.5) {
                return { text: 'Underweight', class: 'bg-blue-100 text-blue-800' };
            } else if (bmi >= 18.5 && bmi < 25) {
                return { text: 'Normal Weight', class: 'bg-green-100 text-green-800' };
            } else if (bmi >= 25 && bmi < 30) {
                return { text: 'Overweight', class: 'bg-yellow-100 text-yellow-800' };
            } else {
                return { text: 'Obese', class: 'bg-red-100 text-red-800' };
            }
        }

        weightInput.addEventListener('input', updateBMIPreview);
        weightInput.addEventListener('change', updateBMIPreview);

        document.getElementById('weightForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitButton = document.getElementById('submitButton');
            const submitText = submitButton.querySelector('.submit-text');
            const submitLoading = submitButton.querySelector('.submit-loading');
            const errorMessages = document.getElementById('errorMessages');
            const successMessage = document.getElementById('successMessage');

            errorMessages.classList.add('hidden');
            successMessage.classList.add('hidden');

            submitButton.disabled = true;
            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');

            const formData = new FormData(this);

            fetch('{{ route("progress.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successText').textContent = data.message;
                    successMessage.classList.remove('hidden');
                    
                    setTimeout(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    }, 1500);
                } else {
                    const errorList = document.getElementById('errorList');
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
                const errorList = document.getElementById('errorList');
                errorList.innerHTML = '<li>An unexpected error occurred. Please try again.</li>';
                errorMessages.classList.remove('hidden');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitText.classList.remove('hidden');
                submitLoading.classList.add('hidden');
            });
        });

        if (weightInput.value) {
            updateBMIPreview();
        }
    });
</script>
