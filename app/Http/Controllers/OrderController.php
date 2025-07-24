<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function showConfirmation($orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->with('coupon') // Carica la relazione coupon se esiste
            ->firstOrFail();

        // Calcola i totali se non già presenti
        if (empty($order->subtotal)) {
            $order->subtotal = $this->calculateSubtotal($order->cart_data);
        }

        if (empty($order->total)) {
            $order->total = $this->calculateTotal($order);
        }

        return view('pages.order_confirmation', [
            'order' => $order,
            'couponApplied' => !empty($order->coupon_code) // Flag per verificare se c'è un coupon
        ]);
    }

    protected function calculateSubtotal($cartData)
    {
        return collect($cartData)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    protected function calculateTotal($order)
    {
        $subtotal = $order->subtotal ?? $this->calculateSubtotal($order->cart_data);
        $shipping = $order->shipping ?? 5.00; // Default shipping cost
        $discount = $order->discount_amount ?? 0;

        return $subtotal + $shipping - $discount;
    }
}
