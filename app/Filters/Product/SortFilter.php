<?php

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;

class SortFilter implements FilterInterface 
{

    /**
     * Сортировка по name и price
     * 
     * @param Builder $query
     * @param mixed $sort
     * 
     * @return Builder
     */
    public function apply(Builder $query, mixed $sort): Builder
    {
        return match($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            default => $query
        };
    }
}
