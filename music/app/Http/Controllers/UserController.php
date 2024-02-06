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

        // $data['password'] = Hash::make($data['password']);

        $signupDto = new SignupDto();
        $signupDto->name = $data['name'];
        $signupDto->email = $data['email'];
        $signupDto->role = 'base_user';
        $signupDto->password = Hash::make($data['password']);

//        $user = User::where('email', $data['email']) -> first();
//        if ($user)
//            return response(['message' => 'User with this email already exists'], 409);

        // $user = User::create($data);

        if ($this->userRepository->getByEmail($signupDto->email)) {
            return response(['message' => 'User with this email already exists'], 409);
        }

        $userId = $this->userRepository->create($signupDto);

        $token = auth()->tokenById($userId);

        return response(['access_token' => $token]);
    }

    public function becameArtist() {

    }

}
