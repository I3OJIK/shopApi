<?php

namespace App\Services;

use App\Data\Requests\Product\ProductFilterData;
use App\Filters\Product\BaseProductFilter;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{

    public function __construct(
        private BaseProductFilter $filter
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
            ->with(['variants.attributeValues.attribute', 'category']);

        $this->filter->apply($query, $data->toArray());

        return $query->paginate($data->perPage);
    }
}