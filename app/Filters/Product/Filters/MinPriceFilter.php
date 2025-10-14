<?php

namespace App\Filters\Product\Filters;

use App\Filters\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class MinPriceFilter implements FilterInterface 
{
    /**
     * Сортировка по цене (мин макс цена)
     * 
     * @param Builder<Product> $query
     * @param mixed $minPrice
     * 
     * @return Builder
     */
    public function apply(Builder $query, mixed $minPrice): Builder
    {

            $query = $query->where('price', '>=', $minPrice);

        return $query;
    }
}