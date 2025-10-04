<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 * @property int $id
 * @property int $cart_id
 * @property int $product_variant_id
 * @property int $quantity
 * @property bool $is_selected
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read Cart $Cart
 * @property-read Collection<int, ProductVariant> $productVariant
 */
class CartItem extends Model
{

    protected $fillable = [
        'id',
        'cart_id',
        'product_variant_id',
        'quantity',
        'is_selected',
    ];

    public $timestamps = true;

    /**
     * Элемент принадлежит данной корзине
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Продукт
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}