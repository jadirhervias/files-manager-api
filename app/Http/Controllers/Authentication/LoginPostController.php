<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginPostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                return response()->json([
                    'error' => 'Invalid credentials'
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'Logged successfully',
            'token' => $token,
        ], JsonResponse::HTTP_OK);
    }
}
