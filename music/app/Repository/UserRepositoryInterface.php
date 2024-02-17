<?php

namespace App\Repository;

use App\DataTransferObjects\UserDto;

interface UserRepositoryInterface {

    public function getById(int $userId);

    public function getByEmail(string $email);

    /**
     * save user entity in db
     * @return int user_id
     */
    public function create(string $name, string $password, string $email, string $role): int;
    public function delete(int $userId): bool;
    public function update(int $userId, string $name, string $email, string $role): bool;

    // public function makeUserArtist(int $userId): int;
}
