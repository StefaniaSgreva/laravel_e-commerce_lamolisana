@extends('layouts.app')

@section('page-title', "{$product->nome} - La Molisana")

@section('meta-description', $product->meta_description ?? "Scopri {$product->nome} de La Molisana: {$product->descrizione}")

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ $product->nome }}</h1>
            <p class="text-xl max-w-3xl mx-auto">
                {{ $product->tipo_formattato }} - {{ $product->peso_formattato }}
            </p>
        </div>
    </section>

    <!-- Product Detail Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Product Image -->
            <div class="lg:w-1/2">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <figure class="relative pb-[100%] overflow-hidden">
                        <img
                            src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                            alt="{{ $product->img_alt ?? $product->nome }}"
                            class="absolute h-full w-full object-cover"
                            loading="lazy"
                            width="800"
                            height="800"
                        >
                    </figure>
                </div>
            </div>

            <!-- Product Details -->
            <div class="lg:w-1/2">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <!-- Badges -->
                    <div class="flex space-x-4 mb-6">
                        @if($product->in_offerta)
                            <span class="bg-molisana-orange text-white px-4 py-1 rounded-full text-sm font-bold">
                                OFFERTA -{{ $product->sconto_percentuale }}%
                            </span>
                        @endif
                        @if($product->novita)
                            <span class="bg-molisana-green text-white px-4 py-1 rounded-full text-sm font-bold">
                                NOVITÀ
                            </span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        @if($product->in_offerta)
                            <span class="text-gray-400 line-through text-xl mr-3">{{ $product->prezzo_formattato }}</span>
                            <span class="text-3xl font-bold text-molisana-orange">{{ $product->prezzo_offerta_formattato }}</span>
                        @else
                            <span class="text-3xl font-bold text-molisana-blue">{{ $product->prezzo_formattato }}</span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose max-w-none mb-8">
                        <p class="text-gray-700">{{ $product->descrizione }}</p>
                    </div>

                    <!-- Details -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-600 mb-2">Tipo</h4>
                            <p>{{ $product->tipo_formattato }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-600 mb-2">Peso</h4>
                            <p>{{ $product->peso_formattato }}</p>
                        </div>
                        @if($product->tempo_cottura)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-600 mb-2">Tempo cottura</h4>
                            <p>{{ $product->tempo_cottura_formattato }}</p>
                        </div>
                        @endif
                        @if($product->valutazione)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-600 mb-2">Valutazione</h4>
                            <div class="text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fas {{ $i < $product->valutazione ? 'fa-star' : 'fa-star-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @endif
                        @if($product->allergeni)
                        <div class="bg-gray-50 p-4 rounded-lg col-span-2">
                            <h4 class="font-bold text-gray-600 mb-2">Allergeni</h4>
                            <ul class="list-disc list-inside">
                                @foreach($product->allergeni as $allergene)
                                    <li>{{ $allergene }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    <!-- Add to Cart Button -->
                    <button
                        class="w-full bg-molisana-orange text-white px-6 py-3 rounded-full text-lg font-bold hover:bg-molisana-orange-hover transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-molisana-blue"
                        aria-label="Aggiungi {{ $product->nome }} al carrello"
                    >
                        <i class="fas fa-shopping-cart mr-2" aria-hidden="true"></i>
                        Aggiungi al carrello
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-center mb-8">Potrebbero piacerti anche</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                    <article class="group bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex flex-col space-y-2 z-10">
                            @if($related->in_offerta)
                                <span class="bg-molisana-orange text-white px-3 py-1 rounded-full text-sm font-bold">
                                    OFFERTA -{{ $related->sconto_percentuale }}%
                                </span>
                            @endif
                            @if($related->novita)
                                <span class="bg-molisana-green text-white px-3 py-1 rounded-full text-sm font-bold">
                                    NOVITÀ
                                </span>
                            @endif
                        </div>

                        <!-- Product Image -->
                        <figure class="relative pb-[100%] overflow-hidden">
                            <img
                                src="{{ Vite::asset('resources/img/products/' . $related->src_img) }}"
                                alt="{{ $related->img_alt ?? $related->nome }}"
                                class="absolute h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                                width="400"
                                height="400"
                            >
                        </figure>

                        <!-- Product Details -->
                        <div class="p-6 flex flex-col h-full">
                            <div>
                                <h3 class="text-xl text-center font-bold text-molisana-dark-orange mb-2">
                                    <a href="{{ route('singleproduct', $related->slug) }}" class="hover:underline">
                                        {{ $related->nome }}
                                    </a>
                                </h3>
                                <p class="text-center text-gray-500 text-sm mb-4">
                                    {{ $related->tipo_formattato }}
                                </p>

                                <div class="text-center my-4">
                                    @if($related->in_offerta)
                                        <span class="text-gray-400 line-through mr-2">{{ $related->prezzo_formattato }}</span>
                                        <span class="text-xl font-bold text-molisana-orange">{{ $related->prezzo_offerta_formattato }}</span>
                                    @else
                                        <span class="text-xl font-bold text-molisana-blue">{{ $related->prezzo_formattato }}</span>
                                    @endif
                                    <span class="block text-sm text-gray-500 mt-1">{{ $related->peso_formattato }}</span>
                                </div>

                                <div class="flex justify-center mt-4">
                                    <a href="{{ route('singleproduct', $related->slug) }}"
                                       class="text-molisana-blue font-semibold hover:underline focus:outline-none focus:ring-2 focus:ring-molisana-orange focus:ring-offset-2 rounded">
                                        Scopri di più
                                        <span class="sr-only">: {{ $related->nome }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
