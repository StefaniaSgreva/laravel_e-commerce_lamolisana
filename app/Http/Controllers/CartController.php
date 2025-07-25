<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Exception;

class CartController extends Controller
{
    protected $cartService;

    // Inietta il CartService nel controller
    public function __construct(CartService $cartService)
    {
        parent::__construct(); // Per tenere opzioni costruttore controller base
        $this->cartService = $cartService;
    }

    /**
     * Mostra il contenuto del carrello
     */
    public function index()
    {
        $cartItems = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        $shipping = $this->cartService->getShipping();
        $discount = $this->cartService->getDiscount();
        $total = $this->cartService->getTotal();

        return view('pages.cart', compact('cartItems', 'subtotal', 'shipping', 'discount', 'total'));
    }

    /**
     * Aggiunge un prodotto al carrello
     */
    public function add(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $quantity = $request->input('quantity', 1);
        $this->cartService->addToCart($product, $quantity);

        return redirect()
            ->back()
            ->with('success', 'Prodotto aggiunto al carrello!');
    }

    /**
     * Rimuove un prodotto dal carrello
     */
    public function remove(Product $product)
    {
        $this->cartService->removeFromCart($product);

        return redirect()
            ->back()
            ->with('success', 'Prodotto rimosso dal carrello');
    }

    /**
     * Aggiorna la quantità di un prodotto
     */
    public function update(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $this->cartService->updateQuantity($product, $request->quantity);

        return back()->with('success', 'Quantità aggiornata');
    }

    /**
     * Svuota il carrello
     */
    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()
            ->back()
            ->with('success', 'Carrello svuotato');
    }


    /**
     * Totale ordine
     */
    public function getTotals()
    {
        $cartService = new CartService();

        return response()->json([
            'subtotal' => $cartService->getSubtotal(),
            'shipping' => $cartService->getShipping(),
            'discount' => $cartService->getDiscount(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * Avvia il checkout PayPal (versione per srmklive/paypal v3.0+)
     */
    public function paypalCheckout()
    {
        try {
            if ($this->cartService->isEmpty()) {
                throw new Exception('Il carrello è vuoto');
            }

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));

            $token = $provider->getAccessToken();
            if (!isset($token['access_token'])) {
                throw new Exception('Errore di connessione con PayPal');
            }

            $data = $this->preparePayPalOrder();

            $response = $provider->createOrder($data);

            if (isset($response['id']) && $response['status'] === 'CREATED') {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            $errorMsg = $response['message'] ?? $response['details'][0]['description'] ?? 'Errore sconosciuto';
            throw new Exception($errorMsg);
        } catch (Exception $e) {
            return redirect()
                ->route('cart')
                ->with('paypal_error', $this->formatPayPalError($e->getMessage()));
        }
    }

    /**
     * Gestisce il successo del pagamento
     */
    public function paypalSuccess(Request $request)
    {
        try {
            if (!$request->has('token')) {
                throw new Exception('Token di pagamento mancante');
            }

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->capturePaymentOrder($request->token);

            if ($response['status'] === 'COMPLETED') {
                // 1. Salva l'ordine nel database
                // $this->saveOrder($response);

                // 2. Svuota il carrello
                $this->cartService->clearCart();

                return view('paymentSuccess', [
                    'transaction_id' => $response['id'],
                    'payer_email' => $response['payer']['email_address'] ?? null,
                    'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? null
                ]);
            }

            throw new Exception($response['details'][0]['description'] ?? 'Pagamento non completato');
        } catch (Exception $e) {
            return redirect()
                ->route('cart')
                ->with('paypal_error', $this->formatPayPalError($e->getMessage()));
        }
    }

    /**
     * Pagamento annullato
     */
    public function paypalCancel(Request $request)
    {
        $error = $request->input('error', 'Pagamento annullato');
        return redirect()
            ->route('cart')
            ->with('paypal_error', $error);
    }

    /**
     * Prepara i dati per l'ordine PayPal
     */
    private function preparePayPalOrder(): array
    {
        return [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
                'brand_name' => config('app.name'),
                'user_action' => 'PAY_NOW',
            ],
            'purchase_units' => [
                [
                    'reference_id' => uniqid(),
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => $this->cartService->getTotal(),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'EUR',
                                'value' => $this->cartService->getSubtotal(),
                            ],
                            'shipping' => [
                                'currency_code' => 'EUR',
                                'value' => $this->cartService->getShipping(),
                            ],
                            'discount' => [
                                'currency_code' => 'EUR',
                                'value' => $this->cartService->getDiscount(),
                            ],
                        ],
                    ],
                    'items' => $this->getPayPalItems(),
                ],
            ],
        ];
    }

    /**
     * Formatta gli articoli del carrello per PayPal
     */
    private function getPayPalItems(): array
    {
        return $this->cartService->getCart()->map(function ($item) {
            return [
                'name' => $item->product->nome,
                'unit_amount' => [
                    'currency_code' => 'EUR',
                    'value' => $item->price,
                ],
                'quantity' => $item->quantity,
                'sku' => $item->product->id,
                'category' => 'PHYSICAL_GOODS',
            ];
        })->toArray();
    }

    /**
     * Traduce gli errori PayPal in messaggi user-friendly
     */
    private function formatPayPalError(string $error): string
    {
        $errors = [
            'Il carrello è vuoto' => 'Non puoi procedere al pagamento con un carrello vuoto',
            'Errore di connessione con PayPal' => 'Problemi di connessione con PayPal. Riprova più tardi',
            'PAYER_ACTION_REQUIRED' => 'È richiesta un\'azione da parte tua su PayPal',
            'INSTRUMENT_DECLINED' => 'Il metodo di pagamento è stato rifiutato',
            'TRANSACTION_REFUSED' => 'Transazione rifiutata',
        ];

        return $errors[$error] ?? "Errore durante il pagamento: $error";
    }
}
