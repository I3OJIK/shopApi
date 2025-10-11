<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $category_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read Collection<int, Product> $products
 * @property-read Collection<int, Category> $categories
 */
class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];

    public $timestamps = false;

    /**
     * продукты данной категории товаров
     * 
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    /**
     * Категории продукта
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}