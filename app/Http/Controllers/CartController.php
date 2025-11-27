<?php

namespace App\Http\Controllers;

use App\Data\Requests\Cart\AddItemData;
use App\Data\Requests\Cart\UpdateItemQuantityData;
use App\Data\Responses\Cart\CartData;
use App\Exceptions\InsufficientStockException;
use App\Services\CartService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;


class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    )
    {}

    #[OA\Get(
        path: "/api/cart",
        summary: "Корзина",
        description: "Возвращает информацию о товарах находящихся в корзине",
        tags: ["Cart"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Успешное получение корзины",
                content: new OA\JsonContent(ref: '#/components/schemas/CartData')
            ),
            new OA\Response(
                response: Response::HTTP_UNAUTHORIZED,
                description: "Unauthorized – токен отсутствует, невалиден или истёк",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string",
                            example: "Token is null")
                    ]
                )
            ),
        ]
    )]
    public function index(): CartData
    {
        $cart = $this->cartService->getUserCartWithProduct();
        return CartData::from($cart);
    }


     #[OA\Post(
        path: "/api/cart/items",
        summary: "Добавить товар в корзину", 
        tags: ["Cart"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/AddItemData')
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: "Товар добавлен в корзину",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Product added")
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNPROCESSABLE_ENTITY,
                description: "Недостаточно товара в наличии",
                content: new OA\JsonContent(
                    type: "object", 
                    properties: [
                        new OA\Property(property: "error", type: "string"),
                        new OA\Property(property: "details", type: "object")
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Товар не найден",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Product not found")
                    ]
                )
            )
        ]
    )]
    public function addItem(AddItemData $data): JsonResponse
    {
        try {
            $this->cartService->addItem($data);
            return response()->json(["message" => "Product added"], Response::HTTP_CREATED);
        } catch (InsufficientStockException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'details' => [
                    'available_stock' => $e->getAvailableStock()
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }
    }


    #[OA\Patch(
        path: "/api/cart/items/{id}",
        summary: "Изменить количество товара в корзине", 
        tags: ["Cart"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID элемента в корзине",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateItemQuantityData')
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Кол-во товара обновлено",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Quantity updated")
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNPROCESSABLE_ENTITY,
                description: "Недостаточно товара в наличии",
                content: new OA\JsonContent(
                    type: "object", 
                    properties: [
                        new OA\Property(property: "error", type: "string"),
                        new OA\Property(property: "details", type: "object")
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Товар не найден",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Item not found")
                    ]
                )
            )
        ]
    )]
    public function updateItemQuantity(int $itemId, UpdateItemQuantityData $data): JsonResponse
    {
        try {
            $this->cartService->updateItemQuantity($itemId, $data->quantity);
            return response()->json(["message" => "Quantity updated"], Response::HTTP_OK);
        } catch (InsufficientStockException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'details' => [
                    'available_stock' => $e->getAvailableStock()
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Delete(
        path: "/api/cart/items/{id}",
        summary: "Удалить товар из корзины", 
        tags: ["Cart"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID элемента в корзине",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Товар удален из корзины",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Item deleted")
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Товар не найден",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Item not found")
                    ]
                )
            )
        ]
    )]
    public function deleteItem(int $itemId): JsonResponse
    {
        try {
            $this->cartService->deleteItem($itemId);
            return response()->json(["message" => "Item deleted"], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Patch(
        path: "/api/cart/items/{id}/select",
        summary: "Выбрать/отменить выделение товара в корзине", 
        tags: ["Cart"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID элемента в корзине",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Изменено состояние товара (выбран/не выбран)",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Item select change")
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Товар не найден",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Item not found")
                    ]
                )
            )
        ]
    )]
    public function selectItem(int $itemId): JsonResponse
    {
        try {
            $this->cartService->selectItem($itemId);
            return response()->json(["message" => "Item select change"], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[OA\Post(
        path: "/api/cart/items/select-all",
        summary: "Выбрать/отменить выбор всех товаров в корзине", 
        tags: ["Cart"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Товары изменили состояние выбраны/не выбраны все",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Items select change")
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Корзина не найдена",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Cart not found")
                    ]
                )
            )
        ]
    )]
    public function selectAllItems(): JsonResponse
    {
        try {
            $this->cartService->selectAllItems();
            return response()->json(["message" => "Items select change"], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cart not found'], Response::HTTP_NOT_FOUND);
        }
    }
}