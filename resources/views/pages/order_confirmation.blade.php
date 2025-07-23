@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-green-600 mb-4">Ordine Confermato!</h1>

        <div class="mb-6">
            <p class="font-semibold">Codice ordine: <span class="text-blue-600">{{ $order->order_code }}</span></p>
            <p>Grazie <strong>{{ $order->customer_data['nome'] }}</strong>!</p>
        </div>

        <div class="border-t pt-4">
            <h2 class="text-lg font-bold mb-2">Riepilogo ordine:</h2>
            @foreach($order->cart_data as $item)
                <div class="flex justify-between py-2">
                    <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                    <span>€{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                </div>
            @endforeach
            <div class="font-bold border-t mt-2 pt-2">
                Totale: €{{ number_format($order->total, 2) }}
            </div>
        </div>
    </div>
</div>
@endsection
