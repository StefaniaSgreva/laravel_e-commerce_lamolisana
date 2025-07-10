<header class="bg-neutral-50 shadow-md sticky top-0 z-50" role="banner" aria-label="Intestazione del sito">
    <div class="container mx-auto px-4 py-4">
        <!-- Logo centrato -->
        <div id="logo" class="flex justify-center">
            <img src="{{ Vite::asset('resources/img/logo.png') }}" alt="Logo" class="h-30">
        </div>
         <!-- Navbar -->
        <nav class="flex justify-center mt-4" role="navigation" aria-label="Menu principale">
            <ul class="flex  gap-6 items-center">
                <li>
                    <a href="{{ route('home') }}" class="font-medium transition duration-300 {{ Route::is('home') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="font-medium transition duration-300 {{ Route::is('about') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Chi Siamo
                    </a>
                </li>
                <li>
                    <a href="{{ route('products') }}" class="font-medium transition duration-300 {{ Route::is('products') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Prodotti
                    </a>
                </li>
                <li>
                    <a href="{{ route('blog') }}" class="font-medium transition duration-300 {{ Route::is('blog') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Blog
                    </a>
                </li>
                <li>
                    <a href="{{ route('contacts') }}" class="font-medium transition duration-300 {{ Route::is('contacts') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Contatti
                    </a>
                </li>
                <li>
                    <a href="{{ route('cart') }}" class="font-medium transition duration-300 {{ Route::is('cart') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Carrello
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
