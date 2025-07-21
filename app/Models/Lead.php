<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'telefono',
        'oggetto',
        'messaggio',
        'accettazione_privacy'
    ];
}
