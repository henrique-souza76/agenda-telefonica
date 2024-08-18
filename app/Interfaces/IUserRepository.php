<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IUserRepository {
    public function GetUsers(): Collection;
    public function GetPhoneNumbers(): Collection;
    public function CreateUser(array $userInfo): void;
}
