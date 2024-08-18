<?php

namespace App\Interfaces;

use App\Models\Contact;

interface IPhonebookRepository {
    public function GetContactById(int $contactId): Contact;
    public function DeleteContact(Contact $contact): void;
}
