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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titolo', 150);
            $table->string('slug')->unique();
            $table->text('contenuto');
            $table->text('estratto')->nullable();
            $table->string('immagine_copertina')->nullable();
            $table->string('immagine_social')->nullable(); // Per condivisioni social
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('pubblicato')->default(false);
            $table->boolean('in_evidenza')->default(false); // Post in evidenza
            $table->timestamp('data_pubblicazione')->nullable();
            $table->timestamp('data_scadenza')->nullable(); // Per post temporanei
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->integer('visualizzazioni')->default(0);
            $table->integer('tempo_lettura')->nullable(); // Minuti stimati di lettura
            $table->timestamps();
            $table->softDeletes();

            // Chiavi esterne
            $table->foreign('categoria_id')
                ->references('id')
                ->on('post_categories')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
