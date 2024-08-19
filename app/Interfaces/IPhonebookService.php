<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IPhonebookService {
    public function GetContacts(): Collection;
    public function ValidateImage(String $image): void;
    public function AddContact(array $contactData): void;
    public function DeleteContact(int $contactId): void;
}
