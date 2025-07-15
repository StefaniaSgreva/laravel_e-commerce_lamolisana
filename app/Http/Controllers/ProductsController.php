<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        // Query base: prodotti disponibili ordinati per nome
        $products = Product::disponibili()
            ->orderBy('nome')
            ->paginate(12);  // Paginazione con 12 prodotti per pagina

        return view('pages.products', compact('products'));
    }

    // Mostra i dettagli di un prodotto specifico
    public function show(Product $product)
    {
        return view('pages.show_product', compact('product'));
    }

    //  Mostra i prodotti in offerta
    public function offerte()
    {
        $products = Product::inOfferta()
            ->disponibili()
            ->orderBy('nome')
            ->get();

        return view('pages.products.offerte', compact('products'));
    }

    // Mostra i prodotti per tipo
    public function perTipo($type)
    {
        $products = Product::tipo($type)
            ->disponibili()
            ->orderBy('nome')
            ->get();

        return view('pages.products.tipo', compact('products', 'type'));
    }
}
