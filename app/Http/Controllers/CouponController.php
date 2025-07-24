<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Applica un coupon al carrello
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|regex:/^[A-Z0-9]+$/i'
        ]);

        try {
            $coupon = $this->cartService->validateCoupon($request->code);

            // Incrementa gli usi del coupon prima di applicarlo
            $coupon->incrementUses();

            Session::put('coupon', $coupon);

            // Get all totals at once for consistency
            $subtotal = $this->cartService->getSubtotal();
            $shipping = $this->cartService->getShipping();
            $discount = $this->cartService->getDiscount();
            $total = $this->cartService->getTotal();

            return response()->json([
                'success' => true,
                'message' => 'Coupon applicato con successo!',
                'coupon' => [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'description' => $coupon->description
                ],
                'discount' => $discount, // Explicit discount value
                'totals' => [
                    'subtotal' => $subtotal,
                    'shipping' => $shipping,
                    'discount' => $discount,
                    'total' => $total
                ]
            ]);
        } catch (\Exception $e) {
            // Get totals without coupon for error response
            $subtotal = $this->cartService->getSubtotal();
            $shipping = $this->cartService->getShipping();
            $total = $subtotal + $shipping;

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'discount' => 0, // Explicit discount value
                'totals' => [
                    'subtotal' => $subtotal,
                    'shipping' => $shipping,
                    'discount' => 0,
                    'total' => $total
                ]
            ], 422);
        }
    }

    /**
     * Rimuove il coupon applicato
     */
    public function remove()
    {
        try {
            $coupon = $this->cartService->getCoupon();

            if ($coupon) {
                // Qui potresti decrementare gli usi se necessario
                // $coupon->decrement('uses');
            }

            $this->cartService->removeCoupon();

            // Get totals after removal
            $subtotal = $this->cartService->getSubtotal();
            $shipping = $this->cartService->getShipping();
            $total = $subtotal + $shipping;

            return response()->json([
                'success' => true,
                'message' => 'Coupon rimosso con successo',
                'discount' => 0, // Explicit discount value
                'totals' => [
                    'subtotal' => $subtotal,
                    'shipping' => $shipping,
                    'discount' => 0,
                    'total' => $total
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore durante la rimozione del coupon: ' . $e->getMessage(),
                'discount' => 0, // Explicit discount value
                'totals' => [
                    'subtotal' => $this->cartService->getSubtotal(),
                    'shipping' => $this->cartService->getShipping(),
                    'discount' => 0,
                    'total' => $this->cartService->getSubtotal() + $this->cartService->getShipping()
                ]
            ], 500);
        }
    }
}
