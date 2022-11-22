<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPostRequest;
use App\Models\User;
use FilesManager\User\Application\Create\CreateUserRequest;
use FilesManager\User\Application\Create\UserCreator;
use Illuminate\Http\JsonResponse;
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
     * @param RegisterPostRequest $request
     * @return JsonResponse
     */
    public function __invoke(RegisterPostRequest $request): JsonResponse
    {
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
