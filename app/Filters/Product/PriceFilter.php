<?php

namespace App\Filters\Product;

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
        $min = $priceRange['min'];
        $max = $priceRange['max'];

        if(!empty($min) && empty($max)){
            $query = $query->whereBetween('price', [$min, $max]);
        }

        if(!empty($min)){
            $query = $query->where('price', '>=', $min);
        }

        if(!empty($max)){
            $query = $query->where('price', '<=', $max);
        }

        return $query;
    }
}
