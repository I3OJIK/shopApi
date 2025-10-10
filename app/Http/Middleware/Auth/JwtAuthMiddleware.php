<?php

namespace App\Http\Middleware\Auth;

use App\Models\User;
use App\Services\Jwt\JwtTokenService;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\JsonResponse;
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
    public function handle(Request $request, Closure $next): JsonResponse|Response
    {
        $token = $request->bearerToken();

        if(!$token){
            return  response()->json(['error' => 'Token is null'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $payload = $this->jwt->validateAccessToken($token);
            $request->attributes->set('jwt_payload', $payload);
            $request->setUserResolver(function () use ($payload) {
                return User::find($payload->sub);
            });
        } catch (ExpiredException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        } catch (SignatureInvalidException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return $next($request);
    }
}
