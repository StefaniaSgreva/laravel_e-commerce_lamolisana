@extends('layouts.app')

@section('page-title', "{$product->nome} - La Molisana")

@section('meta-description', $product->meta_description ?? "Scopri {$product->nome} de La Molisana: {$product->descrizione}")

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-12 md:py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $product->nome }}</h1>
            <p class="text-lg max-w-3xl mx-auto opacity-90">
                {{ $product->tipo_formattato }} • {{ $product->peso_formattato }}
                @if($product->tempo_cottura)
                    • {{ $product->tempo_cottura_formattato }}
                @endif
            </p>
        </div>
    </section>

    <!-- Product Detail Section -->
    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="flex flex-col lg:flex-row gap-8 md:gap-12">
            <!-- Product Image - Modificato per altezza fissa -->
            <div class="lg:w-5/12 flex">
                <div class="bg-white rounded-xl shadow-md overflow-hidden w-full self-stretch">
                    <figure class="relative h-full min-h-[300px] lg:min-h-0">
                        <div class="absolute inset-0 flex items-center justify-center p-6">
                            <img
                                src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                                alt="{{ $product->img_alt ?? $product->nome }}"
                                class="max-h-full max-w-full object-contain"
                                loading="lazy"
                                width="600"
                                height="600"
                            >
                        </div>
                        <!-- Badges on image -->
                        <div class="absolute top-4 left-4 flex flex-col space-y-2 z-10">
                            @if($product->in_offerta)
                                <span class="bg-molisana-orange text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                                    OFFERTA -{{ $product->sconto_percentuale }}%
                                </span>
                            @endif
                            @if($product->novita)
                                <span class="bg-molisana-blue text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                                    NOVITÀ
                                </span>
                            @endif
                        </div>
                    </figure>
                </div>
            </div>

            <!-- Product Details -->
            <div class="lg:w-7/12">
                <div class="bg-white rounded-xl shadow-md p-6 md:p-8 h-full">
                    <!-- Price -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        @if($product->in_offerta)
                            <span class="text-gray-400 line-through text-xl mr-3">{{ $product->prezzo_formattato }}</span>
                            <span class="text-3xl font-bold text-molisana-orange">{{ $product->prezzo_offerta_formattato }}</span>
                        @else
                            <span class="text-3xl font-bold text-molisana-blue">{{ $product->prezzo_formattato }}</span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose max-w-none mb-8">
                        <p class="text-gray-700 leading-relaxed">{{ $product->descrizione }}</p>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-600 mb-2 text-sm uppercase tracking-wider">Tipo</h4>
                            <p class="font-medium">{{ $product->tipo_formattato }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-600 mb-2 text-sm uppercase tracking-wider">Peso</h4>
                            <p class="font-medium">{{ $product->peso_formattato }}</p>
                        </div>
                        @if($product->tempo_cottura)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-600 mb-2 text-sm uppercase tracking-wider">Cottura</h4>
                            <p class="font-medium">{{ $product->tempo_cottura_formattato }}</p>
                        </div>
                        @endif
                        @if($product->valutazione)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-600 mb-2 text-sm uppercase tracking-wider">Valutazione</h4>
                            <div class="text-yellow-400 flex items-center">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fas {{ $i < $product->valutazione ? 'fa-star' : 'fa-star-o' }}"></i>
                                @endfor
                                <span class="ml-2 text-gray-600 text-sm">({{ $product->valutazione }}/5)</span>
                            </div>
                        </div>
                        @endif
                        @if($product->allergeni)
                        <div class="bg-gray-50 p-4 rounded-lg sm:col-span-2">
                            <h4 class="font-bold text-gray-600 mb-2 text-sm uppercase tracking-wider">Allergeni</h4>
                            <ul class="flex flex-wrap gap-2">
                                @foreach($product->allergeni as $allergene)
                                    <li class="bg-white px-3 py-1 rounded-full text-sm shadow-sm border border-gray-100">{{ $allergene }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    <!-- Add to Cart Button -->
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline" onsubmit="handleAddToCart(event)">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button
                            type="submit"
                            class="cursor-pointer w-full bg-molisana-orange text-white px-6 py-3 rounded-lg text-lg font-bold hover:bg-molisana-orange-hover transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-molisana-blue flex items-center justify-center"
                            aria-label="Aggiungi {{ $product->nome }} al carrello"
                        >
                            <i class="fas fa-shopping-cart mr-3" aria-hidden="true"></i>
                            Aggiungi al carrello
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8">Prodotti correlati</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <article class="group bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 hover:shadow-lg">
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col space-y-1 z-10">
                            @if($related->in_offerta)
                                <span class="bg-molisana-orange text-white px-2 py-0.5 rounded-full text-xs font-bold">
                                    -{{ $related->sconto_percentuale }}%
                                </span>
                            @endif
                            @if($related->novita)
                                <span class="bg-molisana-green text-white px-2 py-0.5 rounded-full text-xs font-bold">
                                    NOVITÀ
                                </span>
                            @endif
                        </div>

                        <!-- Product Image -->
                        <figure class="relative pb-[100%] overflow-hidden">
                            <a href="{{ route('singleproduct', $related->slug) }}">
                                <img
                                    src="{{ Vite::asset('resources/img/products/' . $related->src_img) }}"
                                    alt="{{ $related->img_alt ?? $related->nome }}"
                                    class="absolute h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    loading="lazy"
                                    width="300"
                                    height="300"
                                >
                            </a>
                        </figure>

                        <!-- Product Details -->
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-molisana-dark-orange mb-1 truncate">
                                <a href="{{ route('singleproduct', $related->slug) }}" class="hover:underline">
                                    {{ $related->nome }}
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-3">{{ $related->tipo_formattato }}</p>

                            <div class="flex items-center justify-between">
                                <div>
                                    @if($related->in_offerta)
                                        <span class="text-gray-400 line-through text-sm mr-2">{{ $related->prezzo_formattato }}</span>
                                        <span class="text-lg font-bold text-molisana-orange">{{ $related->prezzo_offerta_formattato }}</span>
                                    @else
                                        <span class="text-lg font-bold text-molisana-blue">{{ $related->prezzo_formattato }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('singleproduct', $related->slug) }}" class="text-molisana-blue hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @include('components.cart_popup')
</div>
<script>
    // Gestione aggiunta al carrello con popup
    function handleAddToCart(event) {
        event.preventDefault();
        const form = event.target;
        const button = form.querySelector('button[type="submit"]');
        const buttonText = button.innerHTML;

        // Disabilita il bottone durante la richiesta
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Aggiungendo...';

        // Invia la richiesta AJAX
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(new FormData(form))
        })
        .then(response => {
            if (response.ok) {
                showCartPopup();
                updateCartCounter();
            } else {
                throw new Error('Errore durante l\'aggiunta al carrello');
            }
        })
        .catch(error => {
            alert(error.message);
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = buttonText;
        });
    }

    // Mostra il popup del carrello
    function showCartPopup() {
        const popup = document.getElementById('cart-popup');
        const content = document.getElementById('popup-content');

        popup.classList.remove('hidden');
        setTimeout(() => {
            popup.classList.add('opacity-100');
            content.classList.add('opacity-100', 'translate-y-0');
        }, 10);
    }

    // Chiudi il popup del carrello
    function closeCartPopup() {
        const popup = document.getElementById('cart-popup');
        const content = document.getElementById('popup-content');

        content.classList.remove('opacity-100', 'translate-y-0');
        popup.classList.remove('opacity-100');
        setTimeout(() => {
            popup.classList.add('hidden');
        }, 300);
    }

    // Aggiorna il contatore del carrello
    function updateCartCounter() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const counter = document.getElementById('cart-counter');
                if (counter) {
                    counter.textContent = data.count;
                    counter.classList.toggle('hidden', data.count === 0);
                }
            });
    }

    // Chiudi il popup premendo ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCartPopup();
        }
    });
</script>
@endsection
