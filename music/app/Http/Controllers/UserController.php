<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\SignupDto;
use App\Http\Requests\User\SignupRequest;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function signup(SignupRequest $request) {
        $data = $request->validated();

        $signupDto = new SignupDto();
        $signupDto->name = $data['name'];
        $signupDto->email = $data['email'];
        $signupDto->role = 'base_user';
        $signupDto->password = Hash::make($data['password']);

        if ($this->userRepository->getByEmail($data['email']))
            return response(['message' => 'User with this email already exists'], 409);


        // TODO в каком формате передавать данные в create()? signupDto или data?
        $userId = $this->userRepository->create($signupDto);

        return response([
            'access_token' => auth()->tokenById($userId)
        ]);
    }
}
