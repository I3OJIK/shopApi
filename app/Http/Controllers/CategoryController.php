<?php

namespace App\Http\Controllers;

use App\Data\Responses\Category\CategoryWithChildrenData;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;


class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    )
    {}


    #[OA\Get(
        path: '/api/categories',
        summary: 'Категории',
        description: 'Возвращает список категорий',
        tags: ['Categories'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Список категорий',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/CategoryWithChildrenData')
                )
            ),
        ]
    )]
    public function index()
    {
        $categories = $this->categoryService->getCategoriesTree();
        return CategoryWithChildrenData::collect($categories);
    }

    #[OA\Get(
        path: "/api/categories/{id}",
        summary: "Получить категорию и ее подкатегории (если есть)",
        description: "Возвращает информацию о категории",
        tags: ["Categories"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID категории",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Успешное получение категории",
                content: new OA\JsonContent(ref: '#/components/schemas/CategoryWithChildrenData')
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
    public function show(int $id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return CategoryWithChildrenData::fromModel($category);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }
       
    }
}