@extends('layouts.app')

@section('page-title', $product->nome . ' - La Molisana')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ $product->nome }}</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Scopri tutti i dettagli di questo prodotto de La Molisana
            </p>
        </div>
    </section>

    <!-- Product Details Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div class="relative rounded-xl overflow-hidden shadow-lg">
                @if($product->src_img)
                    <img
                        src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                        alt="{{ $product->nome }} - Pasta La Molisana"
                        class="w-full h-auto object-cover"
                        loading="lazy"
                        width="800"
                        height="800"
                    >
                @else
                    <div class="bg-gray-200 aspect-square flex items-center justify-center">
                        <span class="text-gray-500">Immagine non disponibile</span>
                    </div>
                @endif

                @if($product->in_offerta)
                    <span class="absolute top-4 right-4 bg-molisana-blue text-white px-4 py-2 rounded-full text-sm font-bold">
                        OFFERTA SPECIALE
                    </span>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col">
                <!-- Price Section -->
                <div class="mb-6">
                    @if($product->in_offerta)
                        <div class="flex items-center gap-4">
                            <span class="text-3xl font-bold text-molisana-orange">
                                {{ $product->prezzo_offerta_formattato }}
                            </span>
                            <span class="text-xl text-gray-400 line-through">
                                {{ $product->prezzo_formattato }}
                            </span>
                            <span class="bg-molisana-orange text-white px-3 py-1 rounded-full text-sm font-bold">
                                RISPARMIO {{ $savingPercentage }}%
                            </span>
                        </div>
                    @else
                        <span class="text-3xl font-bold text-molisana-blue">
                            {{ $product->prezzo_formattato }}
                        </span>
                    @endif
                </div>

                <!-- Product Meta -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    @if($product->tipo)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">TIPO</h3>
                            <p class="text-lg font-medium">{{ ucfirst($product->tipo) }}</p>
                        </div>
                    @endif

                    @if($product->peso)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">PESO</h3>
                            <p class="text-lg font-medium">{{ $product->peso }}g</p>
                        </div>
                    @endif

                    @if($product->tempo_cottura)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">COTTURA</h3>
                            <p class="text-lg font-medium">{{ $product->tempo_cottura }} min</p>
                        </div>
                    @endif

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-500 mb-1">DISPONIBILITÀ</h3>
                        <p class="text-lg font-medium flex items-center gap-2">
                            @if($product->disponibile)
                                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                                Disponibile
                            @else
                                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                Esaurito
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-molisana-dark-orange mb-4">Descrizione</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $product->descrizione ?? 'Descrizione non disponibile' }}
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                    @if($product->disponibile)
                        <button
                            class="cursor-pointer flex-1 bg-molisana-orange text-white px-6 py-4 rounded-lg text-lg font-bold hover:bg-molisana-orange-hover transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-molisana-blue flex items-center justify-center gap-3"
                            onclick="addToCart({{ $product->id }})"
                        >
                            <i class="fas fa-shopping-cart"></i>
                            Aggiungi al carrello
                        </button>
                    @else
                        <button
                            class="flex-1 bg-gray-300 text-gray-600 px-6 py-4 rounded-lg text-lg font-bold cursor-not-allowed"
                            disabled
                        >
                            Prodotto esaurito
                        </button>
                    @endif
{{--
                    <button
                        class="flex-1 border border-molisana-blue text-molisana-blue px-6 py-4 rounded-lg text-lg font-bold hover:bg-molisana-blue hover:text-white transition-colors flex items-center justify-center gap-3"
                    >
                        <i class="far fa-heart"></i>
                        Wishlist
                    </button> --}}
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-molisana-dark-orange mb-8">Potrebbero piacerti anche</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($relatedProducts as $related)
                        <article class="group bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <figure class="relative pb-[100%] overflow-hidden">
                                <img
                                    src="{{ Vite::asset('resources/img/products/' . $related->src_img) }}"
                                    alt="{{ $related->nome }} - Pasta La Molisana"
                                    class="absolute h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy"
                                    width="400"
                                    height="400"
                                >
                                @if($related->in_offerta)
                                    <span class="absolute top-4 right-4 bg-molisana-blue text-white px-3 py-1 rounded-full text-sm font-bold">
                                        OFFERTA
                                    </span>
                                @endif
                            </figure>
                            <div class="p-6 flex flex-col h-full">
                                <div>
                                    <h3 class="text-xl text-center font-bold text-molisana-dark-orange mb-2">{{ $related->nome }}</h3>

                                    <div class="text-center my-4">
                                        @if($related->in_offerta)
                                            <span class="text-gray-400 line-through mr-2">{{ $related->prezzo_formattato }}</span>
                                            <span class="text-xl font-bold text-molisana-orange">{{ $related->prezzo_offerta_formattato }}</span>
                                        @else
                                            <span class="text-xl font-bold text-molisana-blue">{{ $related->prezzo_formattato }}</span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center mt-4">
                                        <a href="{{ route('singleproduct', $related->id) }}"
                                        class="text-molisana-blue font-semibold hover:underline focus:outline-none focus:ring-2 focus:ring-molisana-orange focus:ring-offset-2 rounded">
                                            Scopri di più
                                        </a>
                                        <button
                                            class="cursor-pointer bg-molisana-orange text-white px-4 py-2 rounded-full text-sm font-bold hover:bg-molisana-orange-hover transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-molisana-blue"
                                            aria-label="Aggiungi {{ $related->nome }} al carrello"
                                            onclick="addToCart({{ $related->id }})"
                                        >
                                            <i class="fas fa-shopping-cart mr-2" aria-hidden="true"></i>
                                            Acquista
                                        </button>
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

@section('scripts')
<script>
    function addToCart(productId) {
        // Implementazione temporanea
        console.log('Aggiunto al carrello prodotto ID:', productId);
        alert('Prodotto aggiunto al carrello! ID: ' + productId);

        // Qui andrà la logica AJAX per aggiungere al carrello
        /*
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            // Aggiorna l'UI del carrello
        });
        */
    }
</script>
@endsection
