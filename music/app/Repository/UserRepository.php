<?php


namespace App\Repository;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\ArtistDto;
use App\DataTransferObjects\SignupDto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function getByEmail($email)
    {
        return DB::table('users')->where('email', $email)->first();
    }

    public function delete(SignupDto $signupDto)
    {
        // TODO: Implement delete() method.
    }

    public function update(SignupDto $signupDto)
    {
        // TODO: Implement update() method.
    }

    public function roleArtist($userId): int
    {
        return DB::table('users')->where('id', $userId)->update(['role' => 'artist']);
    }
}


