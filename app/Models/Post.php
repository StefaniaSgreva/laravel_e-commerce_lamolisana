<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titolo',
        'slug',
        'contenuto',
        'estratto',
        'immagine_copertina',
        'immagine_social',
        'meta_title',
        'meta_description',
        'pubblicato',
        'in_evidenza',
        'data_pubblicazione',
        'data_scadenza',
        'categoria_id',
        'visualizzazioni',
        'tempo_lettura'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pubblicato' => 'boolean',
        'in_evidenza' => 'boolean',
        'data_pubblicazione' => 'datetime',
        'data_scadenza' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'data_pubblicazione',
        'data_scadenza',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Relazione con la categoria del post
     */
    public function categoria()
    {
        return $this->belongsTo(PostCategory::class, 'categoria_id');
    }

    /**
     * Scope per i post pubblicati
     */
    public function scopePubblicati($query)
    {
        return $query->where('pubblicato', true)
            ->where(function ($q) {
                $q->whereNull('data_pubblicazione')
                    ->orWhere('data_pubblicazione', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('data_scadenza')
                    ->orWhere('data_scadenza', '>=', now());
            });
    }

    /**
     * Scope per i post in evidenza
     */
    public function scopeInEvidenza($query)
    {
        return $query->where('in_evidenza', true);
    }

    /**
     * Incrementa il contatore delle visualizzazioni
     */
    public function incrementaVisualizzazioni()
    {
        $this->increment('visualizzazioni');
    }

    /**
     * Genera automaticamente lo slug dal titolo
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = \Illuminate\Support\Str::slug($post->titolo);
        });

        static::updating(function ($post) {
            if ($post->isDirty('titolo')) {
                $post->slug = \Illuminate\Support\Str::slug($post->titolo);
            }
        });
    }
}
