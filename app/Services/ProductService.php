<?php

namespace App\Services;

use App\Data\Requests\Product\ProductFilterData;
use App\Filters\Product\BaseProductFilter;
use App\Filters\Product\ProductListFilter;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{

    public function __construct(
        private ProductListFilter $ProductListFilter
    )
    {}
    /**
     * Вывод продуктов с пагинацией и фильтраицей
     * 
     * @param ProductFilterData $data
     * @param BaseProductFilter $filter
     * 
     * @return LengthAwarePaginator
     */
    public function list(ProductFilterData $data): LengthAwarePaginator
    {
        $query = Product::query()
            ->with(['productGroup', 'productGroup.category']);

        $this->ProductListFilter->apply($query, $data->toArray());

        return $query->paginate($data->perPage);
    }
}