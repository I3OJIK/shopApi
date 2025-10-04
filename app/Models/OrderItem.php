<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $order_id
 * @property int $product_variant_id
 * @property int $quantity
 * @property int $price
 * 
 * @property-read Order $order
 * @property-read ProductVariant $productVariant
 */
class OrderItem extends Model
{
    protected $fillable = [
        'id',
        'order_id',
        'product_variant_id',
        'quantity',
        'price',
    ];

    public $timestamps = false;

    /**
     * заказ к которому относится товар
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Продукт 
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
