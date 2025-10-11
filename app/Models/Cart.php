<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read User $user
 * @property-read Collection<int, CartItem> $items
 */
class Cart extends Model
{
    protected $fillable = [
        'id',
        'user_id',
    ];

    public $timestamps = true;

    /**
     * Пользователь которому прингадлежит корзина
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Элементы данной корзины
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
