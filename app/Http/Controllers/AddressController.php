<?php

namespace App\Http\Controllers;

use App\Data\Models\AddressData;
use App\Data\Models\ProductData;
use App\Data\Requests\Address\AddressRequest;
use App\Data\Requests\Cart\AddItemData;
use App\Data\Requests\Cart\UpdateItemQuantityData;
use App\Data\Responses\Cart\CartData;
use App\Exceptions\CartEmptyException;
use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use App\Services\AddressService;
use App\Services\CartService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\DataCollection;

class AddressController extends Controller
{
    public function __construct(
        private AddressService $addressService
    )
    {}

    #[OA\Get(
        path: "/api/addresses",
        summary: "Список адресов пользователя",
        tags: ["Addresses"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список адресов",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/AddressData")
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $addresses = $this->addressService->getUserAddresses();

        return response()->json(AddressData::collect($addresses));
    }

    #[OA\Post(
        path: "/api/addresses",
        summary: "Создать новый адрес",
        tags: ["Addresses"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/AddressRequest')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Адрес создан",
                content: new OA\JsonContent(ref: '#/components/schemas/AddressData')
            ),
            new OA\Response(
                response: 422,
                description: "Ошибки валидации",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "The phone field must not be greater than 30."
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
                
            ),
        ]
    )]
    public function store(AddressRequest $data): JsonResponse
    {
        $address = $this->addressService->storeAddress($data);

        return response()->json(AddressData::from($address)
        , Response::HTTP_CREATED);
    }

    #[OA\Put(
        path: "/api/addresses/{id}",
        summary: "Обновить адрес",
        tags: ["Addresses"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/AddressRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Адрес обновлен",
                content: new OA\JsonContent(ref: '#/components/schemas/AddressData')
            ),
            new OA\Response(
                response: 404,
                description: "Адрес не найден",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Address not found")
                    ]
                )
            ),
        ]
    )]
    public function update(AddressRequest $data, int $id): JsonResponse
    {
        try{
            $address = $this->addressService->updateAddress($data, $id);

            return response()->json( AddressData::from($address));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Address not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    #[OA\Delete(
        path: "/api/addresses/{id}",
        summary: "Удалить адрес",
        tags: ["Addresses"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Адрес удален",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Address deleted successfully"),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Адрес не найден",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Address not found")
                    ]
                )
            ),
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        try{
            $this->addressService->deleteAddress($id);

            return response()->json([
                'message' => 'Address deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Address not found'], Response::HTTP_NOT_FOUND);
        }
    }
}