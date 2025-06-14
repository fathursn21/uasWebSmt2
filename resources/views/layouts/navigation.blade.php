<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                
                <a href="
                    @auth 
                    {{ 
                        Auth::user()->role === 'admin' ? route('dashboard') : route('produk.index') 
                     }}
                        @else{{ route('produk.index') }} 
                    @endauth ">
                    <h1>Jobada Phone</h1>
                </a>
            </div>

           
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                       
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        @if (Auth::user()->role === 'admin')
                        <x-dropdown-link :href="route('dashboard')">Dashboard</x-dropdown-link>
                        <x-dropdown-link :href="route('produk.index')">Daftar Produk</x-dropdown-link>
                        @elseif (Auth::user()->role === 'pelanggan')
                        <x-dropdown-link :href="route('produk.cart')">Keranjang</x-dropdown-link>
                        @endif

                       
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth

                @guest
                
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:text-blue-800">Register</a>
                </div>
                @endguest
            </div>

            
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-md focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden hidden">
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>

                @if (Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('produk.index')">Daftar Produk</x-responsive-nav-link>
                @elseif (Auth::user()->role === 'pelanggan')
                <x-responsive-nav-link :href="route('produk.cart')">Keranjang</x-responsive-nav-link>
                @endif

                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth

        @guest
        
        <div class="pt-4 pb-1 border-t border-gray-200 px-4">
            <a href="{{ route('login') }}" class="block py-2 text-sm text-gray-700 hover:text-gray-900">Login</a>
            <a href="{{ route('register') }}" class="block py-2 text-sm text-blue-600 hover:text-blue-800">Register</a>
        </div>
        @endguest
    </div>
</nav>