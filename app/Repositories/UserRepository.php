<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;

class UserRepository implements IUserRepository {

    public function CreateUser(array $userInfo): void
    {
        User::create([
            "name" => $userInfo['name'],
            "phone" => $userInfo['phone'],
            "password" => $userInfo['password'],
        ]);
    }

}
