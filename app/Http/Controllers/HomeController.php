<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Mostra i 4 prodotti più visualizzati
        // $featuredProducts = Product::disponibili()
        //     ->piuVisti(4)
        //     ->get();

        // Alternativa: prodotti più venduti
        $featuredProducts = Product::disponibili()
            ->piuVenduti(4)
            ->get();

        // Alternativa: prodotti in evidenza (novità + più visualizzati)
        // $featuredProducts = Product::disponibili()
        //     ->where(function ($query) {
        //         $query->where('novita', true)
        //             ->orWhere('in_offerta', true);
        //     })
        //     ->orderBy('visualizzazioni', 'desc')
        //     ->take(4)
        //     ->get();

        return view('pages.home', compact('featuredProducts'));
    }
}
