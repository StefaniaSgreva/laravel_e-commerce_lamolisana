@extends('layouts.app')

@section('page-title', 'Tutti i prodotti - La Molisana')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-16 mb-6 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Scopri tutti i prodotti</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Scopri la pasta La Molisana: tipi e formati di pasta da grano 100% italiano decorticato e trafilata al bronzo.
            </p>
        </div>
    </section>

    <!-- Filter Section -->
    <div class="container mx-auto px-4 py-6">
        <form action="{{ route('products') }}" method="GET" class="space-y-4">
            <!-- Search Bar - Full Width -->
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" id="search"
                    value="{{ request('search') }}"
                    class="block w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-molisana-orange focus:border-transparent placeholder-gray-400 transition duration-150"
                    placeholder="Cerca pasta, formati, offerte...">
            </div>

            <!-- Filter Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Tipo Select -->
                <div class="relative">
                    <label for="tipo" class="sr-only">Tipi</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <select name="tipo" id="tipo" class="block w-full pl-10 pr-8 py-2.5 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-molisana-orange focus:border-transparent appearance-none cursor-pointer">
                        <option value="">Tutti i tipi</option>
                        @foreach($tipiPasta as $tipo)
                            <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                {{ match($tipo) {
                                    'lunga' => 'Pasta Lunga',
                                    'corta' => 'Pasta Corta',
                                    'speciale' => 'Speciali',
                                    'gluten-free' => 'Senza Glutine',
                                    default => ucfirst($tipo)
                                } }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Order Select - Stile coerente con Tipi -->
                <div class="relative">
                    <label for="order_by" class="sr-only">Ordina</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zm0 4a1 1 0 000 2h7a1 1 0 100-2H3zm0 4a1 1 0 100 2h4a1 1 0 100-2H3z" />
                        </svg>
                    </div>
                    <select name="order_by" id="order_by" class="block w-full pl-10 pr-8 py-2.5 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-molisana-orange focus:border-transparent appearance-none cursor-pointer">
                        <option value="recenti" {{ request('order_by', 'recenti') == 'recenti' ? 'selected' : '' }}>Più recenti</option>
                        <option value="prezzo_crescente" {{ request('order_by') == 'prezzo_crescente' ? 'selected' : '' }}>Prezzo: basso → alto</option>
                        <option value="prezzo_decrescente" {{ request('order_by') == 'prezzo_decrescente' ? 'selected' : '' }}>Prezzo: alto → basso</option>
                        <option value="migliori" {{ request('order_by') == 'migliori' ? 'selected' : '' }}>Migliori valutati</option>
                        <option value="piu_venduti" {{ request('order_by') == 'piu_venduti' ? 'selected' : '' }}>Più venduti</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Checkbox Group - Con colori Molisana corretti -->
                <div class="flex items-center justify-center space-x-4 bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="offerta"
                            class="h-5 w-5 rounded border-gray-300 text-molisana-orange focus:ring-molisana-orange transition duration-150"
                            {{ request('offerta') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-medium text-gray-700">Offerte</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="checkbox" name="novita"
                            class="h-5 w-5 rounded border-gray-300 text-molisana-dark-orange focus:ring-molisana-dark-orange transition duration-150"
                            {{ request('novita') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-medium text-gray-700">Novità</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-molisana-orange text-white px-4 py-2.5 rounded-lg font-medium hover:bg-molisana-orange-hover transition duration-150 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Applica
                    </button>

                    <a href="{{ route('products') }}" class="flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Resetta
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Content Sections -->
    <div class="container mx-auto px-4 py-12">
        <!-- Cards - Products-->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($products as $product)
                <article class="group bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col space-y-2 z-10">
                        @if($product->in_offerta)
                            <span class="bg-molisana-orange text-white px-3 py-1 rounded-full text-sm font-bold">
                                OFFERTA -{{ $product->sconto_percentuale }}%
                            </span>
                        @endif
                        @if($product->novita)
                            <span class="bg-molisana-blue text-white px-3 py-1 rounded-full text-sm font-bold">
                                NOVITÀ
                            </span>
                        @endif
                    </div>

                    <!-- Product Image -->
                    <figure class="relative pb-[100%] overflow-hidden">
                        <img
                            src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                            alt="{{ $product->img_alt ?? $product->nome }}"
                            class="absolute h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                            width="400"
                            height="400"
                        >
                    </figure>

                    <!-- Product Details -->
                    <div class="p-6 flex flex-col h-full">
                        <div>
                            <!-- Product Name and Type -->
                            <h3 class="text-xl text-center font-bold text-molisana-dark-orange mb-2">
                                {{ $product->nome }}
                            </h3>
                            <p class="text-center text-gray-500 text-sm mb-4">
                                {{ $product->tipo_formattato }}
                            </p>

                            <!-- Price -->
                            <div class="text-center my-4">
                                @if($product->in_offerta)
                                    <span class="text-gray-400 line-through mr-2">{{ $product->prezzo_formattato }}</span>
                                    <span class="text-xl font-bold text-molisana-orange">{{ $product->prezzo_offerta_formattato }}</span>
                                @else
                                    <span class="text-xl font-bold text-molisana-blue">{{ $product->prezzo_formattato }}</span>
                                @endif
                                <span class="block text-sm text-gray-500 mt-1">{{ $product->peso_formattato }}</span>
                            </div>

                            <!-- Cooking Time and Rating -->
                            <div class="flex justify-center space-x-6 mb-4">
                                @if($product->tempo_cottura)
                                    <div class="text-gray-600 text-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $product->tempo_cottura_formattato }}
                                    </div>
                                @endif
                                @if($product->valutazione)
                                    <div class="text-yellow-400">
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="fas {{ $i < $product->valutazione ? 'fa-star' : 'fa-star-o' }}"></i>
                                        @endfor
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-between items-center mt-4">
                                <a href="{{ route('singleproduct', $product->slug) }}"
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
                    <h2 class="text-2xl font-bold text-gray-700">Nessun prodotto trovato</h2>
                    <p class="text-gray-500 mt-2">Prova a modificare i filtri di ricerca</p>
                    <a href="{{ route('products') }}" class="mt-4 inline-block bg-molisana-blue text-white px-6 py-2 rounded-md font-medium hover:bg-blue-700 transition-colors">
                        Mostra tutti i prodotti
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Paginazione -->
    <div class="container mx-auto px-6 py-12">
        {{ $products->appends(request()->query())->links('components.pagination') }}
    </div>
</div>
@endsection
