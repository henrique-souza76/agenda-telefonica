<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IUserService {
    public function GetUsers(): Collection;
    public function GetPhoneNumbers(): Collection;
    public function CreateUser(array $userInfo): void;
}
