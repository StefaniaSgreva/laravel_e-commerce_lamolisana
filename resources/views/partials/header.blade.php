<header class="bg-neutral-50 shadow-md sticky top-0 z-50"
        role="banner"
        aria-label="Intestazione del sito"
        id="main-header">
    <!-- Barra superiore con logo e hamburger -->
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-3 md:hidden">
            <!-- Logo mobile a sinistra -->
            <div id="mobile-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ Vite::asset('resources/img/logo.png') }}"
                         alt="Logo"
                         class="h-10 transition-all duration-300"
                         loading="eager">
                </a>
            </div>

            <!-- Hamburger Menu Button a destra -->
            <button id="mobile-menu-button"
                    class="p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                    aria-label="Menu"
                    aria-expanded="false"
                    aria-controls="mobile-menu">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path class="ham-bar top-bar" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 6h16" />
                    <path class="ham-bar middle-bar" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 12h16" />
                    <path class="ham-bar bottom-bar" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Logo Desktop -->
        <div id="desktop-header" class="hidden md:block">
            <div id="logo-container" class="transition-all duration-500 ease-[cubic-bezier(0.33,1,0.68,1)] z-10">
                <div id="logo" class="flex justify-center py-4 transition-opacity duration-300 ease-linear">
                    <img src="{{ Vite::asset('resources/img/logo.png') }}"
                        alt="Logo"
                        class="h-30"
                        loading="eager"
                        style="transform: translateZ(0)">
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar desktop -->
    <nav class="desktop-nav hidden md:flex justify-center pb-4 z-20 relative"
        role="navigation"
        aria-label="Menu principale">
        <ul class="flex gap-8 items-center">
            <li class="nav-item">
                <a href="{{ route('home') }}"
                class="nav-link {{ Route::is('home') ? 'nav-link-active' : '' }}">
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('about') }}"
                class="nav-link {{ Route::is('about') ? 'nav-link-active' : '' }}">
                    Chi Siamo
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products') }}"
                class="nav-link {{ Route::is('products') ? 'nav-link-active' : '' }}">
                    Prodotti
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('blog') }}"
                class="nav-link {{ Route::is('blog') ? 'nav-link-active' : '' }}">
                    Blog
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contacts') }}"
                class="nav-link {{ Route::is('contacts') ? 'nav-link-active' : '' }}">
                    Contatti
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cart') }}"
                class="nav-link {{ Route::is('cart') ? 'nav-link-active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden fixed inset-0 bg-white z-40 pt-16 overflow-y-auto">
        <nav role="navigation" aria-label="Menu mobile" class="container mx-auto px-4 py-4">
            <ul class="flex flex-col gap-1">
                <li>
                    <a href="{{ route('home') }}" class="block px-4 py-3 text-lg font-medium {{ Route::is('home') ? 'text-blue-600 bg-blue-50' : 'text-gray-800 hover:bg-gray-100' }} rounded-lg transition">Home</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="block px-4 py-3 text-lg font-medium {{ Route::is('about') ? 'text-blue-600 bg-blue-50' : 'text-gray-800 hover:bg-gray-100' }} rounded-lg transition">Chi Siamo</a>
                </li>
                <li>
                    <a href="{{ route('products') }}" class="block px-4 py-3 text-lg font-medium {{ Route::is('products') ? 'text-blue-600 bg-blue-50' : 'text-gray-800 hover:bg-gray-100' }} rounded-lg transition">Prodotti</a>
                </li>
                <li>
                    <a href="{{ route('blog') }}" class="block px-4 py-3 text-lg font-medium {{ Route::is('blog') ? 'text-blue-600 bg-blue-50' : 'text-gray-800 hover:bg-gray-100' }} rounded-lg transition">Blog</a>
                </li>
                <li>
                    <a href="{{ route('contacts') }}" class="block px-4 py-3 text-lg font-medium {{ Route::is('contacts') ? 'text-blue-600 bg-blue-50' : 'text-gray-800 hover:bg-gray-100' }} rounded-lg transition">Contatti</a>
                </li>
                                    <li>
                    <a href="{{ route('cart') }}" class="block px-4 py-3 text-lg font-medium {{ Route::is('cart') ? 'text-blue-600 bg-blue-50' : 'text-gray-800 hover:bg-gray-100' }} rounded-lg transition">Carrello</a>
                </li>
            </ul>
        </nav>
    </div>

</header>
