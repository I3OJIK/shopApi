<?php

namespace App\Services;

use App\Data\Responses\Product\Show\ProductShowData;
use App\Filters\Product\ProductListFilter;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Категории родители с дочерними категорряими
     * 
     * @return Collection
     */
    public function getCategoriesTree(): Collection
    {
        return Category::whereNull('parent_id')
            ->with('children')
            ->get();
    }


    /**
     * @param mixed $id
     * 
     * @return Category
     */
    public function getCategoryById($id): Category
    {
        return Category::with('children')->findOrFail($id);
    }

    // public function findWithVariants(int $id): Product
    // {
    //     return Product::with([
    //         'productGroup', 
    //         'productGroup.category',
    //         'productGroup.products'
    //     ])->findOrFail($id);
    // }
}