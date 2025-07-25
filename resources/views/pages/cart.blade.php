@extends('layouts.app')

@section('page-title', 'Il Tuo Carrello - La Molisana')

@section('content')
<div class="bg-neutral-50">
    <!-- Hero Section -->
    <section class="bg-molisana-blue text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Il Tuo Carrello</h1>
            <p class="text-lg">Rivedi i tuoi prodotti prima del checkout</p>
        </div>
    </section>

    <!-- PayPal errors -->
    @if(session('paypal_error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 w-[80%] mx-auto my-6 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Errore PayPal</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p>{{ session('paypal_error') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Cart Content -->
    <main class="container mx-auto px-4 py-4 min-h-[50vh]">
        @if($cartItems->isEmpty())
            <!-- Empty Cart -->
            <div class="max-w-md mx-auto text-center py-12">
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
        @else
            <!-- Cart with Items -->
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

                        <!-- Cart Items List -->
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                            <div class="grid grid-cols-12 p-4 items-center">
                                <!-- Product Image & Name -->
                                <div class="col-span-6 md:col-span-5 flex items-center">
                                    <img src="{{ Vite::asset('resources/img/products/' . $item->product->src_img) }}"
                                         alt="{{ $item->product->img_alt }}"
                                         class="w-20 h-20 object-cover rounded-md mr-4">
                                    <div>
                                        <h3 class="font-medium text-molisana-blue">{{ $item->product->nome }}</h3>
                                        <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm text-red-500 hover:text-red-700 mt-1">
                                                Rimuovi
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-span-3 md:col-span-2 text-center text-gray-700">
                                    € {{ number_format($item->price, 2, ',', '.') }}
                                </div>

                                <!-- Quantity -->
                                <div class="col-span-3 md:col-span-3 flex justify-center">
                                    <form action="{{ route('cart.update', $item->product) }}" method="POST" class="flex items-center border border-gray-300 rounded-md">
                                        @csrf
                                        <button
                                            type="button"
                                            onclick="updateQuantity(this.nextElementSibling, -1)"
                                            class="px-3 py-1 text-gray-600 hover:bg-gray-100"
                                        >
                                            -
                                        </button>
                                        <input type="number"
                                               name="quantity"
                                               value="{{ $item->quantity }}"
                                               min="1"
                                               class="w-12 text-center border-0 focus:ring-0"
                                               onchange="this.form.submit()">
                                        <button
                                            type="button"
                                            onclick="updateQuantity(this.previousElementSibling, 1)"
                                            class="px-3 py-1 text-gray-600 hover:bg-gray-100"
                                        >
                                            +
                                        </button>
                                    </form>
                                </div>

                                <!-- Total -->
                                <div class="col-span-3 md:col-span-2 text-center font-semibold text-molisana-dark-orange">
                                    € {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    <div class="mt-6 bg-white rounded-lg shadow-md p-6" id="coupon-section">
                        <h3 class="text-lg font-semibold text-molisana-blue mb-3">Hai un codice sconto?</h3>

                        <div id="coupon-message" class="mb-3 hidden"></div>

                        <div id="coupon-applied" class="@if(!session('coupon')) hidden @endif">
                            <div class="flex justify-between items-center bg-green-50 p-3 rounded-md mb-3">
                                <div>
                                    <span class="font-medium">{{ session('coupon')->code ?? '' }}</span>
                                    <span class="text-green-600 ml-2" id="coupon-discount">
                                        @if(session('coupon'))-€{{ number_format($discount, 2, ',', '.') }}@endif
                                    </span>
                                </div>
                                <button id="remove-coupon" class="text-red-500 hover:text-red-700 text-sm">
                                    Rimuovi
                                </button>
                            </div>
                        </div>
                        <form id="apply-coupon-form" action="{{ route('coupon.apply') }}" method="POST" class="@if(session('coupon')) hidden @endif">
                            @csrf
                            <div class="flex">
                                <input type="text"
                                    name="code"
                                    id="coupon-code"
                                    placeholder="Inserisci codice"
                                    class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:ring-2 focus:ring-molisana-orange focus:border-transparent"
                                    pattern="[A-Z0-9]+"
                                    title="Solo lettere maiuscole e numeri"
                                    value="{{ old('code') }}"
                                    required>
                                <button type="submit"
                                        class="bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-2 rounded-r-md transition-colors">
                                    Applica
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-bold text-molisana-dark-orange mb-4">Riepilogo Ordine</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span>Subtotale</span>
                                <span class="order-subtotal">€ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Spedizione</span>
                                <span class="order-shipping">€ {{ number_format($shipping, 2, ',', '.') }}</span>
                            </div>
                            @if($discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Sconto</span>
                                <span class="order-discount">-€ {{ number_format($discount, 2, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="border-t border-gray-200 pt-3 mt-3 flex justify-between font-bold text-lg text-molisana-blue">
                                <span>Totale</span>
                                <span class="order-total">€ {{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Checkout senza pagamento per prove sviluppo --}}
                        {{-- <a href="{{ route('checkout') }}"
                        class="block w-full bg-molisana-orange hover:bg-molisana-orange-hover text-white font-bold py-3 px-4 rounded-md transition-colors mb-4 text-center {{ $cartItems->isEmpty() ? 'opacity-50 cursor-not-allowed' : '' }}"
                        @if($cartItems->isEmpty()) disabled @endif>
                            Procedi al Checkout
                        </a> --}}

                        <div class="space-y-4 mb-3">
                            <!-- Bottone PayPal -->
                            <form action="{{ route('checkout.paypal') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="cursor-pointer w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition-colors flex items-center justify-center {{ $cartItems->isEmpty() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        @if($cartItems->isEmpty()) disabled @endif>
                                    <i class="fab fa-paypal mr-2 text-xl"></i> Paga con PayPal
                                </button>
                            </form>

                            <!-- Oppure mantieni anche il checkout normale -->
                            <a href="{{ route('checkout') }}"
                            class="block w-full bg-molisana-orange hover:bg-molisana-orange-hover text-white font-bold py-3 px-4 rounded-md transition-colors text-center {{ $cartItems->isEmpty() ? 'opacity-50 cursor-not-allowed' : '' }}"
                            @if($cartItems->isEmpty()) disabled @endif>
                                Altri metodi di pagamento
                            </a>
                        </div>


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
        @endif
    </main>
</div>

<script>
    // Funzione per aggiornare la quantità
    function updateQuantity(input, change) {
        const newValue = parseInt(input.value) + change;
        if (newValue >= 1) {
            input.value = newValue;
            input.dispatchEvent(new Event('change'));
        }
    }

    // Gestione submit dei form
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButtons = this.querySelectorAll('button[type="submit"]');
            submitButtons.forEach(btn => {
                btn.disabled = true;
                btn.innerHTML = btn.innerHTML.includes('fa-spinner')
                    ? btn.innerHTML
                    : '<i class="fas fa-spinner fa-spin mr-2"></i>' + btn.textContent;
            });
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ottieni il token CSRF in modo sicuro
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // Setup event listeners
    setupCouponEvents();

    function setupCouponEvents() {
        // Applica coupon
        const applyForm = document.getElementById('apply-coupon-form');
        if (applyForm) {
            applyForm.addEventListener('submit', function(e) {
                e.preventDefault();
                handleCouponApply(e.target);
            });
        }

        // Rimuovi coupon
        const removeBtn = document.getElementById('remove-coupon');
        if (removeBtn) {
            removeBtn.addEventListener('click', handleCouponRemove);
        }
    }

    async function handleCouponApply(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const messageEl = document.getElementById('coupon-message');
        const couponCode = form.querySelector('input[name="code"]').value;

        // Mostra stato di caricamento
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Applica';
        messageEl.classList.remove('hidden');
        messageEl.textContent = 'Elaborazione in corso...';
        messageEl.className = 'mb-3 p-2 bg-blue-100 text-blue-700 rounded text-sm';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    code: couponCode
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Errore nella richiesta');
            }

            if (data.success) {
                // Aggiorna UI
                document.getElementById('coupon-applied').classList.remove('hidden');
                form.classList.add('hidden');

                // Aggiorna i valori del coupon
                const couponCodeEl = document.querySelector('#coupon-applied .font-medium');
                const couponDiscountEl = document.getElementById('coupon-discount');

                if (couponCodeEl) couponCodeEl.textContent = data.coupon.code;
                if (couponDiscountEl) couponDiscountEl.textContent = `-€${data.discount.toFixed(2).replace('.', ',')}`;

                // Mostra messaggio di successo
                messageEl.textContent = data.message;
                messageEl.className = 'mb-3 p-2 bg-green-100 text-green-700 rounded text-sm';

                // Aggiorna i totali
                updateOrderTotals(data.totals);

                // Ricarica la pagina dopo 1 secondo per assicurarsi che tutto sia aggiornato
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } catch (error) {
            // Mostra messaggio di errore
            messageEl.textContent = error.message;
            messageEl.className = 'mb-3 p-2 bg-red-100 text-red-700 rounded text-sm';
        } finally {
            // Ripristina il pulsante
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Applica';
            }
        }
    }

    async function handleCouponRemove() {
        const messageEl = document.getElementById('coupon-message');
        const removeBtn = document.getElementById('remove-coupon');

        // Mostra stato di caricamento
        removeBtn.disabled = true;
        removeBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Rimuovi';
        messageEl.classList.remove('hidden');
        messageEl.textContent = 'Rimozione in corso...';
        messageEl.className = 'mb-3 p-2 bg-blue-100 text-blue-700 rounded text-sm';

        try {
            const response = await fetch("{{ route('coupon.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Errore nella richiesta');
            }

            if (data.success) {
                // Nascondi la sezione coupon applicato
                document.getElementById('coupon-applied').classList.add('hidden');
                // Mostra il form di applicazione
                document.getElementById('apply-coupon-form').classList.remove('hidden');

                // Mostra messaggio di successo
                messageEl.textContent = data.message;
                messageEl.className = 'mb-3 p-2 bg-green-100 text-green-700 rounded text-sm';

                // Aggiorna i totali
                updateOrderTotals(data.totals);

                // Ricarica la pagina dopo 1 secondo
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } catch (error) {
            // Mostra messaggio di errore
            messageEl.textContent = error.message || 'Errore durante la rimozione del coupon';
            messageEl.className = 'mb-3 p-2 bg-red-100 text-red-700 rounded text-sm';
        } finally {
            // Ripristina il pulsante
            if (removeBtn) {
                removeBtn.disabled = false;
                removeBtn.innerHTML = 'Rimuovi';
            }
        }
    }

    function updateOrderTotals(totals) {
        // Ensure totals is defined and has all required properties
        if (!totals) return;

        // Helper function to safely format numbers
        const formatCurrency = (value) => {
            if (value === undefined || value === null) return '€ 0,00';
            return `€ ${value.toFixed(2).replace('.', ',')}`;
        };

        // Update all values in the order summary
        const subtotalEl = document.querySelector('.order-subtotal');
        const shippingEl = document.querySelector('.order-shipping');
        const discountEl = document.querySelector('.order-discount');
        const totalEl = document.querySelector('.order-total');
        const discountContainer = discountEl ? discountEl.parentElement : null;

        if (subtotalEl) subtotalEl.textContent = formatCurrency(totals.subtotal);
        if (shippingEl) shippingEl.textContent = formatCurrency(totals.shipping);

        if (discountEl && discountContainer) {
            if (totals.discount > 0) {
                discountEl.textContent = `-${formatCurrency(totals.discount)}`;
                discountContainer.style.display = 'flex';
            } else {
                discountContainer.style.display = 'none';
            }
        }

        if (totalEl) totalEl.textContent = formatCurrency(totals.total);
    }
});
</script>
@endsection
