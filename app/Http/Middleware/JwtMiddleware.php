<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use JWTAuth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $exception) {
            if ($exception instanceof JWTException) {
                return response()->json([
                    'error' => $exception->getMessage()
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'error' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $next($request);
    }
}
