<?php

namespace App\Repository;

use App\DataTransferObjects\SignupDto;

interface UserRepositoryInterface {

    public function getById($userId);

    public function getByEmail($email);

    public function create(SignupDto $signupDto);
    public function delete(SignupDto $signupDto);
    public function update(SignupDto $signupDto);



}
