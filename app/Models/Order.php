<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\CartService;

class Order extends Model
{
    protected $fillable = [
        'session_id',
        'order_code',
        'customer_data',
        'cart_data',
        'total',
        'note',
        'status'
    ];

    protected $casts = [
        'customer_data' => 'array',
        'cart_data' => 'array'
    ];

    // Genera un codice ordine univoco
    public static function generateOrderCode(): string
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    public static function createFromCart(CartService $cartService, array $customerData): self
    {
        return self::create([
            'session_id' => session()->getId(),
            'order_code' => self::generateOrderCode(),
            'customer_data' => [
                'nome' => $customerData['cliente']['nome'] ?? '',
                'email' => $customerData['cliente']['email'] ?? '',
                'indirizzo' => $customerData['cliente']['indirizzo'] ?? '',
                'telefono' => $customerData['cliente']['telefono'] ?? null
            ],
            'cart_data' => $cartService->getFormattedCart(),
            'total' => $cartService->getTotal(),
            'status' => 'pending',
            'note' => $customerData['note'] ?? null
        ]);
    }
}
