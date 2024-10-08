<?php

namespace App\Services;

use App\Interfaces\IUserRepository;
use App\Interfaces\IUserService;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserService implements IUserService {

    private $userRepository;

    public function __construct(
        IUserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function GetUsers(): Collection
    {
        return $this->userRepository->GetUsers();
    }

    public function GetPhoneNumbers(): Collection
    {
        return $this->userRepository->GetPhoneNumbers();
    }

    public function CreateUser(array $userInfo): void
    {
        try {

            $this->userRepository->CreateUser($userInfo);

        } catch(Exception $e) {

            throw new Exception($e->getMessage(), 500);

        }
    }
}
