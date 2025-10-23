<?php

namespace App\Filters\Product\Filters;

use App\Filters\Contracts\FilterInterface;
use App\Models\ProductGroup;
use Illuminate\Database\Eloquent\Builder;

class ProductGroupFilter implements FilterInterface 
{

    /**
     * Сортировка по продукт груп
     * 
     * @param Builder $query
     * @param mixed $sort
     * 
     * @return Builder
     */
    public function apply(Builder $query, mixed $product_group_name): Builder
    {
        $product_group_id = ProductGroup::where('name', $product_group_name)->firstOrFail()->id; // сортировка по имени группы

        $query = $query->where('product_group_id', $product_group_id);
        return $query;
    }
}