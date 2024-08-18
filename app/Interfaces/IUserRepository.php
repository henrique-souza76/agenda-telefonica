<?php

namespace App\Interfaces;

interface IUserRepository {
    public function CreateUser(array $userInfo): void;
}
