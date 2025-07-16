<header class="bg-neutral-50 shadow-md sticky top-0 z-50"
        role="banner"
        aria-label="Intestazione del sito"
        id="main-header">
    <div class="container mx-auto px-4 relative overflow-hidden">
        <!-- Logo con doppio strato di transizione -->
        <div id="logo-container" class="transition-all duration-500 ease-[cubic-bezier(0.33,1,0.68,1)] z-10">
            <div id="logo" class="flex justify-center py-4 transition-opacity duration-300 ease-linear">
                <img src="{{ Vite::asset('resources/img/logo.png') }}"
                     alt="Logo"
                     class="h-30"
                     loading="eager"
                     style="transform: translateZ(0)">
            </div>
        </div>

        <!-- Navbar con padding animato -->
        <nav class="flex justify-center pb-4 transition-all duration-500 ease-[cubic-bezier(0.33,1,0.68,1)] z-20 relative"
             role="navigation"
             aria-label="Menu principale">
            <ul class="flex  gap-6 items-center">
                <li class="relative z-30">
                    <a href="{{ route('home') }}" class="font-medium transition duration-300 {{ Route::is('home') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Home
                    </a>
                </li>
                <li class="relative z-30">
                    <a href="{{ route('about') }}" class="font-medium transition duration-300 {{ Route::is('about') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Chi Siamo
                    </a>
                </li>
                <li class="relative z-30">
                    <a href="{{ route('products') }}" class="font-medium transition duration-300 {{ Route::is('products') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Prodotti
                    </a>
                </li>
                <li class="relative z-30">
                    <a href="{{ route('blog') }}" class="font-medium transition duration-300 {{ Route::is('blog') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Blog
                    </a>
                </li>
                <li class="relative z-30">
                    <a href="{{ route('contacts') }}" class="font-medium transition duration-300 {{ Route::is('contacts') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Contatti
                    </a>
                </li>
                <li class="relative z-30">
                    <a href="{{ route('cart') }}" class="font-medium transition duration-300 {{ Route::is('cart') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Carrello
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
