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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('slug')->unique();
            $table->text('descrizione')->nullable();
            $table->decimal('prezzo', 8, 2); // 999.999,99
            $table->decimal('prezzo_offerta', 8, 2)->nullable();
            $table->unsignedSmallInteger('peso')->comment('Peso in grammi');
            $table->enum('tipo', ['lunga', 'corta', 'speciale', 'gluten-free'])->default('lunga');
            $table->unsignedTinyInteger('tempo_cottura')->nullable()->comment('Minuti di cottura');
            $table->string('src_img')->nullable();
            $table->string('img_alt')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('disponibile')->default(true);
            $table->boolean('in_offerta')->default(false);
            $table->boolean('novita')->default(false);
            $table->unsignedTinyInteger('valutazione')->nullable()->comment('Valutazione 1-5 stelle');
            $table->unsignedInteger('venduti')->default(0);
            $table->json('allergeni')->nullable();
            $table->unsignedBigInteger('visualizzazioni')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indici per migliorare le performance
            $table->index('tipo');
            $table->index('disponibile');
            $table->index('in_offerta');
            $table->index('novita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
