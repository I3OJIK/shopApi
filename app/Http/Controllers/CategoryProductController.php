<?php

namespace App\Http\Controllers;

use App\Data\Requests\Product\CategoryProductFilterData;
use App\Data\Responses\CategoryProduct\CategoryProductData;
use App\Data\Responses\Product\Views\ProductListData;
use App\Services\CategoryProductService;
use Illuminate\Pagination\LengthAwarePaginator;
use OpenApi\Attributes as OA;


class CategoryProductController extends Controller
{
    public function __construct(
        private CategoryProductService $categoryProductService
    )
    {}


   
    public function index(int $categoryId, CategoryProductFilterData $data)
    {
        $result = $this->categoryProductService->getCategoryProducts($categoryId, $data);

        return CategoryProductData::fromModel(
            $result['category'],
            $result['products']
        );
    }
    
}