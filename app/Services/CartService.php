<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * ID della sessione corrente per gestire il carrello guest
     * @var string
     */
    protected $sessionId;

    /**
     * Costruttore: inizializza l'ID sessione
     */
    public function __construct()
    {
        $this->sessionId = session()->getId();
    }

    // ================= METODI BASE CARRELLO ================= //

    /**
     * Recupera tutti gli elementi del carrello per la sessione corrente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCart()
    {
        return CartItem::where('session_id', $this->sessionId)
            ->with('product') // Carica la relazione product
            ->get();
    }

    /**
     * Aggiunge un prodotto al carrello o incrementa la quantità se già presente
     * @param Product $product Il prodotto da aggiungere
     * @param int $quantity Quantità da aggiungere (default 1)
     * @return CartItem
     */
    public function addToCart(Product $product, int $quantity = 1)
    {
        // Usa il prezzo in offerta se disponibile, altrimenti il prezzo base
        $price = $product->in_offerta && $product->prezzo_offerta
            ? $product->prezzo_offerta
            : $product->prezzo;

        // Prima verifica se il prodotto è già nel carrello
        $existingItem = CartItem::where('product_id', $product->id)
            ->where('session_id', $this->sessionId)
            ->first();

        if ($existingItem) {
            // Se esiste già, aggiorna la quantità sommando la nuova
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
                'price' => $price
            ]);
            return $existingItem;
        }

        // Se non esiste, crea un nuovo record
        return CartItem::create([
            'product_id' => $product->id,
            'session_id' => $this->sessionId,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }

    /**
     * Rimuove un prodotto dal carrello
     * @param Product $product Prodotto da rimuovere
     * @return bool
     */
    public function removeFromCart(Product $product)
    {
        return CartItem::where('session_id', $this->sessionId)
            ->where('product_id', $product->id)
            ->delete();
    }

    /**
     * Aggiorna la quantità di un prodotto nel carrello
     * @param Product $product Prodotto da aggiornare
     * @param int $quantity Nuova quantità
     * @return bool
     */
    public function updateQuantity(Product $product, int $quantity)
    {
        // Se la quantità è <= 0, rimuovi l'elemento
        if ($quantity <= 0) {
            return $this->removeFromCart($product);
        }

        return CartItem::where('session_id', $this->sessionId)
            ->where('product_id', $product->id)
            ->update(['quantity' => $quantity]);
    }

    /**
     * Calcola il subtotale del carrello (senza sconti o spedizione)
     * @return float
     */
    public function getSubtotal()
    {
        return $this->getCart()->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Svuota completamente il carrello
     * @return bool
     */
    public function clearCart()
    {
        return CartItem::where('session_id', $this->sessionId)->delete();
    }

    /**
     * Verifica se il carrello è vuoto
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->getCart()->isEmpty();
    }

    // ================= METODI GESTIONE COUPON ================= //

    /**
     * Valida un coupon
     */
    public function validateCoupon(string $code): Coupon
    {
        $coupon = Coupon::where('code', $code)
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('uses < max_uses');
            })
            ->first();

        if (!$coupon) {
            throw new \Exception('Codice sconto non valido o scaduto');
        }

        if ($coupon->min_order && $this->getSubtotal() < $coupon->min_order) {
            throw new \Exception(sprintf(
                'L\'ordine minimo per questo coupon è €%s',
                number_format($coupon->min_order, 2, ',', '.')
            ));
        }

        return $coupon;
    }

    /**
     * Calcola l'importo dello sconto per un coupon specifico
     */
    public function calculateDiscountAmount(Coupon $coupon): float
    {
        $subtotal = $this->getSubtotal();
        return $coupon->type === 'percent'
            ? ($subtotal * $coupon->value / 100)
            : min($coupon->value, $subtotal);
    }

    /**
     * Calcola l'importo dello sconto applicato
     * @return float
     */
    public function getDiscount(): float
    {
        if (!$this->hasCoupon()) {
            return 0;
        }

        $coupon = $this->getCoupon();
        return $coupon->applyDiscount($this->getSubtotal());
    }

    /**
     * Verifica se è applicato un coupon
     * @return bool
     */
    public function hasCoupon()
    {
        return Session::has('coupon');
    }

    /**
     * Recupera il coupon applicato
     * @return Coupon|null
     */
    public function getCoupon(): ?Coupon
    {
        return Session::get('coupon');
    }

    /**
     * Rimuove il coupon applicato
     */
    public function removeCoupon(): void
    {
        Session::forget('coupon');
    }

    /**
     * Calcola i costi di spedizione
     * @return float
     */
    public function getShipping()
    {
        // Costo fisso, eventualmente personalizzabile in base a peso/destinazione
        return 5.00;
    }

    /**
     * Calcola il totale finale (subtotale + spedizione - sconto)
     * @return float
     */
    public function getTotal()
    {
        return $this->getSubtotal() + $this->getShipping() - $this->getDiscount();
    }

    // ================= METODI UTILITY ================= //

    /**
     * Formatta i dati del carrello per il salvataggio negli ordini
     * @return array
     */
    public function getFormattedCart(): array
    {
        return $this->getCart()->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product->nome,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'img_url' => $item->product->src_img,
                'subtotal' => $item->price * $item->quantity
            ];
        })->toArray();
    }

    /**
     * Unisce il carrello guest con quello dell'utente dopo il login
     * @param \App\Models\User $user
     */
    public function mergeGuestCartToUser($user)
    {
        $guestItems = $this->getCart();

        foreach ($guestItems as $item) {
            // Aggiunge al carrello utente o aggiorna quantità se già presente
            CartItem::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $item->product_id
                ],
                [
                    'quantity' => DB::raw("quantity + {$item->quantity}"), // Somma le quantità
                    'price' => $item->price, // Mantiene il prezzo originale
                    'session_id' => null // Segnala che ora è associato all'utente
                ]
            );
        }

        $this->clearCart(); // Svuota il carrello guest
    }
}
