<?php

namespace App\Http\Controllers\Auth;

use App\Data\Requests\Auth\RegisterData;
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
                ref: "#/components/schemas/RegisterData"
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
    public function register(RegisterData $data): JsonResponse
    {
        User::create([
            'name'     => $data->name,
            'email'    => $data->email,
            'password' => Hash::make($data->password),
        ]);
        
        return response()->json(["message" => "User created"], Response::HTTP_CREATED);
    }
}
