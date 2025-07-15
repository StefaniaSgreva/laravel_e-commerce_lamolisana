<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $table = 'prodotti';

    protected $primaryKey = 'id';

    // Campi che possono essere assegnati in massa
    protected $fillable = [
        'nome',
        'descrizione',
        'prezzo',
        'peso',
        'tipo',
        'tempo_cottura',
        'src_img',
        'disponibile',
        'in_offerta',
        'prezzo_offerta'
    ];

    // Conversione automatica dei tipi di dato
    protected $casts = [
        'disponibile' => 'boolean',
        'in_offerta' => 'boolean',
        'prezzo' => 'decimal:2',
        'prezzo_offerta' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Restituisce il prezzo formattato con simbolo €
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function prezzoFormattato(): Attribute
    {
        return Attribute::make(
            get: fn() => '€ ' . number_format($this->prezzo, 2, ',', '.'),
        );
    }

    /**
     * Restituisce il prezzo scontato formattato con simbolo € (se in offerta)
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function prezzoOffertaFormattato(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->in_offerta ? '€ ' . number_format($this->prezzo_offerta, 2, ',', '.') : null,
        );
    }

    /**
     * Filtra solo i prodotti disponibili
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisponibili($query)
    {
        return $query->where('disponibile', true);
    }

    /**
     * Filtra solo i prodotti in offerta
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInOfferta($query)
    {
        return $query->where('in_offerta', true);
    }

    /**
     * Filtra i prodotti per tipo (lunga/corta/speciale)
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTipo($query, $type)
    {
        return $query->where('tipo', $type);
    }

    /**
     * Restituisce il prezzo finale (scontato se disponibile)
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function prezzoFinale(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->in_offerta ? $this->prezzo_offerta : $this->prezzo,
        );
    }
}
