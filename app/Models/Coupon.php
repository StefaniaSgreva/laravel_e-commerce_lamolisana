<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Coupon extends Model
{
    /**
     * Tipi di coupon disponibili
     */
    public const TYPE_PERCENT = 'percent';
    public const TYPE_FIXED = 'fixed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'valid_from',
        'valid_to',
        'uses',
        'max_uses',
        'description'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
        'uses' => 'integer',
        'max_uses' => 'integer'
    ];

    /**
     * Scope per trovare coupon validi
     */
    public function scopeValid(Builder $query)
    {
        return $query->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->where(function ($q) {
                $q->whereNull('max_uses')
                    ->orWhereColumn('uses', '<', 'max_uses');
            });
    }

    /**
     * Verifica se il coupon è valido
     */
    public function isValid(): bool
    {
        return $this->valid_from <= now() &&
            $this->valid_to >= now() &&
            (is_null($this->max_uses) || ($this->uses < $this->max_uses));
    }

    /**
     * Verifica se il coupon è scaduto
     */
    public function isExpired(): bool
    {
        return $this->valid_to < now();
    }

    /**
     * Verifica se il coupon ha raggiunto il limite di utilizzi
     */
    public function hasReachedUsageLimit(): bool
    {
        return !is_null($this->max_uses) && $this->uses >= $this->max_uses;
    }

    /**
     * Incrementa il contatore degli utilizzi
     */
    public function incrementUses()
    {
        $this->increment('uses');
    }

    /**
     * Applica lo sconto
     */
    public function applyDiscount(float $amount): float
    {
        return $this->type === self::TYPE_PERCENT
            ? $amount * ($this->value / 100)
            : min($this->value, $amount);
    }

    /**
     * Genera un codice coupon univoco
     */
    public static function generateCode(int $length = 8): string
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $code;
    }

    /**
     * Crea un nuovo coupon con codice univoco
     */
    public static function createNew(array $attributes): self
    {
        do {
            $code = self::generateCode();
        } while (self::where('code', $code)->exists());

        return self::create(array_merge(
            ['code' => $code],
            $attributes
        ));
    }
}
