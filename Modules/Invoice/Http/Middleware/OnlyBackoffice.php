<?php

namespace Modules\Invoice\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnlyBackoffice
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('api_usuarios')->user()) {
            return $next($request);
        }
        return new JsonResponse([
            'message' => 'Requisição não autorizada.'
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
