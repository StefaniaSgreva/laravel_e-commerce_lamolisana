@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                Benvenuti da La Molisana
            </h1>
            <p class="text-xl max-w-3xl mx-auto mb-8">
                Pasta artigianale dal 1912
            </p>
            <div class="flex justify-center gap-4">
                <a href="#products" class="bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-2 rounded-md transition-colors">
                    I nostri prodotti
                </a>
                <a href="#about" class="border border-molisana-orange text-molisana-orange hover:bg-molisana-orange px-6 py-2 rounded-md transition-colors duration-300">
                    La nostra storia
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Info Cards -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <i class="fas fa-wheat-alt text-3xl text-molisana-orange mb-3"></i>
                <h3 class="font-semibold text-lg mb-2 text-molisana-dark-orange">Materie Prime</h3>
                <p class="text-gray-600">Solo grani italiani di alta qualità</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <i class="fas fa-history text-3xl text-molisana-orange mb-3"></i>
                <h3 class="font-semibold text-lg mb-2 text-molisana-dark-orange">Tradizione</h3>
                <p class="text-gray-600">Tecniche artigianali dal 1912</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <i class="fas fa-leaf text-3xl text-molisana-orange mb-3"></i>
                <h3 class="font-semibold text-lg mb-2 text-molisana-dark-orange">Naturale</h3>
                <p class="text-gray-600">Lavorazione senza additivi</p>
            </div>
        </div>
    </section>

    <!-- Simple Product Showcase -->
    <section id="products" class="py-12 bg-neutral-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-center text-molisana-dark-orange mb-8">Le nostre paste</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($featuredProducts as $product)
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                    <a href="{{ route('singleproduct', $product->slug) }}" class="block">
                        <div class="bg-gray-100 h-32 mb-3 rounded-md flex justify-center items-center overflow-hidden">
                            <img src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                                alt="{{ $product->img_alt ?? $product->nome }}"
                                class="w-[60%] object-contain">
                        </div>
                        <h3 class="font-medium text-molisana-blue">{{ $product->nome }}</h3>
                        <div class="mt-2">
                            @if($product->in_offerta)
                                <span class="text-sm text-gray-400 line-through">{{ $product->prezzo_formattato }}</span>
                                <span class="text-molisana-orange font-semibold">{{ $product->prezzo_offerta_formattato }}</span>
                            @else
                                <span class="text-molisana-blue font-semibold">{{ $product->prezzo_formattato }}</span>
                            @endif
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('products') }}" class="inline-block bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-2 rounded-md transition-colors">
                    Scopri tutti i prodotti
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-3xl text-center">
            <h2 class="text-2xl font-bold text-molisana-dark-orange mb-6">La nostra storia</h2>
            <p class="text-gray-700 mb-6">
                Fondata nel cuore del Molise, La Molisana porta avanti con orgoglio la tradizione pastaria italiana,
                combinando sapienza artigianale e materie prime eccellenti.
            </p>
            <img src="{{ Vite::asset('resources/img/pastificio_home.jpg') }}" alt="Pastificio La Molisana" class="rounded-lg shadow mx-auto mb-6 w-full max-w-2xl">
            <a href="{{ route('about') }}" class="inline-block bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-2 rounded-md transition-colors">
                Scopri di più
            </a>
        </div>
    </section>
</div>
@endsection
