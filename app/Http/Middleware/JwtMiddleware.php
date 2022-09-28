<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

        } catch (\Exception $exception) {

            if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'redirect' => true,
                    'message' => 'Sessão inválida, Realizar login novamente.'
                ], Response::HTTP_UNAUTHORIZED);
            } else if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'redirect' => true,
                    'message' => 'Sessão expirada, realizar login novamente.'
                ], Response::HTTP_FORBIDDEN);
            } else {
                return response()->json(['message' => 'Você precisa realizar login.'], Response::HTTP_FORBIDDEN);
            }
        }

        return $next($request);
    }
}
