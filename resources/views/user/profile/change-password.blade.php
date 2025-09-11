@extends('layout.user')

@section('title', 'Change Password')

@section('content')
<div class="max-w-[90rem] mx-auto">
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Please fix the following errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class=" p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Change Password</h2>
                <p class="text-gray-600 text-sm ">Update your account password for security</p>
            </div>

                       <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200">
                   Profile
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-orange-600">Change Password</span>
                </div>
            </li>
        </ol>
    </nav>     


        </div>

        <div class="max-w-md mx-auto">
            <form method="POST" action="{{ route('profile.update-password') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Security Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800">Security Notice</h3>
                            <p class="text-sm text-yellow-700 mt-1">
                                Make sure your new password is strong and unique. Use a combination of letters, numbers, and special characters.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                        Current Password
                    </label>
                    <input type="password" 
                           name="current_password" 
                           id="current_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror"
                           required
                           autocomplete="current-password">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                        New Password
                    </label>
                    <input type="password" 
                           name="new_password" 
                           id="new_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('new_password') border-red-500 @enderror"
                           required
                           autocomplete="new-password">
                    @error('new_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Password must be at least 8 characters long
                    </p>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm New Password
                    </label>
                    <input type="password" 
                           name="new_password_confirmation" 
                           id="new_password_confirmation" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required
                           autocomplete="new-password">
                </div>

                <!-- Password Strength Indicator -->
                <div class="space-y-2">
                    <div class="text-sm font-medium text-gray-700">Password Requirements:</div>
                    <div class="space-y-1">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-600">At least 8 characters</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-600">Mix of letters, numbers, and symbols (recommended)</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-gray-200">
                  

                    <a href="{{ route('profile.show') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                Cancel
            </a>

                    <button type="button"
                        class="inline-flex items-center px-4 py-2 bg-orange-500 border border-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 hover:border-orage-600 transition-all duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Simple password strength indicator
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('new_password_confirmation');
    
    function updatePasswordStrength() {
        const password = newPasswordInput.value;
        const requirements = document.querySelectorAll('.password-requirement');
        
        // Check length
        const lengthRequirement = requirements[0];
        if (password.length >= 8) {
            lengthRequirement.classList.add('text-green-600');
            lengthRequirement.classList.remove('text-gray-600');
            lengthRequirement.querySelector('svg').classList.add('text-green-600');
            lengthRequirement.querySelector('svg').classList.remove('text-gray-400');
        } else {
            lengthRequirement.classList.add('text-gray-600');
            lengthRequirement.classList.remove('text-green-600');
            lengthRequirement.querySelector('svg').classList.add('text-gray-400');
            lengthRequirement.querySelector('svg').classList.remove('text-green-600');
        }
    }
    
    function checkPasswordMatch() {
        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (confirmPassword && password !== confirmPassword) {
            confirmPasswordInput.classList.add('border-red-500');
            confirmPasswordInput.classList.remove('border-gray-300');
        } else {
            confirmPasswordInput.classList.remove('border-red-500');
            confirmPasswordInput.classList.add('border-gray-300');
        }
    }
    
    newPasswordInput.addEventListener('input', updatePasswordStrength);
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
});
</script>
@endsection