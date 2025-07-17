<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    // Nome tabella associata al model
    protected $table = 'products';

    // Campi assegnabili massivamente
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
        'allergeni',
        'visualizzazioni'
    ];

    // Casting automatico dei campi
    protected $casts = [
        'disponibile' => 'boolean',
        'in_offerta' => 'boolean',
        'novita' => 'boolean',
        'prezzo' => 'decimal:2',
        'prezzo_offerta' => 'decimal:2',
        'allergeni' => 'array',
    ];

    // Attributi aggiuntivi da includere nell'array/JSON
    protected $appends = [
        'tipo_formattato',
        'prezzo_formattato',
        'prezzo_offerta_formattato',
        'sconto_percentuale',
        'prezzo_finale',
        'peso_formattato',
        'tempo_cottura_formattato',
        'visualizzazioni_formattate'
    ];

    // Boot del model per gestire gli eventi
    protected static function boot()
    {
        parent::boot();

        // Genera lo slug automaticamente dal nome quando si crea
        static::creating(function ($product) {
            $product->slug = Str::slug($product->nome);
        });

        // Aggiorna lo slug se cambia il nome
        static::updating(function ($product) {
            if ($product->isDirty('nome')) {
                $product->slug = Str::slug($product->nome);
            }
        });
    }

    // Restituisce il tipo formattato per la visualizzazione
    public function getTipoFormattatoAttribute(): string
    {
        return match ($this->tipo) {
            'lunga' => 'Pasta Lunga',
            'corta' => 'Pasta Corta',
            'speciale' => 'Formato Speciale',
            'gluten-free' => 'Senza Glutine',
            default => ucfirst($this->tipo)
        };
    }

    // Restituisce il prezzo formattato con simbolo €
    protected function prezzoFormattato(): Attribute
    {
        return Attribute::make(
            get: fn() => '€ ' . number_format($this->prezzo, 2, ',', '.'),
        );
    }

    // Restituisce il prezzo in offerta formattato
    protected function prezzoOffertaFormattato(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->in_offerta && $this->prezzo_offerta
                ? '€ ' . number_format($this->prezzo_offerta, 2, ',', '.')
                : null,
        );
    }

    // Calcola la percentuale di sconto
    public function getScontoPercentualeAttribute(): ?int
    {
        if (!$this->in_offerta || $this->prezzo <= 0 || !$this->prezzo_offerta) {
            return null;
        }
        return round((($this->prezzo - $this->prezzo_offerta) / $this->prezzo) * 100);
    }

    // Restituisce il prezzo finale (offerta se disponibile)
    protected function prezzoFinale(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->in_offerta && $this->prezzo_offerta
                ? $this->prezzo_offerta
                : $this->prezzo,
        );
    }

    // Restituisce il peso formattato (g o kg)
    public function getPesoFormattatoAttribute(): string
    {
        return $this->peso >= 1000
            ? (number_format($this->peso / 1000, 1, ',', '') . ' kg')
            : ($this->peso . ' g');
    }


    // Restituisce il tempo cottura formattato
    public function getTempoCotturaFormattatoAttribute(): ?string
    {
        return $this->tempo_cottura ? "{$this->tempo_cottura} min" : null;
    }

    // Restituisce il numero di visualizzazioni dell'articolo formattato
    public function getVisualizzazioniFormattateAttribute(): string
    {
        return number_format($this->visualizzazioni, 0, ',', '.');
    }

    // SCOPE QUERY ==============================================

    // Filtra solo prodotti disponibili
    public function scopeDisponibili($query)
    {
        return $query->where('disponibile', true);
    }

    // Filtra prodotti in offerta
    public function scopeInOfferta($query)
    {
        return $query->where('in_offerta', true);
    }

    // Filtra prodotti novità
    public function scopeNovita($query)
    {
        return $query->where('novita', true);
    }

    // Filtra per tipo di pasta
    public function scopeTipo($query, string $type)
    {
        return $query->where('tipo', $type);
    }

    // Filtra per valutazione minima
    public function scopeValutazioneMinima($query, int $rating)
    {
        return $query->where('valutazione', '>=', $rating);
    }

    // Filtra per prodotti più venduti
    public function scopePiuVenduti($query, int $limit = 5)
    {
        return $query->orderBy('venduti', 'desc')->take($limit);
    }

    // Ottiene i prodotti più visualizzati
    public function scopePiuVisti($query, int $limit = 5)
    {
        return $query->orderBy('visualizzazioni', 'desc')->take($limit);
    }
}
