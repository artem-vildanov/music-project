<?php


namespace App\Repository;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\ArtistDto;
use App\DataTransferObjects\SignupDto;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    public function getById($userId)
    {
        // TODO: Implement getById() method.
    }

    public function create(SignupDto $signupDto): int
    {
        return DB::table('users')->insertGetId([
            'name' => $signupDto->name,
            'email' => $signupDto->email,
            'password' => $signupDto->password,
            'role' => $signupDto->role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function getByEmail($email) {
        $user = DB::table('users')->where('email', $email)->first();
        return $user;
    }

    public function delete(SignupDto $signupDto)
    {
        // TODO: Implement delete() method.
    }

    public function update(SignupDto $signupDto)
    {
        // TODO: Implement update() method.
    }
}


