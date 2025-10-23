<?php

namespace App\Http\Controllers;

use App\Data\Requests\Product\ProductFilterData;
use App\Data\Requests\Product\ProductIdData;
use App\Data\Responses\Product\Views\ProductListData;
use App\Data\Responses\Product\Views\ProductShowData;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use OpenApi\Attributes as OA;


class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    )
    {}


    #[OA\Get(
        path: '/api/products',
        summary: 'Каталог товаров',
        description: 'Возвращает список продуктов с фильтрацией, поиском и сортировкой',
        tags: ['Products'],
        parameters: [
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
                description: 'Список продуктов',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/ProductListData')
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNPROCESSABLE_ENTITY,
                description: "Ошибка валидации",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "The given data was invalid."
                        ),
                        new OA\Property(
                            property: "errors",
                            type: "object",
                            additionalProperties: new OA\AdditionalProperties(
                                type: "array",
                                items: new OA\Items(type: "string")
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function index(ProductFilterData $data): LengthAwarePaginator
    {
        $products = $this->productService->getProducts($data);

        return ProductListData::collect($products);
    }

    #[OA\Get(
        path: "/api/products/{id}",
        summary: "Получить карточку товара с вариантами",
        description: "Возвращает информацию о товаре, его доступные варианты и дерево категорий",
        tags: ["Products"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID товара",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Успешное получение товара",
                content: new OA\JsonContent(ref: '#/components/schemas/ProductShowData')
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Товар не найден",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Product not found")
                    ]
                )
            ),
        ]
    )]
    public function show(int $id): ProductShowData|JsonResponse
    {
        try {
            $productWithVariants = $this->productService->getProductWithVariants($id);
            return ProductShowData::fromModelWithVariants($productWithVariants);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }
}