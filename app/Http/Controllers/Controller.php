<?php

namespace App\Http\Controllers;

use App\Models\CartItem;

abstract class Controller
{
    public function shareCartCount()
    {
        $cartCount = 0;

        // if (auth()->check()) {
        //     $cartCount = auth()->user()->cartItems()->count();
        // } else {
        //     $cartCount = CartItem::where('session_id', session()->getId())->count();
        // }

        $cartCount = CartItem::where('session_id', session()->getId())->count();


        View::share('cartCount', $cartCount);
    }
}
