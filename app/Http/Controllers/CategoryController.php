<?php

namespace App\Http\Controllers;

use App\Data\Responses\Category\CategoryWithChildrenData;
use App\Services\CategoryService;
use OpenApi\Attributes as OA;


class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    )
    {}


    
    public function index()
    {
        $cat = $this->categoryService->getCategoriesTree();
        return CategoryWithChildrenData::collect($cat);
    }

    
    public function show(int $id)
    {
       
    }
}