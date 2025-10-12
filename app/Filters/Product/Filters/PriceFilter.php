<?php

namespace App\Filters\Product\Filters;

use App\Filters\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class PriceFilter implements FilterInterface 
{
    /**
     * Сортировка по цене (мин макс цена)
     * 
     * @param Builder<Product> $query
     * @param mixed $priceRange
     * 
     * @return Builder
     */
    public function apply(Builder $query, mixed $priceRange): Builder
    {
        if (!str_contains($priceRange, '-')) {
            return $query;
        }

        [$min, $max] = explode('-', $priceRange);

        if(!empty($min) && !empty($max) && $min<$max){
            $query = $query->whereBetween('price', [$min, $max]);
        }

        return $query;
    }
}