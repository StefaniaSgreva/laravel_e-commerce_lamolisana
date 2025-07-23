<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    public function __construct()
    {
        $this->shareCartCount();
    }

    protected function shareCartCount(): void
    {
        $cartCount = 0;

        if (session()->getId()) {
            // Somma tutte le quantità invece di contare solo i record
            $cartCount = CartItem::where('session_id', session()->getId())->sum('quantity');
        }

        View::share('cartCount', $cartCount);
    }
}
