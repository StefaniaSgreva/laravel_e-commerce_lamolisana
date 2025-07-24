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
        'subtotal',
        'shipping',
        'discount_amount',
        'coupon_code',
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
        $coupon = $cartService->getCoupon();

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
            'subtotal' => $cartService->getSubtotal(),
            'shipping' => 5.00, // O il tuo calcolo spedizioni
            'discount_amount' => $cartService->getDiscount(),
            'coupon_code' => $coupon ? $coupon->code : null,
            'total' => $cartService->getTotal(),
            'status' => 'pending',
            'note' => $customerData['note'] ?? null
        ]);
    }

    // Relazione con il coupon
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }

    // Accessor per i valori formattati
    public function getFormattedSubtotalAttribute()
    {
        return '€' . number_format($this->subtotal, 2, ',', '.');
    }

    public function getFormattedDiscountAttribute()
    {
        return '-€' . number_format($this->discount_amount, 2, ',', '.');
    }

    public function getFormattedShippingAttribute()
    {
        return '€' . number_format($this->shipping, 2, ',', '.');
    }

    public function getFormattedTotalAttribute()
    {
        return '€' . number_format($this->total, 2, ',', '.');
    }
}
