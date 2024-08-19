<?php

namespace App\Interfaces;

use App\Models\Contact;

interface IPhonebookRepository {
    public function GetContactById(int $contactId): Contact;
    public function AddContact(array $contactData): void;
    public function EditContact(Contact $contact, array $contactData): void;
    public function DeleteContact(Contact $contact): void;
}
