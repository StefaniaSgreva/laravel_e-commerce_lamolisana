<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function showConfirmation($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();
        return view('pages.order_confirmation', compact('order'));
    }
}
