<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $category_id
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read Collection<int, Product> $products
 * @property-read Collection<int, Category> $categories
 */
class ProductGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'is_active',
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