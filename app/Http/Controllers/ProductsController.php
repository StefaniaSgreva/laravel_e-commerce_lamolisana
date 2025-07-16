<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Mostra l'elenco dei prodotti disponibili
     * Ordinati per data di pubblicazione (dal più recente)
     */
    public function index()
    {
        $products = Product::disponibili()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('pages.products', [
            'products' => $products,
            'tipiPasta' => ['lunga', 'corta', 'speciale', 'gluten-free']
        ]);
    }

    /**
     * Mostra i dettagli di un singolo prodotto
     */
    public function show(Product $product)
    {
        // Verifica che il prodotto sia disponibile
        abort_unless($product->disponibile, 404);

        // Incrementa il contatore delle visualizzazioni
        $product->increment('visualizzazioni');

        // Recupera 4 prodotti correlati (stesso tipo, random)
        $relatedProducts = Product::disponibili()
            ->tipo($product->tipo)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('pages.show_product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
