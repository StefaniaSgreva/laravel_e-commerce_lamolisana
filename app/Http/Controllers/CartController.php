<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    // Inietta il CartService nel controller
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Mostra il contenuto del carrello
     */
    public function index()
    {
        $cartItems = $this->cartService->getCart();
        $total = $this->cartService->getTotal();

        return view('pages.cart', compact('cartItems', 'total'));
    }

    /**
     * Aggiunge un prodotto al carrello
     */
    public function add(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $quantity = $request->input('quantity', 1);
        $this->cartService->addToCart($product, $quantity);

        return redirect()
            ->back()
            ->with('success', 'Prodotto aggiunto al carrello!');
    }

    /**
     * Rimuove un prodotto dal carrello
     */
    public function remove(Product $product)
    {
        $this->cartService->removeFromCart($product);

        return redirect()
            ->back()
            ->with('success', 'Prodotto rimosso dal carrello');
    }

    /**
     * Aggiorna la quantità di un prodotto
     */
    public function update(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $this->cartService->updateQuantity($product, $request->quantity);

        return back()->with('success', 'Quantità aggiornata');
    }

    /**
     * Svuota il carrello
     */
    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()
            ->back()
            ->with('success', 'Carrello svuotato');
    }
}
