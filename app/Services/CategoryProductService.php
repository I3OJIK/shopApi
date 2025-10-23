<?php

namespace App\Services;

use App\Data\Requests\Product\CategoryProductFilterData;
use App\Filters\Product\CategoryProductFilter;
use App\Filters\Product\ProductListFilter;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryProductService
{

    public function __construct(
        private CategoryProductFilter $categoryProductFilter
    )
    {}


    public function getCategoryProducts(int $categoryId, CategoryProductFilterData $data): array
    {
        $category = Category::findOrFail($categoryId);
        $query = $category->products()->with('productGroup.category');

        $this->categoryProductFilter->apply($query, $data->toArray());

        return [
            'category' => $category,
            'products' => $query->paginate($data->perPage),
        ];

    }


}