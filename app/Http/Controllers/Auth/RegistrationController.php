<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;
use Whoops\Exception\Formatter;

use function Laravel\Prompts\form;

class RegistrationController extends Controller
{
    /**
     * Регистрация пользователя
     * 
     * @param RegisterRequest $request
     * 
     * @return Response
     */
    #[OA\Post(
        path: '/api/auth/register',
        summary: "Регистрация пользователя",
        description: 'Регистрация пользователя',
        tags: ['Registration'],
        security: [],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                type:"object",
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password"
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: "Успешная регистрация пользователя",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "User created"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNPROCESSABLE_ENTITY,
                description: "Ошибка валидации",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "errors",
                            type: "object"
                        )
                    ]
                )
            ),
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            User::create($data);
            return response()->json(["message" => "User created"], Response::HTTP_CREATED);
    }
}
