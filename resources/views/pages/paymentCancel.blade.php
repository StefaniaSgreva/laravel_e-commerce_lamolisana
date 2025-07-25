@extends('layouts.app')

@section('page-title', 'Pagamento Annullato - La Molisana')

@section('content')
<div class="bg-neutral-50 min-h-screen">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Pagamento Annullato</h1>
            <p class="text-lg">Non hai completato il pagamento</p>
        </div>
    </section>

    <!-- Error Message -->
    <main class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-molisana-blue mb-4">Pagamento non completato</h2>
            <p class="text-gray-600 mb-6">
                Il pagamento via PayPal è stato annullato.
                Il tuo carrello è ancora disponibile per il checkout.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('cart') }}"
                   class="bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-3 rounded-md font-medium transition-colors">
                    Torna al carrello
                </a>
                <a href="{{ route('home') }}"
                   class="border border-molisana-blue text-molisana-blue hover:bg-molisana-blue hover:text-white px-6 py-3 rounded-md font-medium transition-colors">
                    Torna alla home
                </a>
            </div>
        </div>
    </main>
</div>
@endsection
