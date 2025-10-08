<?php

namespace App\Filters\Product;

use Illuminate\Database\Eloquent\Builder;

class BaseProductFilter
{
    protected array $filters = [
        'search' => SearchFilter::class,
        'categoryId' => CategoryFilter::class,
        'attributes' => AttributeFilter::class,
        'minPrice' => PriceFilter::class,
        'maxPrice' => PriceFilter::class,
        'sort' => SortFilter::class,
    ];

    function apply(Builder $query, array $params): Builder
    {
        foreach ($params as $key => $value) {

            if (isset($this->filters[$key]) && !empty($value)) {
                
                $filter = app($this->filters[$key]);
                $query = $filter->apply($query, $value);
            }
        }

        return $query;
    }
}
