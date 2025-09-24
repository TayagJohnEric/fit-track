<!-- Mobile Sidebar -->
<div id="sidebar" class="sidebar-transition sidebar-mobile-closed md:sidebar-mobile-open fixed md:static top-0 left-0 z-50 w-64 h-full bg-gray-100 text-orange-900 flex flex-col">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4">
        <!-- Logo -->
        <img src="{{ asset('images/logo-black.png') }}" alt="Example" class="h-8 w-auto mx-auto mt-3">
        
        <!-- Close button (mobile only) -->
        <button id="sidebar-close" class="md:hidden p-2 rounded-lg text-orange-600 hover:text-red-600 hover:bg-red-100 transition-colors focus:outline-none focus:ring-2 focus:ring-red-300">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    
    <!-- User Profile Section (Admin Profile) -->
    <div class="px-6 py-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <!-- Admin Profile Image/Avatar -->
            @php
                $assignedColor = 'bg-gray-800';
                $firstInitial = 'A'; // Admin
                $lastInitial = 'D'; // Dashboard
            @endphp
            
            <div class="h-12 w-12 rounded-full {{ $assignedColor }} flex items-center justify-center text-sm font-semibold text-white border-2 border-orange-200">
                {{ $firstInitial }}{{ $lastInitial }}
            </div>
            
            <!-- Admin Info -->
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">
                    Admin Dashboard
                </p>
                <p class="text-xs text-gray-600 truncate">
                    Administrator
                </p>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Navigation -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-2 px-4">
            <!-- Admin Dashboard Section -->
            <li class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase">Admin Dashboard</li>
            
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center font-semibold p-3 rounded-lg transition-all duration-200 {{ request()->is('admin/dashboard') ? 'bg-orange-100 text-orange-500' : 'hover:bg-orange-100 hover:text-orange-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 {{ request()->is('admin/dashboard') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }} lucide lucide-house">
                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                        <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    <span class="ml-3 text-sm font-semibold tracking-tighter {{ request()->is('admin/dashboard') ? 'text-orange-500' : 'text-gray-800 group-hover:text-orange-500' }}">Dashboard</span>
                </a>
            </li>

            <!-- Content Management Section -->
            <li class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase">Content Management</li> 

            <!-- Exercises Management -->
            <li>
                <a href="{{ route('exercises.index') }}" class="group flex items-center font-semibold p-3 rounded-lg transition-all duration-200 {{ request()->is('exercises*') ? 'bg-orange-100 text-orange-500' : 'hover:bg-orange-100 hover:text-orange-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 {{ request()->is('exercises*') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }} lucide lucide-activity">
                        <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"/>
                    </svg>
                    <span class="ml-3 text-sm font-semibold tracking-tighter {{ request()->is('exercises*') ? 'text-orange-500' : 'text-gray-800 group-hover:text-orange-500' }}">Exercises</span>
                </a>
            </li>

            <!-- Food Items -->
            <li>
                <a href="{{ route('food_items.index') }}" class="group flex items-center font-semibold p-3 rounded-lg transition-all duration-200 {{ request()->is('food-items*') ? 'bg-orange-100 text-orange-500' : 'hover:bg-orange-100 hover:text-orange-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 {{ request()->is('food-items*') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }} lucide lucide-beef">
                        <path d="M16.4 13.7A6.5 6.5 0 1 0 6.28 6.6c-1.1 3.13-.78 3.9-3.18 6.08A3 3 0 0 0 5 18c4 0 8.4-1.8 11.4-4.3"/>
                        <path d="m18.5 6 2.19 4.5a6.48 6.48 0 0 1-2.29 7.2C15.4 20.2 11 22 7 22a3 3 0 0 1-2.68-1.66L2.4 16.5"/>
                        <circle cx="12.5" cy="8.5" r="2.5"/>
                    </svg>
                    <span class="ml-3 text-sm font-semibold tracking-tighter {{ request()->is('food-items*') ? 'text-orange-500' : 'text-gray-800 group-hover:text-orange-500' }}">Food Items</span>
                </a>
            </li>


            

            <!-- Workout Templates -->
            <li>
                <a href="{{ route('workout_templates.index') }}" class="group flex items-center font-semibold p-3 rounded-lg transition-all duration-200 {{ request()->is('workout-templates*') ? 'bg-orange-100 text-orange-500' : 'hover:bg-orange-100 hover:text-orange-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 {{ request()->is('workout-templates*') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }} lucide lucide-dumbbell">
                        <path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/>
                        <path d="m2.5 21.5 1.4-1.4"/>
                        <path d="m20.1 3.9 1.4-1.4"/>
                        <path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/>
                        <path d="m9.6 14.4 4.8-4.8"/>
                    </svg>                  
                    <span class="ml-3 text-sm font-semibold tracking-tighter {{ request()->is('workout-templates*') ? 'text-orange-500' : 'text-gray-800 group-hover:text-orange-500' }}">Workout Templates</span>
                </a>
            </li>

            <!-- Workout Template Exercises -->
            <li>
                <a href="{{ route('workout-template-exercises.index') }}" class="group flex items-center font-semibold p-3 rounded-lg transition-all duration-200 {{ request()->is('workout-template-exercises*') ? 'bg-orange-100 text-orange-500' : 'hover:bg-orange-100 hover:text-orange-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 {{ request()->is('workout-template-exercises*') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }} lucide lucide-blocks">
                        <path d="M10 22V7a1 1 0 0 0-1-1H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5a1 1 0 0 0-1-1H2"/>
                        <rect x="14" y="2" width="8" height="8" rx="1"/>
                    </svg>
                    <span class="ml-3 text-sm font-semibold tracking-tighter {{ request()->is('workout-template-exercises*') ? 'text-orange-500' : 'text-gray-800 group-hover:text-orange-500' }}">Workout Builder</span>
                </a>
            </li>

            <!-- Fitness Motivation -->
            <li>
                <a href="{{ route('fitness-motivations.index') }}" class="group flex items-center font-semibold p-3 rounded-lg transition-all duration-200 {{ request()->is('fitness-motivations*') ? 'bg-orange-100 text-orange-500' : 'hover:bg-orange-100 hover:text-orange-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 {{ request()->is('fitness-motivations*') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }} lucide lucide-biceps-flexed">
                        <path d="M12.409 13.017A5 5 0 0 1 22 15c0 3.866-4 7-9 7-4.077 0-8.153-.82-10.371-2.462-.426-.316-.631-.832-.62-1.362C2.118 12.723 2.627 2 10 2a3 3 0 0 1 3 3 2 2 0 0 1-2 2c-1.105 0-1.64-.444-2-1"/>
                        <path d="M15 14a5 5 0 0 0-7.584 2"/>
                        <path d="M9.964 6.825C8.019 7.977 9.5 13 8 15"/>
                    </svg>     
                    <span class="ml-3 text-sm font-semibold tracking-tighter {{ request()->is('fitness-motivations*') ? 'text-orange-500' : 'text-gray-800 group-hover:text-orange-500' }}">Fitness Motivations</span>
                </a>
            </li>

            <!-- Fitness Facts -->
            <li>
                <a href="{{ route('fitness-facts.index') }}" class="group flex items-center font-semibold p-3 rounded-lg transition-all duration-200 {{ request()->is('fitness-facts*') ? 'bg-orange-100 text-orange-500' : 'hover:bg-orange-100 hover:text-orange-500' }}">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 {{ request()->is('fitness-facts*') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }} lucide lucide-brain">
                        <path d="M12 18V5"/>
                        <path d="M15 13a4.17 4.17 0 0 1-3-4 4.17 4.17 0 0 1-3 4"/>
                        <path d="M17.598 6.5A3 3 0 1 0 12 5a3 3 0 1 0-5.598 1.5"/>
                        <path d="M17.997 5.125a4 4 0 0 1 2.526 5.77"/>
                        <path d="M18 18a4 4 0 0 0 2-7.464"/>
                        <path d="M19.967 17.483A4 4 0 1 1 12 18a4 4 0 1 1-7.967-.517"/>
                        <path d="M6 18a4 4 0 0 1-2-7.464"/>
                        <path d="M6.003 5.125a4 4 0 0 0-2.526 5.77"/>
                    </svg>     
                    <span class="ml-3 text-sm font-semibold tracking-tighter {{ request()->is('fitness-facts*') ? 'text-orange-500' : 'text-gray-800 group-hover:text-orange-500' }}">Fitness Facts</span>
                </a>
            </li>

            <!-- User Management Section -->
            <li class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase">User Management</li>

            <!-- User Management -->
            <li>
                <a href="{{ route('admin.users.index') }}" class="group flex items-center font-semibold p-3 rounded-lg transition-all duration-200 {{ request()->is('users*') ? 'bg-orange-100 text-orange-500' : 'hover:bg-orange-100 hover:text-orange-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 {{ request()->is('users*') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }} lucide lucide-user-cog">
                        <path d="M10 15H6a4 4 0 0 0-4 4v2"/>
                        <path d="m14.305 16.53.923-.382"/>
                        <path d="m15.228 13.852-.923-.383"/>
                       <path d="m16.852 12.228-.383-.923"/>
                        <path d="m16.852 17.772-.383.924"/>
                        <path d="m19.148 12.228.383-.923"/>
                        <path d="m19.53 18.696-.382-.924"/>
                        <path d="m20.772 13.852.924-.383"/>
                        <path d="m20.772 16.148.924.383"/>
                        <circle cx="18" cy="15" r="3"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    <span class="ml-3 text-sm font-semibold text-gray-800 group-hover:text-orange-500 tracking-tighter">Manage Users</span>
                </a>
            </li>

        </ul>
    </nav>
</div>
