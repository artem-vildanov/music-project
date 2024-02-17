<?php


namespace App\Repository;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\ArtistDto;
use App\DataTransferObjects\UserDto;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function getById($userId)
    {
        // TODO: Implement getById() method.
    }

    public function create(string $name, string $password, string $email, string $role): int
    {
        $user = new User;
        $user->name = $name;
        $user->password = $password;
        $user->email = $email;
        $user->role = $role;
        $user->save();

        return $user->id;

//        return DB::table('users')->insertGetId([
//            'name' => $name,
//            'email' => $email,
//            'password' => $password,
//            'role' => $role,
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);
    }

    public function getByEmail(string $email): User|null
    {
        return User::query()->where('email', $email)->first();
        // return DB::table('users')->where('email', $email)->first();
    }

    public function delete(int $userId): bool
    {
        // TODO: Implement delete() method.
    }

    public function update(int $userId, string $name, string $email, string $role): bool
    {
        $user = User::query()->find($userId);

        $user->name = $name;
        $user->email = $email;
        $user->role = $role;

        return $user->save();

//        return DB::table('users')->where('id', $userId)->update([
//            'name' => $name ,
//            'email' => $email,
//            'role' => $role,
//        ]);
    }
}


