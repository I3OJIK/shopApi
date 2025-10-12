<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Определенный вариант товара (Синий apple 12)
 * @property int $id
 * @property int $product_group_id
 * @property string $name
 * @property string $size
 * @property string $color
 * @property string $variant
 * @property string $image
 * @property int $price
 * @property int $stock
 * @property bool $is_active
 * 
 * @property-read Product $productGroup
 */
class Product extends Model
{

    protected $fillable = [
        'id',
        'product_group_id',
        'name',
        'size',
        'color',
        'variant',
        'image',
        'price',
        'stock',
        'is_active',
    ];
    public $timestamps = false;

    /**
     * Продукт принадлежит группе товаров
     */
    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

}