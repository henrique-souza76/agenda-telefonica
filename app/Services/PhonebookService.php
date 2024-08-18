<?php

namespace App\Services;

use App\Interfaces\IPhonebookRepository;
use App\Interfaces\IPhonebookService;
use App\Models\Contact;
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

    /**
     * Returns data used by the phonebook view
     *
     * @return array
     */
    public function GetViewData(): array
    {
        $data['user_name'] = Auth::user()->name;
        $data['contacts'] = $this->GetContacts();

        return $data;
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
