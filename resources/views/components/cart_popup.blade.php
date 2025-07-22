<!-- Popup Aggiunta al Carrello -->
<div id="cart-popup" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeCartPopup()"></div>
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4 z-10 transform transition-all duration-300 scale-95 opacity-0"
         id="popup-content">
        <div class="flex justify-between items-start">
            <h3 class="text-xl font-bold text-molisana-blue">Prodotto aggiunto al carrello!</h3>
            <button onclick="closeCartPopup()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mt-4">
            <p class="text-gray-600">Il prodotto è stato aggiunto correttamente al tuo carrello.</p>
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <button onclick="closeCartPopup()"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                Continua lo shopping
            </button>
            <a href="{{ route('cart') }}"
               class="px-4 py-2 bg-molisana-orange text-white rounded-md hover:bg-molisana-orange-hover transition-colors">
                Vai al carrello
            </a>
        </div>
    </div>
</div>

<style>
    .popup-show {
        animation: popupShow 0.3s forwards;
    }

    @keyframes popupShow {
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
