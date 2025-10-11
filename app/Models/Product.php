<?php

namespace App\Models;

use App\Observers\ProductVariantObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * 
 * @property-read Product $product
 * @property-read Collection<int, AttributeValue> $attributeValues
 */
class ProductVariant extends Model
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
    ];
    

    /**
     * Продукт принадлежит группе товаров
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}