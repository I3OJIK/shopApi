<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $address_text
 * @property string|null $apartment_number
 * @property string $doorphone
 * @property string $entrance
 * @property string $floor
 * 
 * @property-read User $user
 * @property-read Collection<int, Order> $orders
 * 
 */
class Address extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'phone',
        'address_text',
        'apartment_number',
        'doorphone',
        'entrance',
        'floor',
    ];

    public $timestamps = false;

    /**
     * Пользователь которому принадлежит адрес
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Заказы на данный адрес
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
