<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $image
 * @property int $category_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read Collection<int, ProductVariant> $variants
 * @property-read Collection<int, Category> $categories
 */
class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'category_id',
    ];

    public $timestamps = false;

    /**
     * Варианты товара (цвета, память и т.д.)
     * 
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }


    /**
     * Категории продукта
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
