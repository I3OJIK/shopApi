<?php

namespace App\Filters\Product\Filters;

use App\Filters\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class MaxPriceFilter implements FilterInterface 
{
    /**
     * Сортировка по цене (макс цена)
     * 
     * @param Builder<Product> $query
     * @param mixed $maxPrice
     * 
     * @return Builder
     */
    public function apply(Builder $query, mixed $maxPrice): Builder
    {
        $query = $query->where('price', '<=', $maxPrice);
        return $query;
    }
}