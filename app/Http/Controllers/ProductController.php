<?php

namespace App\Http\Controllers;

use App\Data\Requests\Product\ProductFilterData;
use App\Data\Responses\Product\ProductData;
use App\Data\Responses\Product\ProductListData;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    )
    {}

    public function index(ProductFilterData $data)
    {
        $products = $this->productService->list($data);

    }
}
