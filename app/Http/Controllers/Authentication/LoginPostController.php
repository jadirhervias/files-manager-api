<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Http\JsonResponse;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginPostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param LoginPostRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginPostRequest $request): JsonResponse
    {
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
