<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $table = 'prodotti';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nome',
        'descrizione',
        'prezzo',
        'peso',
        'tipo',
        'tempo_cottura',
        'src_img',
        'src_h_img',
        'src_p_img',
        'disponibile',
        'in_offerta',
        'prezzo_offerta'
    ];
    protected $casts = [
        'disponibile' => 'boolean',
        'in_offerta' => 'boolean',
        'prezzo' => 'decimal:2',
        'prezzo_offerta' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected function prezzoFormattato(): Attribute
    {
        return Attribute::make(
            get: fn() => '€ ' . number_format($this->prezzo, 2, ',', '.'),
        );
    }

    protected function prezzoOffertaFormattato(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->in_offerta ? '€ ' . number_format($this->prezzo_offerta, 2, ',', '.') : null,
        );
    }

    public function scopeDisponibili($query)
    {
        return $query->where('disponibile', true);
    }

    public function scopeInOfferta($query)
    {
        return $query->where('in_offerta', true);
    }

    public function scopeTipo($query, $type)
    {
        return $query->where('tipo', $type);
    }

    protected function prezzoFinale(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->in_offerta ? $this->prezzo_offerta : $this->prezzo,
        );
    }
}
