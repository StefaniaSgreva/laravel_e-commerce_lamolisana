<?php

// app/Http/Controllers/CheckoutController.php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(CartService $cartService)
    {
        // Verifica carrello non vuoto
        if ($cartService->isEmpty()) {
            return redirect()->route('carrello')->with('error', 'Il carrello è vuoto');
        }

        return view('pages.checkout', [
            'cartItems' => $cartService->getCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    public function store(Request $request, CartService $cartService)
    {
        $validated = $request->validate([
            'cliente.nome' => 'required|string|max:255',
            'cliente.email' => 'required|email',
            'cliente.indirizzo' => 'required|string|max:500',
            'cliente.telefono' => 'nullable|string|max:20',
            'note' => 'nullable|string|max:1000'
        ]);

        // Prepara i dati del carrello
        $cartItems = $cartService->getCart()->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product->nome,
                'price' => $item->price,
                'quantity' => $item->quantity,
                // 'img_url' => $item->product->src_img // Opzionale
            ];
        });

        // Crea l'ordine
        $order = Order::createFromCart($cartService, [
            'cliente' => [
                'nome' => $request->input('cliente.nome'),
                'email' => $request->input('cliente.email'),
                'indirizzo' => $request->input('cliente.indirizzo'),
                'telefono' => $request->input('cliente.telefono')
            ],
            'note' => $request->input('note')
        ]);

        // Svuota il carrello
        $cartService->clearCart();

        return redirect()->route('pages.order_confirmation', $order->order_code);
    }
}
