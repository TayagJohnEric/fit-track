<!-- Mobile Sidebar -->
<div id="sidebar" class="sidebar-transition sidebar-mobile-closed md:sidebar-mobile-open fixed md:static top-0 left-0 z-50 w-64 h-full bg-gray-100 text-gray-700 shadow-lg md:shadow-sm">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4">
        <h2 class="text-xl font-bold text-gray-800">Fit-Track</h2>
        <!-- Close button (mobile only) -->
        <button id="sidebar-close" class="md:hidden p-2 rounded-lg text-gray-500 hover:text-red-500 hover:bg-red-50 transition-colors focus:outline-none focus:ring-2 focus:ring-red-200">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
    
    <!-- Sidebar Navigation -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-2 px-4">
            <!-- Dashboard -->
            <li>
                <a href="#" class="group flex items-center font-semibold p-3 rounded-lg hover:bg-gray-700 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 text-gray-400 group-hover:text-white lucide lucide-house">
                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                        <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    <span class="ml-3 text-sm">Home</span>
                </a>
            </li>

            <!-- User Management -->
            <li>
                <a href="#" class="group flex items-center font-semibold p-3 rounded-lg hover:bg-gray-700 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 text-gray-400 group-hover:text-white lucide lucide-user-cog">
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
                    <span class="ml-3 text-sm">Users</span>
                </a>
            </li>
            
            <!-- Exercises Management -->
            <li>
                <a href="#" class="group flex items-center font-semibold p-3 rounded-lg hover:bg-gray-700 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 text-gray-400 group-hover:text-white lucide lucide-activity">
                        <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"/>
                    </svg>
                    <span class="ml-3 text-sm">Exercises</span>
                </a>
            </li>

            <!-- Food Items -->
            <li>
                <a href="#" class="group flex items-center font-semibold p-3 rounded-lg hover:bg-gray-700 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 text-gray-400 group-hover:text-white lucide lucide-beef">
                        <path d="M16.4 13.7A6.5 6.5 0 1 0 6.28 6.6c-1.1 3.13-.78 3.9-3.18 6.08A3 3 0 0 0 5 18c4 0 8.4-1.8 11.4-4.3"/>
                        <path d="m18.5 6 2.19 4.5a6.48 6.48 0 0 1-2.29 7.2C15.4 20.2 11 22 7 22a3 3 0 0 1-2.68-1.66L2.4 16.5"/>
                        <circle cx="12.5" cy="8.5" r="2.5"/>
                    </svg>
                    <span class="ml-3 text-sm">Food Items</span>
                </a>
            </li>

            <!-- Workout Templates -->
            <li>
                <a href="#" class="group flex items-center font-semibold p-3 rounded-lg hover:bg-gray-700 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 text-gray-400 group-hover:text-white lucide lucide-dumbbell">
                        <path d="M17.596 12.768a2 2 0 1 0 2.829-2.829l-1.768-1.767a2 2 0 0 0 2.828-2.829l-2.828-2.828a2 2 0 0 0-2.829 2.828l-1.767-1.768a2 2 0 1 0-2.829 2.829z"/>
                        <path d="m2.5 21.5 1.4-1.4"/>
                        <path d="m20.1 3.9 1.4-1.4"/>
                        <path d="M5.343 21.485a2 2 0 1 0 2.829-2.828l1.767 1.768a2 2 0 1 0 2.829-2.829l-6.364-6.364a2 2 0 1 0-2.829 2.829l1.768 1.767a2 2 0 0 0-2.828 2.829z"/>
                        <path d="m9.6 14.4 4.8-4.8"/>
                    </svg>                  
                    <span class="ml-3 text-sm">Workout Templates</span>
                </a>
            </li>

            <!-- Fitness Facts -->
            <li>
                <a href="#" class="group flex items-center font-semibold p-3 rounded-lg hover:bg-gray-700 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="w-5 h-5 text-gray-400 group-hover:text-white lucide lucide-square-activity">
                        <rect width="18" height="18" x="3" y="3" rx="2"/>
                        <path d="M17 12h-2l-2 5-2-10-2 5H7"/>
                    </svg>                   
                    <span class="ml-3 text-sm">Fitness Facts</span>
                </a>
            </li>

           
        </ul>
    </nav>
</div>