@extends('layouts.app')

@section('page-title', 'Tutti i prodotti - La Molisana')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="mb-12 text-center">
        <h1 class="text-4xl font-bold text-molisana-blue mb-4">Scopri tutti i prodotti</h1>
        <p class="text-xl text-gray-700 max-w-3xl mx-auto">
            Scopri la pasta La Molisana: tipi e formati di pasta da grano 100% italiano decorticato e trafilata al bronzo.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach ($products as $pasta)
            <article class="group bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <figure class="relative pb-[100%] overflow-hidden">
                    <img
                        src="{{ $pasta['src-h'] }}"
                        alt="{{ $pasta['titolo'] }} - Pasta La Molisana"
                        class="absolute h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                        width="400"
                        height="400"
                    >
                </figure>
                <div class="p-6 flex flex-col h-full">
                    <div>
                    <h3 class="text-xl text-center font-bold text-molisana-dark-orange mb-2">{{ $pasta['titolo'] }}</h3>
                    <div class="flex justify-between items-center mt-4">
                        <a href="#"
                        class="text-molisana-blue font-semibold hover:underline focus:outline-none focus:ring-2 focus:ring-molisana-orange focus:ring-offset-2 rounded">
                            Scopri di più
                            <span class="sr-only">: {{ $pasta['titolo'] }}</span>
                        </a>
                        <button
                            class=" cursor-pointer bg-molisana-orange text-white px-4 py-2 rounded-full text-sm font-bold hover:bg-molisana-orange-hover transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-molisana-blue"
                            aria-label="Aggiungi {{ $pasta['titolo'] }} al carrello"
                        >
                            <i class="fas fa-shopping-cart mr-2" aria-hidden="true"></i>
                            Acquista
                        </button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</div>
@endsection
