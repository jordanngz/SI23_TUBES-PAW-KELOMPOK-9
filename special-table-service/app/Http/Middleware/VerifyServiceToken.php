<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyServiceToken
{
    /**
     * Verify that the incoming request contains the correct pre-shared Bearer token.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token || $token !== config('app.service_token')) {
            return response()->json([
                'error'   => 'Unauthorized',
                'message' => 'Invalid or missing service token.',
            ], 401);
        }

        return $next($request);
    }
}
