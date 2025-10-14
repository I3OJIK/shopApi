<?php

namespace App\Filters\Product;

use App\Filters\Product\Abstracts\BaseFilter;
use App\Filters\Product\Filters\MaxPriceFilter;
use App\Filters\Product\Filters\MinPriceFilter;
use App\Filters\Product\Filters\SearchFilter;
use App\Filters\Product\Filters\SortFilter;

class ProductListFilter extends BaseFilter
{
    protected array $filters = [
        'search' => SearchFilter::class,
        // 'attributes' => AttributeFilter::class,
        'minPrice' => MinPriceFilter::class,
        'maxPrice' => MaxPriceFilter::class,
        'sort' => SortFilter::class,
    ];


}