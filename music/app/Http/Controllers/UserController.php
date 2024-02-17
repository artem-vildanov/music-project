<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserDto;
use App\Http\Requests\User\CreateUserRequest;
use App\Repository\UserRepositoryInterface;
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

        // TODO email check middleware
        if ($this->userRepository->getByEmail($data->email))
            return response()->json([
                'message' => 'User with this email already exists'
            ], 409);
        // TODO email check middleware

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
