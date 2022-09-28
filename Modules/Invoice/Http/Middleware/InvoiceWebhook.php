<?php

namespace Modules\Invoice\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $webhookToken = config('services.iugu.webhook_token');
        $header = $request->header('authorization', null);

        if (is_array($header) && in_array($webhookToken, $header)) {
            return $next($request);
        } else if (($webhookToken === $header)) {
            return $next($request);
        }

        return response()->json(['message' => 'invalid authorization token.'], Response::HTTP_UNAUTHORIZED);
    }
}
