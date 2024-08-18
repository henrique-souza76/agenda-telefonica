<?php

namespace App\Repositories;

use App\Interfaces\IPhonebookRepository;
use App\Models\Contact;

class PhonebookRepository implements IPhonebookRepository {

    public function GetContactById(int $contactId): Contact
    {
        return Contact::findOrFail($contactId);
    }

    public function DeleteContact(Contact $contact): void
    {
        $contact->delete();
    }

}
