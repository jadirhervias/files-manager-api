<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use FilesManager\User\Application\Create\CreateUserRequest;
use FilesManager\User\Application\Create\UserCreator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class RegisterPostController extends Controller
{
    public function __construct(private readonly UserCreator $creator)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = $this->creator->__invoke(new CreateUserRequest(
            $request->input('name'),
            $request->input('email'),
            Hash::make($request->input('password')),
        ));

        $userModel = app(User::class)->newInstance($user->toPrimitives());
        $token = JWTAuth::fromUser($userModel);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->toPrimitives(),
            'token' => $token
        ], JsonResponse::HTTP_CREATED);
    }
}
