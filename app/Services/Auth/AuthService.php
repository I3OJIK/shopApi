<?php
namespace App\Services\Auth;

use App\Models\User;
use App\Services\Jwt\JwtTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private JwtTokenService $jwt)
    {} 

    public function login(string $email, string $password): array
    {
        $user = User::where('email',$email)->first();
            if(!$user){
                throw new \Exception('Email not found', 404);
            }

            if(!Hash::check($password,$user->password)){
                throw new \Exception('Invalid password', 400);
            }
            // Генерация пары токенов
            $jwtTokens = $this->jwt->generateTokenPair($user);
            // Запись токена в БД
            
            $this->jwt->saveToken($user->id, $jwtTokens['refreshToken']);

            return $jwtTokens;
    }

    public function logout(int $userId)
    {
        $this->jwt->deleteToken($userId);
    }

    public function refresh(string $refreshToken): ?string
    {
        $payload = $this->jwt->validateRefreshToken($refreshToken);
        $user = User::find($payload->sub);
        $accessToken = $this->jwt->generateAccessToken($user);
        return $accessToken;
    }
}