<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property string $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read Category $parent
 * @property-read Collection<int, Category> $children
 * @property-read Collection<int, Product> $products
 */
class Category extends Model
{

    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'description',
        'is_active',
    ];

    public $timestamps = true;

    /**
     * Категоия родитель
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    /**
     * Подкатегории
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    /**
     * Продукты категории
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
