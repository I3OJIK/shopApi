<?php

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements FilterInterface 
{
    /**
     * Поиск по name
     * 
     * @param Builder $query
     * @param mixed $searchTerm
     * 
     * @return Builder
     */
    public function apply(Builder $query, mixed $searchTerm): Builder
    {
        return $query->where('name', 'LIKE', "%{$searchTerm}%");
    }
}
