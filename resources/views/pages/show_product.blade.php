@extends('layouts.app')

@section('page-title', $product->nome . ' - La Molisana')

@section('content')
<div class="min-h-screen bg-neutral-50">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-12 md:py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $product->nome }}</h1>
                    @if($product->descrizione)
                        <p class="text-lg mb-4">{{ Str::limit($product->descrizione, 150) }}</p>
                    @endif
                    <div class="flex items-center">
                        @if($product->in_offerta)
                            <span class="text-2xl font-bold text-molisana-orange mr-4">
                                {{ $product->prezzo_offerta_formattato }}
                            </span>
                            <span class="text-xl text-gray-300 line-through">
                                {{ $product->prezzo_formattato }}
                            </span>
                        @else
                            <span class="text-2xl font-bold text-white">
                                {{ $product->prezzo_formattato }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <img src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                         alt="{{ $product->nome }}"
                         class="max-h-80 object-contain"
                         loading="eager">
                </div>
            </div>
        </div>
    </section>

    <!-- Product Details -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Main Image -->
                <div class="lg:w-1/2 bg-white p-6 rounded-xl shadow-md">
                    <div class="relative pb-[100%] overflow-hidden rounded-lg">
                        <img src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                             alt="{{ $product->nome }}"
                             class="absolute w-full h-full object-cover"
                             loading="lazy">
                        @if($product->in_offerta)
                            <span class="absolute top-4 right-4 bg-molisana-orange text-white px-3 py-1 rounded-full text-sm font-bold">
                                OFFERTA
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="lg:w-1/2">
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        @if($product->descrizione)
                            <h2 class="text-2xl font-bold text-molisana-blue mb-4">Descrizione</h2>
                            <p class="text-gray-700 mb-6">{{ $product->descrizione }}</p>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            @if($product->tipo)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-2">Tipo</h3>
                                    <p class="text-gray-600 capitalize">{{ $product->tipo }}</p>
                                </div>
                            @endif

                            @if($product->peso)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-2">Peso</h3>
                                    <p class="text-gray-600">{{ $product->peso }} g</p>
                                </div>
                            @endif

                            @if($product->tempo_cottura)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-2">Tempo di cottura</h3>
                                    <p class="text-gray-600">{{ $product->tempo_cottura }} minuti</p>
                                </div>
                            @endif

                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Disponibilità</h3>
                                <p class="text-gray-600">
                                    @if($product->disponibile)
                                        <span class="text-green-600">Disponibile</span>
                                    @else
                                        <span class="text-red-600">Esaurito</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
</div>
@endsection
