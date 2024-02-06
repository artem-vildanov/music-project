<?php

namespace App\Repository;

use App\DataTransferObjects\SignupDto;

interface UserRepositoryInterface {

    public function getById($userId);

    public function getByEmail($email);

    /**
     * save user entity in db
     * @return int user_id
     */
    public function create(SignupDto $signupDto): int;
    public function delete(SignupDto $signupDto);
    public function update(SignupDto $signupDto);

    /**
     * make a user an artist
     * @return int 1 if success, 0 if failed
     */
    public function roleArtist($userId): int;

}
