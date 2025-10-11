<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * 
 * @property int $id
 * @property int $user_id
 * @property int $address_id
 * @property int $total
 * @property string $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read User $user
 * @property-read Address $address
 * @property-read Collection<int, OrderItem> $items
 */
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'total_price',
        'status',
    ];

    public $timestamps = true;

    /**
     * Пользователь оформивший заказ
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Адресс данного заказа
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Продукты в заказе
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}