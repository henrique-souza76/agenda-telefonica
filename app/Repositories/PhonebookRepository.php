<?php

namespace App\Repositories;

use App\Interfaces\IPhonebookRepository;
use App\Models\Contact;

class PhonebookRepository implements IPhonebookRepository {

    public function GetContactById(int $contactId): Contact
    {
        return Contact::findOrFail($contactId);
    }

    public function AddContact(array $contactData): void
    {
        Contact::create($contactData);
    }

    public function EditContact(Contact $contact, array $contactData): void
    {
        $contact->name = $contactData['name'];
        $contact->phone = $contactData['phone'];
        $contact->email = $contactData['email'];
        $contact->image = $contactData['image'];
        $contact->save();
    }

    public function DeleteContact(Contact $contact): void
    {
        $contact->delete();
    }

}
