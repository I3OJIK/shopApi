<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Тип атрибута товара (цвет, размер и тд)
 * 
 * @property int $id
 * @property string $name
 * 
 * @property-read Collection<int, AttributeValue> $value
 * 
 */
class Attribute extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    public $timestamps = false;

    /**
     * Значения атрибута  red, blue, 128GB)
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
