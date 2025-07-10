@extends('layouts.app')

@section('page-title', 'Il Tuo Carrello - La Molisana')

@section('content')
<div class="min-h-screen bg-neutral-50">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Il Tuo Carrello</h1>
            <p class="text-lg">Rivedi i tuoi prodotti prima del checkout</p>
        </div>
    </section>

    <!-- Cart Content -->
    <div class="container mx-auto px-4 py-12">
        <!-- Cart with Items (visible when cart not empty) -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Cart Header -->
                    <div class="hidden md:grid grid-cols-12 bg-gray-100 p-4 font-semibold text-molisana-blue">
                        <div class="col-span-5">Prodotto</div>
                        <div class="col-span-2 text-center">Prezzo</div>
                        <div class="col-span-3 text-center">Quantità</div>
                        <div class="col-span-2 text-center">Totale</div>
                    </div>

                    <!-- Cart Items List - Example with 2 products -->
                    <div class="divide-y divide-gray-200">
                        <!-- Product 1 -->
                        <div class="grid grid-cols-12 p-4 items-center">
                            <!-- Product Image & Name -->
                            <div class="col-span-6 md:col-span-5 flex items-center">
                                <img src="https://www.lamolisana.it/wp-content/uploads/2021/09/4-spaghetto-quadrato-bucato.png"
                                     alt="Spaghetto Quadrato Bucato"
                                     class="w-20 h-20 object-cover rounded-md mr-4">
                                <div>
                                    <h3 class="font-medium text-molisana-blue">Spaghetto Quadrato Bucato n.4</h3>
                                    <button class="text-sm text-red-500 hover:text-red-700 mt-1">
                                        Rimuovi
                                    </button>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-span-3 md:col-span-2 text-center text-gray-700">
                                1,90 €
                            </div>

                            <!-- Quantity -->
                            <div class="col-span-3 md:col-span-3 flex justify-center">
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                        -
                                    </button>
                                    <span class="px-3 py-1">2</span>
                                    <button class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                        +
                                    </button>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="col-span-3 md:col-span-2 text-center font-semibold text-molisana-dark-orange">
                                3,80 €
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="grid grid-cols-12 p-4 items-center">
                            <div class="col-span-6 md:col-span-5 flex items-center">
                                <img src="https://www.lamolisana.it/wp-content/uploads/2021/09/1-paccheri.png"
                                     alt="Paccheri"
                                     class="w-20 h-20 object-cover rounded-md mr-4">
                                <div>
                                    <h3 class="font-medium text-molisana-blue">Paccheri n.1</h3>
                                    <button class="text-sm text-red-500 hover:text-red-700 mt-1">
                                        Rimuovi
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-3 md:col-span-2 text-center text-gray-700">
                                2,10 €
                            </div>
                            <div class="col-span-3 md:col-span-3 flex justify-center">
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                        -
                                    </button>
                                    <span class="px-3 py-1">1</span>
                                    <button class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                        +
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-3 md:col-span-2 text-center font-semibold text-molisana-dark-orange">
                                2,10 €
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coupon Code -->
                <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-molisana-blue mb-3">Hai un codice sconto?</h3>
                    <div class="flex">
                        <input type="text"
                               placeholder="Inserisci codice"
                               class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:ring-2 focus:ring-molisana-orange focus:border-transparent">
                        <button class="bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-2 rounded-r-md transition-colors">
                            Applica
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-molisana-dark-orange mb-4">Riepilogo Ordine</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span>Subtotale</span>
                            <span>5,90 €</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Spedizione</span>
                            <span>5,00 €</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 mt-3 flex justify-between font-bold text-lg text-molisana-blue">
                            <span>Totale</span>
                            <span>10,90 €</span>
                        </div>
                    </div>

                    <button class="w-full bg-molisana-orange hover:bg-molisana-orange-hover text-white font-bold py-3 px-4 rounded-md transition-colors mb-4">
                        Procedi al Checkout
                    </button>

                    <div class="text-sm text-gray-500">
                        <p class="mb-2">Spedizione stimata: 2-3 giorni lavorativi</p>
                        <p>Pagamenti sicuri con:</p>
                        <div class="flex mt-2 space-x-4">
                            <i class="fab fa-cc-visa text-2xl text-gray-400"></i>
                            <i class="fab fa-cc-mastercard text-2xl text-gray-400"></i>
                            <i class="fab fa-cc-paypal text-2xl text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty Cart (hidden by default, shown via backend logic when cart is empty) -->
        <div class="text-center py-12 hidden">
            <div class="mx-auto w-24 h-24 text-molisana-orange mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-molisana-blue mb-2">Il tuo carrello è vuoto</h2>
            <p class="text-gray-600 mb-6">Sembra che tu non abbia ancora aggiunto prodotti al carrello</p>
            <a href="{{ route('products') }}"
               class="inline-block bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-3 rounded-md font-medium transition-colors">
                Scopri i nostri prodotti
            </a>
        </div>
    </div>
</div>
@endsection
