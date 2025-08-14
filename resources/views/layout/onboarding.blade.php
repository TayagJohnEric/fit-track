<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Onboarding') - FitnessApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Import Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

   <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white min-h-screen">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Sidebar Navigation -->
        <aside class="w-full lg:w-80 bg-white shadow-md border-r border-gray-100 flex flex-col lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto">
            <!-- Logo Section -->
            <header class="p-6 lg:p-8 border-b border-gray-100">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12  bg-orange-500 rounded-xl flex items-center justify-center shadow-lg hover:scale-105 transition-transform duration-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">
                            <span class="text-orange-600">Fit-</span><span class="text-gray-800">Trrack</span>
                        </h1>
                        <p class="text-xs text-gray-500 font-medium">Your Personal Trainer</p>
                    </div>
                </div>
                <div class="">
                    <h2 class="text-lg lg:text-xl font-semibold text-gray-900">@yield('page_title', 'Setup Account')</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">@yield('subtitle', 'Let\'s get you started on your fitness journey')</p>
                </div>
            </header>

            <!-- Steps Navigation -->
            <nav class="flex-1 px-6 lg:px-8 py-6" aria-label="Onboarding progress">
                <div class="space-y-2">
                    <!-- Welcome/Personal Details -->
                    <div class="flex items-center space-x-4 py-3 px-3 rounded-lg transition-all duration-200 hover:bg-orange-50 group">
                        <div class="flex-shrink-0">
                            @if(request()->routeIs('onboarding.welcome') || request()->routeIs('onboarding.step*') || request()->routeIs('onboarding.complete'))
                                <div class="w-10 h-10 rounded-full  bg-orange-500 flex items-center justify-center shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center shadow-sm group-hover:border-orange-200 transition-colors">
                                    <span class="text-sm font-semibold text-gray-400 group-hover:text-orange-400 transition-colors">1</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold {{ request()->routeIs('onboarding.welcome') || request()->routeIs('onboarding.step1') || request()->routeIs('onboarding.complete') ? 'text-orange-600' : 'text-gray-600' }} group-hover:text-orange-700 transition-colors">
                                Personal Details
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5 hidden sm:block">Basic information about you</div>
                        </div>
                    </div>

                    <!-- Progress Line -->
                    <div class="flex justify-start ml-8">
                        <div class="w-0.5 h-6 {{ request()->routeIs('onboarding.step2') || request()->routeIs('onboarding.step3') || request()->routeIs('onboarding.complete') ? 'bg-gradient-to-b from-orange-300 to-gray-200' : 'bg-gray-200' }} rounded-full transition-colors duration-300"></div>
                    </div>

                    <!-- Fitness Preferences -->
                    <div class="flex items-center space-x-4 py-3 px-3 rounded-lg transition-all duration-200 hover:bg-orange-50 group">
                        <div class="flex-shrink-0">
                            @if(request()->routeIs('onboarding.step2') || request()->routeIs('onboarding.step3') || request()->routeIs('onboarding.complete'))
                                <div class="w-10 h-10 rounded-full  bg-orange-500 flex items-center justify-center shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center shadow-sm group-hover:border-orange-200 transition-colors">
                                    <span class="text-sm font-semibold text-gray-400 group-hover:text-orange-400 transition-colors">2</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold {{ request()->routeIs('onboarding.step2') || request()->routeIs('onboarding.complete') ? 'text-orange-600' : 'text-gray-600' }} group-hover:text-orange-700 transition-colors">
                                Fitness Preferences
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5 hidden sm:block">Your workout goals & preferences</div>
                        </div>
                    </div>

                    <!-- Progress Line -->
                    <div class="flex justify-start ml-8">
                        <div class="w-0.5 h-6 {{ request()->routeIs('onboarding.step3') || request()->routeIs('onboarding.complete') ? 'bg-gradient-to-b from-orange-300 to-gray-200' : 'bg-gray-200' }} rounded-full transition-colors duration-300"></div>
                    </div>

                    <!-- Final Details -->
                    <div class="flex items-center space-x-4 py-3 px-3 rounded-lg transition-all duration-200 hover:bg-orange-50 group">
                        <div class="flex-shrink-0">
                            @if(request()->routeIs('onboarding.step3') || request()->routeIs('onboarding.complete'))
                                <div class="w-10 h-10 rounded-full  bg-orange-500 flex items-center justify-center shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center shadow-sm group-hover:border-orange-200 transition-colors">
                                    <span class="text-sm font-semibold text-gray-400 group-hover:text-orange-400 transition-colors">3</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold {{ request()->routeIs('onboarding.step3') || request()->routeIs('onboarding.complete') ? 'text-orange-600' : 'text-gray-600' }} group-hover:text-orange-700 transition-colors">
                                Final Details
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5 hidden sm:block">Complete your profile setup</div>
                        </div>
                    </div>

                    <!-- Progress Line -->
                    <div class="flex justify-start ml-8">
                        <div class="w-0.5 h-6 {{ request()->routeIs('onboarding.complete') ? 'bg-gradient-to-b from-orange-300 to-gray-200' : 'bg-gray-200' }} rounded-full transition-colors duration-300"></div>
                    </div>

                    <!-- Complete -->
                    <div class="flex items-center space-x-4 py-3 px-3 rounded-lg transition-all duration-200 hover:bg-orange-50 group">
                        <div class="flex-shrink-0">
                            @if(request()->routeIs('onboarding.complete'))
                                <div class="w-10 h-10 rounded-full  bg-orange-500 flex items-center justify-center shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-gray-200 bg-white flex items-center justify-center shadow-sm group-hover:border-orange-200 transition-colors">
                                    <span class="text-sm font-semibold text-gray-400 group-hover:text-orange-400 transition-colors">4</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold {{ request()->routeIs('onboarding.complete') ? 'text-green-600' : 'text-gray-600' }} group-hover:text-orange-700 transition-colors">
                                Complete
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5 hidden sm:block">Ready to start your journey!</div>
                        </div>
                    </div>
                </div>
            </nav>
            
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-h-screen lg:min-h-0 lg:h-screen lg:overflow-hidden">
            <!-- Header -->
                <header class="bg-white px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-4">
                        <div class="flex items-center space-x-2 text-sm text-gray-500 px-4 py-2 rounded-full">
                            @if(request()->routeIs('onboarding.step1'))
                                <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium text-gray-500">Step 1 of 3</span>
                            @elseif(request()->routeIs('onboarding.step2'))
                                <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium text-gray-500">Step 2 of 3</span>
                            @elseif(request()->routeIs('onboarding.step3'))
                                <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium text-gray-500">Step 3 of 3</span>
                            @elseif(request()->routeIs('onboarding.complete'))
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium text-gray-500">Completed!</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-orange-600 lucide lucide-mouse-pointer-click-icon lucide-mouse-pointer-click"><path d="M14 4.1 12 6"/><path d="m5.1 8-2.9-.8"/><path d="m6 12-1.9 2"/><path d="M7.2 2.2 8 5.1"/><path d="M9.037 9.69a.498.498 0 0 1 .653-.653l11 4.5a.5.5 0 0 1-.074.949l-4.349 1.041a1 1 0 0 0-.74.739l-1.04 4.35a.5.5 0 0 1-.95.074z"/></svg>
                                <span class="font-medium text-gray-500">Getting Started</span>
                            @endif
                        </div>
                    </div>
                </header>

            <!-- Form Content -->
            <div class="flex-1 px-6 lg:px-8 py-8 overflow-y-auto">
                <div class="max-w-4xl mx-auto">
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm animate-fade-in">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="animate-fade-in">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>