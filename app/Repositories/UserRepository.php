<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements IUserRepository {

    public function GetUsers(): Collection
    {
        return User::all();
    }

    public function GetPhoneNumbers(): Collection
    {
        return User::select('phone')->get();
    }

    public function CreateUser(array $userInfo): void
    {
        User::create($userInfo);
    }

}
