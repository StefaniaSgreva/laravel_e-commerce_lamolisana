@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Pulsante "Torna al carrello" -->
    <a href="{{ route('cart') }}"
       class="inline-block mb-6 text-molisana-blue hover:underline">
        ← Torna al carrello
    </a>

    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Form Cliente -->
        <div class="md:w-2/3">
            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-xl font-bold mb-4">Informazioni Cliente</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Campi Cliente -->
                        <div class="md:col-span-2">
                            <label class="block mb-1">Nome Completo*</label>
                            <input type="text" name="cliente[nome]" required
                                   class="w-full p-2 border rounded"
                                   value="{{ old('cliente.nome') }}">
                        </div>

                        <div>
                            <label class="block mb-1">Email*</label>
                            <input type="email" name="cliente[email]" required
                                   class="w-full p-2 border rounded"
                                   value="{{ old('cliente.email') }}">
                        </div>

                        <div>
                            <label class="block mb-1">Telefono</label>
                            <input type="text" name="cliente[telefono]"
                                   class="w-full p-2 border rounded"
                                   value="{{ old('cliente.telefono') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-1">Indirizzo di Spedizione*</label>
                            <textarea name="cliente[indirizzo]" required
                                      class="w-full p-2 border rounded">{{ old('cliente.indirizzo') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Note aggiuntive</h2>
                    <textarea name="note" class="w-full p-2 border rounded">{{ old('note') }}</textarea>
                </div>

                <button type="submit"
                        class="cursor-pointer mt-6 bg-molisana-orange hover:bg-molisana-orange-hover text-white px-6 py-3 rounded-lg transition-colors w-full md:w-auto">
                    Completa Ordine
                </button>
            </form>
        </div>

        <!-- Riepilogo Carrello -->
        <div class="md:w-1/3">
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                <h2 class="text-xl font-bold mb-4">Il Tuo Ordine</h2>

                <div class="divide-y">
                    @foreach($cartItems as $item)
                    <div class="py-3 flex justify-between">
                        <div>
                            <p>{{ $item->product->nome }} × {{ $item->quantity }}</p>
                            <p class="text-sm text-gray-500">{{ $item->product->categoria }}</p>
                        </div>
                        <p>€{{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between">
                        <span>Subtotale</span>
                        <span>€{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span>Spedizione</span>
                        <span>€5.00</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg mt-4 pt-2 border-t">
                        <span>Totale</span>
                        <span>€{{ number_format($total + 5, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
