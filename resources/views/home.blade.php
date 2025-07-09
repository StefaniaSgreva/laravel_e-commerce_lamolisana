@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-neutral-50 py-12 md:py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-amber-800 mb-4">
                Benvenuti da La Molisana
            </h1>
            <p class="text-lg text-amber-700 mb-6">
                Pasta artigianale dal 1912
            </p>
            <div class="flex justify-center gap-4">
                <a href="#products" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-md transition">
                    I nostri prodotti
                </a>
                <a href="#about" class="border border-amber-600 text-amber-600 hover:bg-amber-50 px-6 py-2 rounded-md transition">
                    La nostra storia
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Info Cards -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center">
                <i class="fas fa-wheat-alt text-3xl text-amber-600 mb-3"></i>
                <h3 class="font-semibold text-lg mb-2">Materie Prime</h3>
                <p class="text-gray-600">Solo grani italiani di alta qualità</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center">
                <i class="fas fa-history text-3xl text-amber-600 mb-3"></i>
                <h3 class="font-semibold text-lg mb-2">Tradizione</h3>
                <p class="text-gray-600">Tecniche artigianali dal 1912</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center">
                <i class="fas fa-leaf text-3xl text-amber-600 mb-3"></i>
                <h3 class="font-semibold text-lg mb-2">Naturale</h3>
                <p class="text-gray-600">Lavorazione senza additivi</p>
            </div>
        </div>
    </section>

    <!-- Simple Product Showcase -->
    <section id="products" class="py-12 bg-amber-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-center text-amber-800 mb-8">Le nostre paste</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="bg-gray-100 h-32 mb-3"></div>
                    <h3 class="font-medium">Spaghetti</h3>
                </div>
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="bg-gray-100 h-32 mb-3"></div>
                    <h3 class="font-medium">Penne</h3>
                </div>
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="bg-gray-100 h-32 mb-3"></div>
                    <h3 class="font-medium">Fusilli</h3>
                </div>
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="bg-gray-100 h-32 mb-3"></div>
                    <h3 class="font-medium">Rigatoni</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-3xl text-center">
            <h2 class="text-2xl font-bold text-amber-800 mb-6">La nostra storia</h2>
            <p class="text-gray-700 mb-6">
                Fondata nel cuore del Molise, La Molisana porta avanti con orgoglio la tradizione pastaria italiana,
                combinando sapienza artigianale e materie prime eccellenti.
            </p>
            <img src="{{ Vite::asset('resources/img/pastificio_home.jpg') }}" alt="Pastificio" class="rounded-lg shadow mx-auto mb-6">
            <a href="#" class="inline-block border border-amber-600 text-amber-600 hover:bg-amber-50 px-6 py-2 rounded-md transition">
                Scopri di più
            </a>
        </div>
    </section>
</div>
@endsection
