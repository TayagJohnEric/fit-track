<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Onboarding') - FitnessApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <span class="text-primary-600">Fitness</span>App
                </h1>
                <p class="mt-2 text-sm text-gray-600">@yield('subtitle', 'Let\'s get you started')</p>
            </div>

            <!-- Progress Bar -->
            @if(request()->routeIs('onboarding.step*'))
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-primary-600 h-2 rounded-full transition-all duration-300" 
                     style="width: {{ request()->routeIs('onboarding.step1') ? '33%' : (request()->routeIs('onboarding.step2') ? '66%' : '100%') }}">
                </div>
            </div>
            @endif

            <!-- Main Content -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    Your fitness journey starts here
                </p>
            </div>
        </div>
    </div>
</body>
</html>