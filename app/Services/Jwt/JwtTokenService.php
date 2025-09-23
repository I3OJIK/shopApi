<?php
namespace App\Services\Jwt;

use App\Models\Token;
use App\Models\User;
use Firebase\JWT\JWT;

class JwtTokenService
{

    protected string $secret;
    protected int $accessTtl;
    protected int $refreshTtl;

    public function __construct()
    {
        $this->secret     = env('JWT_SECRET', 'secret');
        $this->accessTtl  = (int) env('JWT_ACCESS_TTL', 3600);
        $this->refreshTtl = (int) env('JWT_REFRESH_TTL', 2592000);
    }


    /**
     * Генерация аксес токена
     * 
     * @param User $user
     * 
     * @return string
     */
    public function generateAccessToken(User $user): string 
    {
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + $this->accessTtl,
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }

    /**
     * Генерация рефреш токена
     * 
     * @param User $user
     * 
     * @return string
     */
    public function generateRefreshToken(User $user): string 
    {
        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + $this->refreshTtl,
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }

    /**
     * Генерация пары токенов (Access, Refresh)
     * 
     * @param User $user
     * 
     * @return array
     */
    public function generateTokenPair(User $user): array
    {
        return [
            'accessToken' => $this->generateAccessToken($user),
            'refreshToken' => $this->generateRefreshToken($user)
        ];
    }

    /**
     * Сохранить или обновить токен в БД для данного пользователя
     * 
     * @param int $id
     * @param string $refreshToken
     * 
     * @return Token
     */
    public function saveToken(int $id, string $refreshToken): Token
    {
        return Token::updateOrCreate(
            ['user_id' => $id],
            ['refresh_token' => $refreshToken]
        );
    }

}