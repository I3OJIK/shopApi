<?php
namespace App\Services\Jwt;

use App\Models\Token;
use App\Models\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use stdClass;

class JwtTokenService
{

    protected string $secret;
    protected int $accessTtl;
    protected int $refreshTtl;

    public function __construct()
    {
        $this->secret     = env('JWT_SECRET', 'secret');
        $this->accessTtl  = (int) env('JWT_ACCESS_TTL', 600);
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
            'role' => $user->role,
            'type' => 'access',
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
            'email' => $user->email,
            'role' => $user->role,
            'type' => 'refresh',
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

    /**
     * Првоерка access токена на валидность
     * 
     * @param string $token
     * 
     * @return stdClass
     */
    public function validateAccessToken(string $token): stdClass
    {
        try{

            $payload = JWT::decode($token, new Key( env('JWT_SECRET'), 'HS256'));
            return $payload;
        } catch (ExpiredException $e) {
            throw new \Exception($e->getMessage(), 401);
        } catch (SignatureInvalidException $e) {
            throw new \Exception($e->getMessage(), 401);
        } catch (\UnexpectedValueException $e) {
            throw new \Exception($e->getMessage(), 400);
        }
    }

    /**
     * валидация рефреш токена
     * 
     * @param string $refreshToken
     * 
     * @return stdClass
     */
    public function validateRefreshToken(string $refreshToken): stdClass
    {
        try{

            $payload = JWT::decode($refreshToken, new Key( env('JWT_SECRET'), 'HS256'));
            $storedToken = Token::where('user_id', $payload->sub)->first();
            // Проверка типа токена
            if (!isset($payload->type) || $payload->type !== 'refresh') {
                throw new \Exception('Invalid token type', 401);
            }
            if (!$storedToken || $storedToken->refresh_token !== $refreshToken) {
                throw new \Exception('Refresh token not found in database', 401);
            }

            return $payload;
        } catch (ExpiredException $e) {
            throw new \Exception($e->getMessage(), 401);
        } catch (SignatureInvalidException $e) {
            throw new \Exception($e->getMessage(), 401);
        } catch (\UnexpectedValueException $e) {
            throw new \Exception($e->getMessage(), 400);
        }
    }

    /**
     * Удаление рефреш токена
     * 
     * @param int $userId
     * 
     * @return void
     */
    public function deleteToken(int $userId): void
    {
            $result = Token::where('user_id', $userId)->delete();

            if($result == 0){
                throw new \Exception('Token not found', 400);
            }
    }
}