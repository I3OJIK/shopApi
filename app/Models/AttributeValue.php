<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Значения определенного атрибуда (Цвет: синий, желтый. Размер: xl, l)
 * 
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 * 
 * @property-read Attribute $attribute
 * @property-read Collection<int, ProductVariant> $variants
 */
class AttributeValue extends Model
{
    protected $fillable = [
        'id',
        'attribute_id ',
        'value',
    ];

    public $timestamps = false;
    
    /**
     * Вариант принадлежит атрибуту
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Значение может встречаться у разных вариантов товара
     */
    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_values');
    }
}
