<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IPhonebookService {
    public function GetViewData(): array;
    public function GetContacts(): Collection;
    public function DeleteContact(int $contactId): void;
}
