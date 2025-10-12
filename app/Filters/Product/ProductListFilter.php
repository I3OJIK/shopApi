<?php

namespace App\Filters\Product;

use App\Filters\Product\Abstracts\BaseFilter;
use App\Filters\Product\Filters\PriceFilter;
use App\Filters\Product\Filters\SearchFilter;
use App\Filters\Product\Filters\SortFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductListFilter extends BaseFilter
{
    protected array $filters = [
        'search' => SearchFilter::class,
        // 'attributes' => AttributeFilter::class,
        'priceRange' => PriceFilter::class,
        'sort' => SortFilter::class,
    ];


}