<?php

namespace App\Filters\Product\Filters;

use App\Filters\Contracts\FilterInterface;
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
    public function apply(Builder $query, mixed $product_group_id): Builder
    {
        $query = $query->where('product_group_id', $product_group_id);
        return $query;
    }
}