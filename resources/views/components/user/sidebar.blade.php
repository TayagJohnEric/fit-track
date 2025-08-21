<!-- Mobile Sidebar -->
<div id="sidebar" class="sidebar-transition sidebar-mobile-closed md:sidebar-mobile-open fixed md:static top-0 left-0 z-50 w-64 h-full bg-gray-100 text-orange-900 flex flex-col">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4">
        <!-- Logo - Left aligned -->
     <h1 class="ml-4 font-bold text-lg ">Logo.</h1>        
        <!-- Close button (mobile only) -->
        <button id="sidebar-close" class="md:hidden p-2 rounded-lg text-orange-600 hover:text-red-600 hover:bg-red-100 transition-colors focus:outline-none focus:ring-2 focus:ring-red-300">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    
    <!-- Sidebar Navigation -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-2 px-4">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                    class="group flex items-center font-semibold p-3 rounded-lg hover:bg-orange-100 hover:text-orange-500 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            width="24" height="24" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="2" 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            class="w-5 h-5 text-gray-400 group-hover:text-orange-500 lucide lucide-house">
                            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                            <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        </svg>
                        <span class="ml-3 text-sm font-semibold text-gray-800 group-hover:text-orange-500 tracking-tighter">Home</span>
                    </a>
            </li>

            <!-- Log Meal -->
<li>
    <a href="{{ route('nutrition.index') }}" 
       class="group flex items-center font-semibold p-3 rounded-lg hover:bg-orange-100 hover:text-orange-500 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" 
             width="24" height="24" 
             viewBox="0 0 24 24" 
             fill="none" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round" 
             class="w-5 h-5 text-gray-400 group-hover:text-orange-500 lucide lucide-utensils">
            <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
            <path d="M7 2v20"/>
            <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>
        </svg>
        <span class="ml-3 text-sm font-semibold text-gray-800 group-hover:text-orange-500 tracking-tighter">Log Meal</span>
    </a>
</li>


           <!-- Today's Workout -->
<li>
    <a href="{{ route('workouts.today') }}" 
       class="group flex items-center font-semibold p-3 rounded-lg hover:bg-orange-100 hover:text-orange-500 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" 
             width="24" height="24" 
             viewBox="0 0 24 24" 
             fill="none" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round" 
             class="w-5 h-5 text-gray-400 group-hover:text-orange-500 lucide lucide-dumbbell">
            <path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/>
            <path d="m2.5 21.5 1.4-1.4"/>
            <path d="m20.1 3.9 1.4-1.4"/>
            <path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/>
            <path d="m9.6 14.4 4.8-4.8"/>
        </svg>
        <span class="ml-3 text-sm font-semibold text-gray-800 group-hover:text-orange-500 tracking-tighter">Workout</span>
    </a>
</li>

           <!-- Meal Ideas -->
<li>
    <a href="{{ route('meal-ideas.index') }}" 
       class="group flex items-center font-semibold p-3 rounded-lg hover:bg-orange-100 hover:text-orange-500 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" 
             width="24" height="24" 
             viewBox="0 0 24 24" 
             fill="none" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round" 
             class="w-5 h-5 text-gray-400 group-hover:text-orange-500 lucide lucide-beef">
            <path d="M16.4 13.7A6.5 6.5 0 1 0 6.28 6.6c-1.1 3.13-.78 3.9-3.18 6.08A3 3 0 0 0 5 18c4 0 8.4-1.8 11.4-4.3"/>
            <path d="m18.5 6 2.19 4.5a6.48 6.48 0 0 1-2.29 7.2C15.4 20.2 11 22 7 22a3 3 0 0 1-2.68-1.66L2.4 16.5"/>
            <circle cx="12.5" cy="8.5" r="2.5"/>
        </svg>
        <span class="ml-3 text-sm font-semibold text-gray-800 group-hover:text-orange-500 tracking-tighter">Meal Ideas</span>
    </a>
</li>

<!-- My Progress -->
<li>
    <a href="{{ route('progress.index') }}" 
       class="group flex items-center font-semibold p-3 rounded-lg hover:bg-orange-100 hover:text-orange-500 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" 
             width="24" height="24" 
             viewBox="0 0 24 24" 
             fill="none" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round" 
             class="w-5 h-5 text-gray-400 group-hover:text-orange-500 lucide lucide-chart-no-axes-combined">
            <path d="M12 16v5"/>
            <path d="M16 14v7"/>
            <path d="M20 10v11"/>
            <path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15"/>
            <path d="M4 18v3"/>
            <path d="M8 14v7"/>
        </svg>
        <span class="ml-3 text-sm font-semibold text-gray-800 group-hover:text-orange-500 tracking-tighter">My Progress</span>
    </a>
</li>

<!-- Profile -->
<li>
    <a href="{{ route('profile.show') }}" 
       class="group flex items-center font-semibold p-3 rounded-lg hover:bg-orange-100 hover:text-orange-500 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" 
             width="24" height="24" 
             viewBox="0 0 24 24" 
             fill="none" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round" 
             class="w-5 h-5 text-gray-500 group-hover:text-orange-500 lucide lucide-user-pen">
            <path d="M11.5 15H7a4 4 0 0 0-4 4v2"/>
            <path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/>
            <circle cx="10" cy="7" r="4"/>
        </svg>
        <span class="ml-3 text-sm font-semibold text-gray-800 group-hover:text-orange-500 tracking-tighter">Profile</span>
    </a>
</li>
        </ul>
    </nav>

    <!-- User Profile Section - Moved to bottom -->
    <div class="px-6 py-8 border-t border-gray-200 mt-auto">
        <div class="flex items-center space-x-3">
            <!-- Profile Image/Avatar -->
            @php
                $assignedColor = 'bg-gray-800';     
                $firstInitial = strtoupper(substr(Auth::user()->userProfile->first_name ?? '', 0, 1));
                $lastInitial = strtoupper(substr(Auth::user()->userProfile->last_name ?? '', 0, 1));
            @endphp
            @if(Auth::user()->profile_image_url)
                <img 
                    src="{{ asset('storage/' . Auth::user()->userProfile->profile_image_url) }}" 
                    alt="User Profile" 
                    class="h-12 w-12 rounded-full object-cover border-2 border-orange-200"
                >
            @else
                <div class="h-12 w-12 rounded-full {{ $assignedColor }} flex items-center justify-center text-sm font-semibold text-white border-2 border-orange-200">
                    {{ $firstInitial }}{{ $lastInitial }}
                </div>
            @endif
            
            <!-- User Info -->
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">
                    {{ Auth::user()->userProfile->first_name ?? '' }} {{ Auth::user()->userProfile->last_name ?? '' }}
                </p>
                <p class="text-xs text-gray-600 truncate">
                    {{ Auth::user()->email }}
                </p>
            </div>
        </div>
    </div>
</div>