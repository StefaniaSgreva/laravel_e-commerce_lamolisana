@extends('layouts.app')

@section('page-title', 'Tutti i prodotti - La Molisana')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Scopri tutti i prodotti</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Scopri la pasta La Molisana: tipi e formati di pasta da grano 100% italiano decorticato e trafilata al bronzo.
            </p>
        </div>
    </section>

     <!-- Content Sections -->
    <div class="container mx-auto px-4 py-12">
        <!-- Cards - Products-->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($products as $product)
                <article class="group bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <figure class="relative pb-[100%] overflow-hidden">
                        <img
                            src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                            alt="{{ $product->nome }} - Pasta La Molisana"
                            class="absolute h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                            width="400"
                            height="400"
                        >
                        @if($product->in_offerta)
                            <span class="absolute top-4 right-4 bg-molisana-blue text-white px-3 py-1 rounded-full text-sm font-bold">
                                OFFERTA
                            </span>
                        @endif
                    </figure>
                    <div class="p-6 flex flex-col h-full">
                        <div>
                            <h3 class="text-xl text-center font-bold text-molisana-dark-orange mb-2">{{ $product->nome }}</h3>

                            <div class="text-center my-4">
                                @if($product->in_offerta)
                                    <span class="text-gray-400 line-through mr-2">{{ $product->prezzo_formattato }}</span>
                                    <span class="text-xl font-bold text-molisana-orange">{{ $product->prezzo_offerta_formattato }}</span>
                                @else
                                    <span class="text-xl font-bold text-molisana-blue">{{ $product->prezzo_formattato }}</span>
                                @endif
                            </div>

                            @if($product->tempo_cottura)
                                <p class="text-gray-600 text-center mb-4">
                                    <i class="fas fa-clock mr-2"></i>
                                    Cottura: {{ $product->tempo_cottura }}
                                </p>
                            @endif

                            <div class="flex justify-between items-center mt-4">
                                <a href="{{route('singleproduct', [$product->id])}}"
                                class="text-molisana-blue font-semibold hover:underline focus:outline-none focus:ring-2 focus:ring-molisana-orange focus:ring-offset-2 rounded">
                                    Scopri di più
                                    <span class="sr-only">: {{ $product->nome }}</span>
                                </a>
                                <button
                                    class="cursor-pointer bg-molisana-orange text-white px-4 py-2 rounded-full text-sm font-bold hover:bg-molisana-orange-hover transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-molisana-blue"
                                    aria-label="Aggiungi {{ $product->nome }} al carrello"
                                >
                                    <i class="fas fa-shopping-cart mr-2" aria-hidden="true"></i>
                                    Acquista
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
                    <h2 class="text-2xl font-bold text-gray-700">Nessun prodotto disponibile al momento</h2>
                    <p class="text-gray-500 mt-2">Tornate a trovarci presto!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Paginazione -->
    <div class="containe mx-auto px-6 py-12">
        {{ $products->links('components.pagination') }}
    </div>
</div>
@endsection
