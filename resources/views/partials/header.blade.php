<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
        <!-- Logo centrato -->
        <div id="logo" class="flex justify-center">
            <img src="{{ Vite::asset('resources/img/logo.png') }}" alt="Logo" class="h-30">
        </div>
         <!-- Navbar -->
        <nav class="flex justify-center mt-4">
            <ul class="flex  gap-6 items-center">
                <li>
                    <a href="{{ url('/')}}" class="font-medium transition duration-300 {{ Route::is('/') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('products') }}" class="font-medium transition duration-300 {{ Route::is('products') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        Prodotti
                    </a>
                </li>
                <li>
                    <a href="{{ route('blog') }}" class="font-medium transition duration-300 {{ Route::is('blog') ? 'text-blue-600 underline' : 'text-gray-800 hover:text-blue-600' }}">
                        News
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
