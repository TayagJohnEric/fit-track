<!-- Header -->
<header class="bg-gray-100 px-4 py-3">
    <div class="flex items-center justify-between">
        
        <!-- Mobile Menu Button -->
        <button 
            id="sidebar-toggle" 
            class="md:hidden p-2 rounded-lg text-gray-600 hover:text-green-500 hover:bg-green-50 transition-colors focus:outline-none focus:ring-2 focus:ring-green-200"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <!-- Header Actions -->
        <div class="flex items-center space-x-4">

            <!-- Search Bar -->
            @include('components.searchbar')

            <!-- Profile Section -->
            <div class="relative">
               <button 
    id="profile-menu-button" 
    class="border border-gray-200 bg-white flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200"
>
    @php
        $assignedColor = 'bg-gray-200';     
        $firstInitial = strtoupper(substr(Auth::user()->userProfile->name ?? Auth::user()->name, 0, 1));
    @endphp

    @if(Auth::user()->userProfile?->profile_image_url)
        <img 
            src="{{ asset('storage/' . Auth::user()->userProfile->profile_image_url) }}" 
            alt="User Profile" 
            class="h-10 w-10 rounded-full object-cover"
        >
    @else
        <div class="h-10 w-10 rounded-full {{ $assignedColor }} flex items-center justify-center text-sm font-semibold text-gray-700">
            {{ $firstInitial }}
        </div>
    @endif

    <div class="hidden sm:block text-left leading-tight">
        <p class="text-sm font-semibold text-gray-700 m-0">
            {{ Auth::user()->name }}
        </p>
    </div>
</button>


                <!-- Profile Dropdown Menu -->
                <div 
                    id="profile-dropdown" 
                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                >
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Help</a>
                        <hr class="my-1 border-gray-200">
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" x2="9" y1="12" y2="12" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
