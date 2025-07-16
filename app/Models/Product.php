<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'slug',
        'descrizione',
        'prezzo',
        'prezzo_offerta',
        'peso',
        'tipo',
        'tempo_cottura',
        'src_img',
        'img_alt',
        'meta_title',
        'meta_description',
        'disponibile',
        'in_offerta',
        'novita',
        'valutazione',
        'venduti',
        'allergeni'
    ];

    protected $casts = [
        'disponibile' => 'boolean',
        'in_offerta' => 'boolean',
        'novita' => 'boolean',
        'prezzo' => 'decimal:2',
        'prezzo_offerta' => 'decimal:2',
        'allergeni' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Restituisce il tipo di pasta formattato
    public function getTipoFormattatoAttribute()
    {
        return match ($this->tipo) {
            'lunga' => 'Pasta Lunga',
            'corta' => 'Pasta Corta',
            'speciale' => 'Formato Speciale',
            'gluten-free' => 'Senza Glutine',
            default => $this->tipo
        };
    }

    // Restituisce il prezzo formattato
    protected function prezzoFormattato(): Attribute
    {
        return Attribute::make(
            get: fn() => '€ ' . number_format($this->prezzo, 2, ',', '.'),
        );
    }

    // Restituisce il prezzo scontato formattato
    protected function prezzoOffertaFormattato(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->in_offerta
                ? '€ ' . number_format($this->prezzo_offerta, 2, ',', '.')
                : null,
        );
    }

    // Calcola la percentuale di sconto
    public function getScontoPercentualeAttribute()
    {
        if (!$this->in_offerta || $this->prezzo <= 0) {
            return null;
        }

        return round((($this->prezzo - $this->prezzo_offerta) / $this->prezzo) * 100);
    }

    // Scope per prodotti disponibili
    public function scopeDisponibili($query)
    {
        return $query->where('disponibile', true);
    }

    // Scope per prodotti in offerta
    public function scopeInOfferta($query)
    {
        return $query->where('in_offerta', true);
    }

    // Scope per novità
    public function scopeNovita($query)
    {
        return $query->where('novita', true);
    }

    // Scope per tipo di pasta
    public function scopeTipo($query, $type)
    {
        return $query->where('tipo', $type);
    }

    // Restituisce il prezzo finale
    protected function prezzoFinale(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->in_offerta ? $this->prezzo_offerta : $this->prezzo,
        );
    }
}
