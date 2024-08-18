<?php

namespace App\Services;

use App\Interfaces\IPhonebookRepository;
use App\Interfaces\IPhonebookService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PhonebookService implements IPhonebookService {

    private $phonebookRepository;

    public function __construct(
        IPhonebookRepository $phonebookRepository
    )
    {
        $this->phonebookRepository = $phonebookRepository;
    }

    public function GetContacts(): Collection
    {
        return Auth::user()->Contacts()->orderBy('name')->get();
    }

    public function DeleteContact(int $contactId): void
    {
        try {

            $contact = $this->phonebookRepository->GetContactById($contactId);

            $this->phonebookRepository->DeleteContact($contact);

        } catch(Exception $e) {

            throw new Exception($e->getMessage(), $e->getCode());

        }
    }
}
