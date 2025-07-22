<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /**
     * Campi che possono essere riempiti massivamente
     */
    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Casting automatico dei campi
     */
    protected $casts = [
        'price' => 'decimal:2'
    ];

    /**
     * Relazione con il prodotto
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relazione con l'utente
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calcola il subtotale per questo item
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
