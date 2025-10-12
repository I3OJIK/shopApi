<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductGroup;

class ProductController extends Controller
{
    public function __construct(
    )
    {}

    public function index()
    {
        $productGroup = ProductGroup::find(1);
        // dd($productGroup);
        $category = Category::find(1);
        dd($category->children);
    }
}