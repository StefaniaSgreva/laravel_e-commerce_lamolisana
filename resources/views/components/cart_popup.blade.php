<!-- Popup Aggiunta al Carrello -->
<div id="cart-popup" class="fixed inset-0 flex items-center justify-center z-[9999] hidden overflow-y-auto">
    <!-- Sfondo semitrasparente con effetto blur -->
    <div class="fixed inset-0 bg-gray-900/30 backdrop-blur-sm" onclick="closeCartPopup()"></div>

    <!-- Contenuto popup -->
    <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 relative z-10 transform transition-all duration-300 scale-95 opacity-0"
         id="popup-content">
        <!-- Icona di successo -->
        <div class="absolute -top-5 -right-5 bg-green-500 text-white p-3 rounded-full shadow-lg">
            <i class="fas fa-check text-xl"></i>
        </div>

        <div class="flex flex-col items-center text-center">
            <!-- Icona carrello -->
            <div class="bg-molisana-blue/10 text-molisana-blue p-4 rounded-full mb-4">
                <i class="fas fa-shopping-cart text-3xl"></i>
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-2">Aggiunto al carrello!</h3>
            <p class="text-gray-600 mb-6">Il prodotto è stato aggiunto correttamente al tuo carrello.</p>

            <!-- Immagine anteprima prodotto -->
            <div class="w-20 h-20 mb-6 rounded-lg overflow-hidden border border-gray-100 shadow-sm">
                <img src="{{ Vite::asset('resources/img/products/' . $product->src_img) }}"
                     alt="{{ $product->nome }}"
                     class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Pulsanti -->
        <div class="flex flex-col sm:flex-row gap-3 mt-6">
            <button onclick="closeCartPopup()"
                    class="cursor-pointer flex-1 px-6 py-3 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                Continua lo shopping
            </button>
            <a href="{{ route('cart') }}"
               class="flex-1 px-6 py-3 bg-molisana-orange text-white rounded-lg hover:bg-molisana-orange-hover transition-colors font-medium flex items-center justify-center">
                {{-- Vai al carrello <span class="ml-2 bg-white/20 px-2 py-1 rounded-full text-sm" id="cart-items-count">1</span> --}}
                Vai al carrello
            </a>
        </div>
    </div>
</div>

<script>
    // Mostra il popup del carrello
    function showCartPopup() {
        document.body.classList.add('popup-open');
        const popup = document.getElementById('cart-popup');
        const content = document.getElementById('popup-content');

        popup.classList.remove('hidden');
        popup.classList.add('show');
        setTimeout(() => {
            content.classList.add('show');
        }, 10);

        // Aggiorna il contatore con il valore reale dal carrello
        updateCartCount();
    }

    // Aggiorna il contatore degli articoli nel carrello
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const counter = document.getElementById('cart-items-count');
                if (counter) {
                    counter.textContent = data.count;
                }
            })
            .catch(error => {
                console.error('Errore nel recupero conteggio carrello:', error);
                document.getElementById('cart-items-count').textContent = '1';
            });
    }

    // Chiudi il popup del carrello
    function closeCartPopup() {
        document.body.classList.remove('popup-open');
        const popup = document.getElementById('cart-popup');
        const content = document.getElementById('popup-content');

        content.classList.remove('show');
        setTimeout(() => {
            popup.classList.remove('show');
            popup.classList.add('hidden');
        }, 300);
    }

    // Chiudi con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeCartPopup();
    });
</script>
