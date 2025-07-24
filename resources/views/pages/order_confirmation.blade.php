@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-green-600 mb-4">Ordine Confermato!</h1>

        <div class="mb-6">
            <p class="font-semibold">Codice ordine: <span class="text-blue-600">{{ $order->order_code ?? 'N/A' }}</span></p>
            <p>Grazie <strong>{{ $order->customer_data['nome'] ?? 'Cliente' }}</strong>!</p>
        </div>

        <div class="border-t pt-4">
            <h2 class="text-lg font-bold mb-2">Riepilogo ordine:</h2>

            @forelse($order->cart_data ?? [] as $item)
                <div class="flex justify-between py-2">
                    <span>{{ $item['name'] ?? 'Prodotto' }} (x{{ $item['quantity'] ?? 1 }})</span>
                    <span>€{{ isset($item['price'], $item['quantity']) ? number_format($item['price'] * $item['quantity'], 2, ',', '.') : '0,00' }}</span>
                </div>
            @empty
                <p class="text-gray-500">Nessun prodotto nell'ordine</p>
            @endforelse

            <div class="space-y-2 mt-4 border-t pt-4">
                <!-- Subtotal -->
                <div class="flex justify-between">
                    <span>Subtotale:</span>
                    <span>€{{ isset($order->subtotal) ? number_format($order->subtotal, 2, ',', '.') : '0,00' }}</span>
                </div>

                <!-- Discount -->
                @if(!empty($order->coupon_code) && !empty($order->discount_amount))
                <div class="flex justify-between text-green-600">
                    <span>Sconto ({{ $order->coupon_code }}):</span>
                    <span>-€{{ number_format($order->discount_amount, 2, ',', '.') }}</span>
                </div>
                @endif

                <!-- Shipping -->
                <div class="flex justify-between">
                    <span>Spedizione:</span>
                    <span>€{{ isset($order->shipping) ? number_format($order->shipping, 2, ',', '.') : '0,00' }}</span>
                </div>

                <!-- Total -->
                <div class="flex justify-between font-bold text-lg border-t pt-2 mt-2">
                    <span>Totale:</span>
                    <span>€{{ isset($order->total) ? number_format($order->total, 2, ',', '.') : '0,00' }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Details -->
        <div class="mt-6 pt-4 border-t">
            <h2 class="text-lg font-bold mb-2">Dettagli spedizione:</h2>
            <p><strong>Indirizzo:</strong> {{ $order->customer_data['indirizzo'] ?? 'Non specificato' }}</p>
            <p><strong>Email:</strong> {{ $order->customer_data['email'] ?? 'Non specificato' }}</p>
            @if(!empty($order->customer_data['telefono']))
                <p><strong>Telefono:</strong> {{ $order->customer_data['telefono'] }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
