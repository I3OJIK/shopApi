<?php

namespace App\Http\Middleware\Auth;

use App\Models\User;
use App\Services\Jwt\JwtTokenService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JwtAuthMiddleware
{

    public function __construct(protected JwtTokenService $jwt) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if(!$token){
            return new Response(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $payload = $this->jwt->validateToken($token);
            $request->attributes->set('jwt_payload', $payload);
        } catch (\Exception $e) {

            return new Response(['error' => $e->getMessage()],$e->getCode());
        }
        return $next($request);
    }
}
