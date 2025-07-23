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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();  // Per i guest
            $table->string('order_code')->unique();   // Es: "ORD-ABC123"
            $table->json('customer_data');            // Nome, email, indirizzo (JSON)
            $table->json('cart_data');                // Dump del carrello (prodotti, prezzi)
            $table->decimal('total', 10, 2);          // Totale ordine
            $table->text('note')->nullable();          // Eventuali note
            $table->string('status')->default('pending'); // pending/paid/failed/completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
