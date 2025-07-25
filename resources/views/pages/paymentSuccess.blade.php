@extends('layouts.app')

@section('page-title', 'Pagamento Completato - La Molisana')

@section('content')
<div class="bg-neutral-50 min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Pagamento Completato!</h1>
            <p class="text-lg">Grazie per il tuo ordine</p>
        </div>
    </section>

    <!-- Success Message -->
    <main class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-molisana-blue mb-4">Il tuo pagamento è stato confermato</h2>
            <p class="text-gray-600 mb-6">
                Abbiamo ricevuto il tuo ordine e stiamo preparando la spedizione.
                Riceverai una email di conferma con i dettagli.
            </p>

            <div class="bg-gray-50 p-4 rounded-md mb-6 text-left">
                <h3 class="font-semibold text-molisana-blue mb-2">Dettagli ordine:</h3>
                <p><strong>Metodo di pagamento:</strong> PayPal</p>
                <p><strong>ID Transazione:</strong> {{ request()->input('paymentId') ?? 'N/A' }}</p>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                {{-- <a href="{{ route('orders') }}"
                   class="bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-3 rounded-md font-medium transition-colors">
                    Vai ai tuoi ordini
                </a> --}}
                <a href="{{ route('home') }}"
                   class="border border-molisana-blue text-molisana-blue hover:bg-molisana-blue hover:text-white px-6 py-3 rounded-md font-medium transition-colors">
                    Torna alla home
                </a>
            </div>
        </div>
    </main>
</div>
@endsection
