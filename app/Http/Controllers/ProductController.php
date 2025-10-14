<?php

namespace App\Http\Controllers;

use App\Data\Requests\Product\ProductFilterData;
use App\Data\Responses\Product\ProductListData;
use App\Services\ProductService;
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
        
        $products = $this->productService->list($data);
        return ProductListData::collect($products);
    }
}