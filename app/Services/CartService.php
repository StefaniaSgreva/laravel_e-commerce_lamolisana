<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartService
{
    protected $sessionId;

    public function __construct()
    {
        // Genera o recupera un ID sessione per i guest
        $this->sessionId = session()->getId();
    }

    // ================= METODI PRINCIPALI ================= //

    /**
     * Recupera tutti gli elementi del carrello
     */
    public function getCart()
    {
        // if (Auth::check()) {
        //     return Auth::user()->cartItems()->with('product')->get();
        // }

        return CartItem::where('session_id', $this->sessionId)
            ->with('product')
            ->get();
    }

    /**
     * Aggiunge un prodotto al carrello (o incrementa la quantità se già presente)
     */
    public function addToCart(Product $product, int $quantity = 1)
    {
        // Usa il prezzo in offerta se disponibile, altrimenti il prezzo normale
        $price = $product->in_offerta && $product->prezzo_offerta
            ? $product->prezzo_offerta
            : $product->prezzo;

        // Cerca se il prodotto è già nel carrello
        $cartItem = CartItem::updateOrCreate(
            [
                'product_id' => $product->id,
                // 'user_id' => Auth::id(), // Se loggato, usa user_id
                // 'session_id' => Auth::check() ? null : $this->sessionId, // Se guest, usa session_id
                'session_id' => $this->sessionId
            ],
            [
                'quantity' => $quantity,
                'price' => $price, // Blocca il prezzo al momento dell'aggiunta
            ]
        );

        return $cartItem;
    }

    /**
     * Rimuove un prodotto dal carrello
     */
    public function removeFromCart(Product $product)
    {
        // if (Auth::check()) {
        //     return Auth::user()->cartItems()->where('product_id', $product->id)->delete();
        // }

        return CartItem::where('session_id', $this->sessionId)
            ->where('product_id', $product->id)
            ->delete();
    }

    /**
     * Aggiorna la quantità di un prodotto nel carrello
     */
    public function updateQuantity(Product $product, int $quantity)
    {
        // Se la quantità è <= 0, rimuovi l'elemento
        if ($quantity <= 0) {
            return $this->removeFromCart($product);
        }

        // if (Auth::check()) {
        //     return Auth::user()->cartItems()
        //         ->where('product_id', $product->id)
        //         ->update(['quantity' => $quantity]);
        // }

        return CartItem::where('session_id', $this->sessionId)
            ->where('product_id', $product->id)
            ->update(['quantity' => $quantity]);
    }

    /**
     * Calcola il totale del carrello
     */
    public function getTotal()
    {
        $cartItems = $this->getCart();
        return $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Svuota il carrello
     */
    public function clearCart()
    {
        // if (Auth::check()) {
        //     return Auth::user()->cartItems()->delete();
        // }

        return CartItem::where('session_id', $this->sessionId)->delete();
    }

    /**
     * Controlla se il carello è vuoto
     */
    public function isEmpty(): bool
    {
        return $this->getCart()->isEmpty();
    }

    /**
     * Unisce il carrello guest con quello dell'utente dopo il login
     */
    public function mergeGuestCartToUser($user)
    {
        $guestItems = CartItem::where('session_id', $this->sessionId)->get();

        foreach ($guestItems as $item) {
            CartItem::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $item->product_id,
                    'session_id' => null, // Ora è associato all'utente
                ],
                [
                    'quantity' => DB::raw("quantity + {$item->quantity}"), // Somma le quantità
                    'price' => $item->price, // Mantiene il prezzo originale
                ]
            );

            $item->delete(); // Elimina il record guest
        }
    }

    /**
     * Formatta i dati del carello per salavataggio tabella ordini
     */
    public function getFormattedCart(): array
    {
        return $this->getCart()->map(function ($item) {
            // Verifica che il prodotto esista ancora
            if (!$item->product) {
                return null; // o gestisci l'errore
            }

            return [
                'product_id' => $item->product_id,
                'name' => $item->product->nome,
                'price' => $item->price,
                'quantity' => $item->quantity,
                // 'img_url' => $item->product->src_img, // Opzionale
                'product_data' => $item->product->toArray() // Tutti i dati del prodotto
            ];
        })->filter()->toArray(); // Filtra eventuali null
    }
}
