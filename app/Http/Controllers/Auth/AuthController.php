<?php

namespace App\Http\Controllers\Auth;

use App\Data\Models\UserData;
use App\Data\Requests\Auth\LoginData;
use App\Exceptions\InvalidPasswordException;
use App\Exceptions\RefreshTokenNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use App\Services\Auth\CookieService;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected CookieService $cookieService
    )
    {}

    /**
     * Авторизация пользователя
     * 
     * @param LoginRequest $request
     * 
     * @return Response
     */
    #[OA\Post(
        path: '/api/auth/login',
        summary: "Авторизация пользователя",
        description: 'Авторизация пользователя и получение пары токенов Access/Refresh',
        tags: ['Auth'],
        security: [],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: "#/components/schemas/LoginData"
            )
        ),
        responses:[
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Успешная авторизация",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "access_token",
                            type: "string",
                        )
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNAUTHORIZED,
                description: "Неверный пароль",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string",
                            example: "Invalid password"
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
                            type: "object",
                        )
                    ]
                )
            ),
        ]
    )]
    public function login(LoginData $data): JsonResponse
    {
        try {
            $jwtTokens =$this->authService->login($data->email,$data->password);

            $cookie = $this->cookieService->makeRefreshCookie($jwtTokens['refreshToken']);
            
            return response()->json(['access_token' => $jwtTokens['accessToken']])->withCookie($cookie);
        } catch (InvalidPasswordException $e){
            return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_UNAUTHORIZED);
        }
        
    }

    #[OA\Post(
        path: "/api/auth/logout",
        summary: "Logout пользователя",
        description: "Logout пользователя",
        tags: ["Auth"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Успешный logout пользователя",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Logged out successfully"
                        )
                    ]
                )
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
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: "Неверная сигнатура токена",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string",
                            example: "Signature verification failed")
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Токен не найден",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string",
                            example: "Token not found in DB"
                        )
                    ]
                )
            ),
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        try {
            $payload = $request->attributes->get('jwt_payload');
            $this->authService->logout($payload->sub);
            return response()->json(['message' => 'Logged out successfully'])->withoutCookie('refresh_token');
        } catch(ModelNotFoundException $e){
            return response()->json(['error' => 'Token not found in DB'], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    #[OA\Post(
        path: "/api/auth/refresh",
        summary: "Обновление access токена",
        description: "Обновление access токена",
        tags: ["Auth"],
        security: [],
        responses: [
            new OA\Response(
                response: JsonResponse::HTTP_OK,
                description: "Новый access token",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "access_token",
                            type: "string",
                        )
                    ]
                )
            ),
            new OA\Response(
                response: JsonResponse::HTTP_UNAUTHORIZED,
                description: "Refresh токен не найден, не валиден или истек",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string",
                        )
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: "Неверная сигнатура токена",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string",
                            example: "Signature verification failed")
                    ]
                )
            ),
        ]
    )]
    public function refresh(Request $request): JsonResponse
    {
        try {
            $refreshToken = $request->cookie('refresh_token');

            if(!$refreshToken){
                return response()->json(['error' => "Refresh token is null"], JsonResponse::HTTP_UNAUTHORIZED);
            }
            $token = $this->authService->refresh($refreshToken);
            return response()->json(['access_token' => $token]);

        } catch (ExpiredException $e) {
            return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_UNAUTHORIZED);
        } catch (SignatureInvalidException $e) {
            return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_UNAUTHORIZED);
        } catch (RefreshTokenNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    #[OA\Get(
        path: "/api/auth/me",
        summary: "Информация о пользователе",
        description: "Информация о пользователе",
        tags: ["Auth"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: "Информация об авторизованном пользователе",
                content: new OA\JsonContent(
                   ref: "#/components/schemas/UserData"
                )
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
    public function me(Request $request): UserData
    {
        return UserData::from($request->user());
    }

}
