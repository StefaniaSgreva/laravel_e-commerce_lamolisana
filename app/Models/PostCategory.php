<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'slug',
        'descrizione'
    ];

    /**
     * Relazione con i post
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'categoria_id');
    }

    /**
     * Genera automaticamente lo slug dal nome
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->nome);
        });

        static::updating(function ($category) {
            if ($category->isDirty('nome')) {
                $category->slug = Str::slug($category->nome);
            }
        });
    }

    /**
     * Get the route key for the model.
     * (Per usare lo slug nelle URL invece dell'ID)
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
