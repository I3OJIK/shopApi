<?php

namespace App\Http\Controllers;

use App\Data\Requests\Product\CategoryProductFilterData;
use App\Data\Responses\CategoryProduct\CategoryProductData;
use App\Data\Responses\Product\Views\ProductListData;
use App\Services\CategoryProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use OpenApi\Attributes as OA;


class CategoryProductController extends Controller
{
    public function __construct(
        private CategoryProductService $categoryProductService
    )
    {}


    #[OA\Get(
        path: '/api/categories/{id}/products',
        summary: 'Каталог товаров в выбранной категории',
        description: 'Возвращает список продуктов выбранной категории с фильтрацией, поиском и сортировкой, и подкатегории - если есть',
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID категории",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
            ),
            new OA\Parameter(
                name: 'filter',
                in: 'query',
                required: false,
                description: 'Фильтры для поиска продуктов',
                schema: new OA\Schema(ref: '#/components/schemas/ProductFilterData')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Список продуктов выбранной категории',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/CategoryProductData')
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Категория не найдена",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Сategory not found")
                    ]
                )
            ),
        ]
    )]
    public function index(int $categoryId, CategoryProductFilterData $data)
    {
        try {
            $result = $this->categoryProductService->getCategoryProducts($categoryId, $data);
    
            return CategoryProductData::fromModel(
                $result['category'],
                $result['products']
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }
    }
    
}