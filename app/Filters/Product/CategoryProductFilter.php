<?php

namespace App\Filters\Product;

use App\Filters\Product\Abstracts\BaseFilter;
use App\Filters\Product\Filters\PriceFilter;
use App\Filters\Product\Filters\ProductGroupFilter;
use App\Filters\Product\Filters\SearchFilter;
use App\Filters\Product\Filters\SortFilter;

class CategoryProductFilter extends BaseFilter
{
    protected array $filters = [
        'search' => SearchFilter::class,
        // 'attributes' => AttributeFilter::class,
        'priceRange' => PriceFilter::class,
        'sort' => SortFilter::class,
        'productGroups' => ProductGroupFilter::class, 
    ];
}