<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function signup(CreateUserRequest $request): JsonResponse
    {
        $data = $request->body();

        $userId = $this->userRepository->create(
            $data->name,
            Hash::make($data->password),
            $data->email,
            'base_user',
        );

        return response()->json([
            'access_token' => auth()->tokenById($userId)
        ]);
    }
}
