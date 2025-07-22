<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Per gli utenti non registrati (guest)
            $table->string('session_id')->nullable();

            // Per gli utenti registrati
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // Riferimento al prodotto
            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');

            // Quantità del prodotto
            $table->integer('quantity')->default(1);

            // Prezzo al momento dell'aggiunta al carrello
            $table->decimal('price', 8, 2);

            $table->timestamps();

            // Indici per migliorare le performance
            $table->index(['session_id']);
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
