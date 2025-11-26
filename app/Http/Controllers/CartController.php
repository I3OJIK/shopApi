<?php

namespace App\Http\Controllers;

use App\Data\Responses\Cart\CartData;
use App\Services\CartService;
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
    public function index()
    {
        $cart = $this->cartService->getCart();
        return CartData::from($cart);
    }
}