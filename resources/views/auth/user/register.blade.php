<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'brand-orange': '#f97316',
                        'brand-orange-dark': '#ea580c',
                        'brand-orange-light': '#fed7aa',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md mx-auto">
        <div class="p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                  <!--Logo here-->
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Let's create your account today!</h2>
                <p class="text-gray-600 text-sm">Join Fit-Track to start your fitness journey today.</p>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg hidden">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-700 text-sm font-medium" id="error-text">Error message here</span>
                </div>
            </div>

            <!-- Success Message -->
            <div id="success-message" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg hidden">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-700 text-sm font-medium" id="success-text">Success message here</span>
                </div>
            </div>

            <!-- Register Form -->
            <form id="registerForm" class="space-y-6">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            required
                            autocomplete="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-brand-orange transition-colors duration-200 bg-gray-50 focus:bg-white"
                            placeholder="Enter your full name"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="name-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            required
                            autocomplete="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-brand-orange transition-colors duration-200 bg-gray-50 focus:bg-white"
                            placeholder="Enter your email"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="email-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-brand-orange transition-colors duration-200 bg-gray-50 focus:bg-white"
                            placeholder="Create a password"
                        >
                        <button 
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-auto focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 rounded"
                            onclick="togglePasswordVisibility('password', 'eyeIcon', 'eyeSlashIcon')"
                        >
                            <!-- Eye Icon (hidden) -->
                            <svg id="eyeIcon" class="h-5 w-5 text-gray-400 hover:text-brand-orange transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                            <!-- Eye Slash Icon (visible) -->
                            <svg id="eyeSlashIcon" class="h-5 w-5 text-gray-400 hover:text-brand-orange transition-colors duration-200 hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="password-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    <div class="mt-1 text-xs text-gray-500">
                        Password must be at least 6 characters long
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-brand-orange transition-colors duration-200 bg-gray-50 focus:bg-white"
                            placeholder="Confirm your password"
                        >
                        <button 
                            type="button"
                            id="togglePasswordConfirmation"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-auto focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 rounded"
                            onclick="togglePasswordVisibility('password_confirmation', 'eyeIconConfirm', 'eyeSlashIconConfirm')"
                        >
                            <!-- Eye Icon (hidden) -->
                            <svg id="eyeIconConfirm" class="h-5 w-5 text-gray-400 hover:text-brand-orange transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                            <!-- Eye Slash Icon (visible) -->
                            <svg id="eyeSlashIconConfirm" class="h-5 w-5 text-gray-400 hover:text-brand-orange transition-colors duration-200 hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="password_confirmation-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button 
                        type="submit"
                        id="registerButton"
                        class="w-full bg-brand-orange hover:bg-brand-orange-dark text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:bg-brand-orange"
                    >
                        <span id="buttonText">Create Account</span>
                        <svg id="loadingSpinner" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login.form') }}" 
                       class="font-medium text-brand-orange hover:text-brand-orange-dark transition-colors duration-200 hover:underline focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 rounded px-1">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-6">
            <p class="text-xs text-gray-500">
                By creating an account, you agree to our terms of service
            </p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, eyeIconId, eyeSlashIconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);
            const eyeSlashIcon = document.getElementById(eyeSlashIconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }

        function showMessage(type, message) {
            const errorDiv = document.getElementById('error-message');
            const successDiv = document.getElementById('success-message');
            
            // Hide both messages first
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            
            if (type === 'error') {
                document.getElementById('error-text').textContent = message;
                errorDiv.classList.remove('hidden');
            } else if (type === 'success') {
                document.getElementById('success-text').textContent = message;
                successDiv.classList.remove('hidden');
            }
        }

        function clearFieldErrors() {
            const fields = ['name', 'email', 'password', 'password_confirmation'];
            
            fields.forEach(field => {
                const errorDiv = document.getElementById(field + '-error');
                const input = document.getElementById(field);
                
                errorDiv.classList.add('hidden');
                input.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                input.classList.add('border-gray-300', 'focus:ring-brand-orange', 'focus:border-brand-orange');
            });
        }

        function showFieldError(field, message) {
            const errorDiv = document.getElementById(field + '-error');
            const input = document.getElementById(field);
            
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            
            // Add error styles to input
            input.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            input.classList.remove('border-gray-300', 'focus:ring-brand-orange', 'focus:border-brand-orange');
        }

        function setLoadingState(loading) {
            const button = document.getElementById('registerButton');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('loadingSpinner');
            const form = document.getElementById('registerForm');
            
            if (loading) {
                button.disabled = true;
                buttonText.textContent = 'Creating Account...';
                spinner.classList.remove('hidden');
                form.classList.add('pointer-events-none');
            } else {
                button.disabled = false;
                buttonText.textContent = 'Create Account';
                spinner.classList.add('hidden');
                form.classList.remove('pointer-events-none');
            }
        }

        function validatePasswords() {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            // Clear previous confirmation error
            const confirmErrorDiv = document.getElementById('password_confirmation-error');
            const confirmInput = document.getElementById('password_confirmation');
            
            if (passwordConfirmation && password !== passwordConfirmation) {
                showFieldError('password_confirmation', 'Passwords do not match');
                return false;
            } else if (confirmErrorDiv.textContent === 'Passwords do not match') {
                confirmErrorDiv.classList.add('hidden');
                confirmInput.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                confirmInput.classList.add('border-gray-300', 'focus:ring-brand-orange', 'focus:border-brand-orange');
            }
            
            return true;
        }

        // Real-time password confirmation validation
        document.getElementById('password').addEventListener('input', validatePasswords);
        document.getElementById('password_confirmation').addEventListener('input', validatePasswords);

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearFieldErrors();
            showMessage('', '');
            
            // Client-side password validation
            if (!validatePasswords()) {
                return;
            }
            
            // Set loading state
            setLoadingState(true);
            
            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('{{ route("register") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                setLoadingState(false);
                
                if (data.success) {
                    showMessage('success', data.message || 'Account created successfully! Redirecting...');
                    
                    // Clear form
                    document.getElementById('registerForm').reset();
                    
                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 1500);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        for (const [field, messages] of Object.entries(data.errors)) {
                            if (['name', 'email', 'password', 'password_confirmation'].includes(field)) {
                                showFieldError(field, messages[0]);
                            } else {
                                showMessage('error', messages[0]);
                            }
                        }
                    } else if (data.message) {
                        showMessage('error', data.message);
                    } else {
                        showMessage('error', 'An unexpected error occurred. Please try again.');
                    }
                }
            })
            .catch(error => {
                setLoadingState(false);
                console.error('Registration error:', error);
                showMessage('error', 'Network error. Please check your connection and try again.');
            });
        });

        // Clear field errors when user starts typing
        const fields = ['name', 'email', 'password', 'password_confirmation'];
        fields.forEach(fieldName => {
            document.getElementById(fieldName).addEventListener('input', function() {
                if (!this.classList.contains('border-red-500')) return;
                
                this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                this.classList.add('border-gray-300', 'focus:ring-brand-orange', 'focus:border-brand-orange');
                document.getElementById(fieldName + '-error').classList.add('hidden');
            });
        });
    </script>

</body>
</html>