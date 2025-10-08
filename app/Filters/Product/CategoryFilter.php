<?php

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CategoryFilter implements FilterInterface 
{
    /**
     * Фильтрация по id категории
     * 
     * @param Builder $query
     * @param mixed $categoryId
     * 
     * @return Builder
     */
    public function apply(Builder $query, mixed $categoryId): Builder
    {
        return $query->where('category_id', '=', $categoryId);
    }
}
