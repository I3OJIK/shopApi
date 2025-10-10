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
 * @property int $product_id
 * @property string $sku
 * @property string $full_name
 * @property int $price
 * @property int $stock
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read Product $product
 * @property-read Collection<int, AttributeValue> $attributeValues
 */
#[ObservedBy([ProductVariantObserver::class])]
class ProductVariant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'product_id',
        'sku',
        'full_name',
        'price',
        'stock',
    ];
    

    /**
     * Вариант принадлежит товару
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * У варианта есть комбинация значений атрибутов (цвет- синий, память -256 и т.д.)
     */
    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_values');
    }
}
