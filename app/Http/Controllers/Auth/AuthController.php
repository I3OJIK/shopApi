<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use App\Services\Auth\CookieService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function login(LoginRequest $request): Response
    {
        try {
            $data = $request->validated();
            $jwtTokens =$this->authService->login($data['email'],$data['password']);
            // создание куки для ревреш токена
            $cookie = $this->cookieService->makeRefreshCookie($jwtTokens['refreshToken']);
            
            return new Response(['access_token' => $jwtTokens['accessToken']])->withCookie($cookie);
        } catch(\Exception $e){
            
            return new Response(['errors' => $e->getMessage()],$e->getCode());
        } 
        
    }


    public function logout(Request $request): Response
    {
        try {
            $payload = $request->attributes->get('jwt_payload');
            $this->authService->logout($payload->sub);
            return new Response(['message' => 'Logged out successfully'])->withoutCookie('refresh_token');
        } catch(\Exception $e){
            
            return new Response(['errors' => $e->getMessage()],$e->getCode());
        }
    }

    public function refresh(Request $request): Response
    {
        try {
            $refreshToken = $request->cookie('refresh_token');
            if(!$refreshToken){
                throw new \Exception("Refresh token is null", 401);
            }
            $token = $this->authService->refresh($refreshToken);
            return new Response(['access_token' => $token]);
        } catch(\Exception $e){
            
            return new Response(['error' => $e->getMessage()],$e->getCode());
        }
    }

    public function me(Request $request): Response
    {
        try {
            $user = $request->user();
            return new Response(['user' => $user]);
        } catch(\Exception $e){
            
            return new Response(['error' => $e->getMessage()],$e->getCode());
        }
    }

}
