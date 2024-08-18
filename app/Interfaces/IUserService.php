<?php

namespace App\Interfaces;

interface IUserService {
    public function CreateUser(array $userInfo): void;
}
