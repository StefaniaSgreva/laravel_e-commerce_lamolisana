<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Mostra l'elenco dei prodotti disponibili
     */
    public function index(Request $request)
    {
        $query = Product::disponibili();

        // Filtro per tipo
        if ($request->filled('tipo')) {
            $query->tipo($request->tipo);
        }

        // Filtro per offerta (checkbox)
        if ($request->has('offerta')) {
            $query->inOfferta();
        }

        // Filtro per novità (checkbox)
        if ($request->has('novita')) {
            $query->novita();
        }

        // Filtro per ricerca testo
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nome', 'LIKE', "%$searchTerm%")
                    ->orWhere('descrizione', 'LIKE', "%$searchTerm%");
            });
        }

        // Ordinamento
        $orderBy = $request->get('order_by', 'recenti');
        switch ($orderBy) {
            case 'prezzo_crescente':
                $query->orderBy('prezzo');
                break;
            case 'prezzo_decrescente':
                $query->orderBy('prezzo', 'desc');
                break;
            case 'piu_venduti':
                $query->orderBy('venduti', 'desc');
                break;
            case 'piu_visti':
                $query->orderBy('visualizzazioni', 'desc');
                break;
            case 'migliori':
                $query->orderBy('valutazione', 'desc');
                break;
            default: // 'recenti'
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);

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
        abort_unless($product->disponibile, 404);
        $product->increment('visualizzazioni');

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
