<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="text-xl font-bold text-indigo-600">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-6 w-auto">
                </a>
            </div>

            <!-- Desktop menu -->
            <div class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-700 hover:text-indigo-600">Home</a>
                <a href="/books" class="text-gray-700 hover:text-indigo-600">Libri</a>
                <!-- <a href="#" class="text-gray-700 hover:text-indigo-600">Podcast</a>
                <a href="#" class="text-gray-700 hover:text-indigo-600">Aggiornamenti</a> -->
            </div>
            @guest
            <a href="{{ url('/register') }}" class="hidden sm:inline-block bg-primary text-white px-4 py-2 rounded-full hover:bg-primary/80">
                Prova Readskip
            </a> 
            @endguest           
            @auth
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <!-- Bottone principale -->
                <button @click="open = !open" 
                        class="hidden sm:inline-block bg-primary text-white px-4 py-2 rounded-full hover:bg-primary/80">
                    Ciao, {{ Auth::user()->name }}
                </button>

                <!-- Dropdown menu -->
                <div x-show="open" 
                    @click.away="open = false"
                    x-transition
                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                    <div class="py-1">
                        <a href="{{ route('user.profile') }}" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profilo
                        </a>
                        <a href="{{ route('user.note') }}" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Le mie evidenziazioni
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu (hidden by default) -->
    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 space-y-2">
        <a href="/" class="block text-gray-700 hover:text-indigo-600">Home</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600">Chi siamo</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600">Servizi</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600">Contatti</a>
    </div>
</nav>

<script>
    // Toggle mobile menu
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>