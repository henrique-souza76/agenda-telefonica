<?php

namespace App\Services;

use App\Interfaces\IPhonebookRepository;
use App\Interfaces\IPhonebookService;
use Exception;
use Faker\Calculator\Ean;
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

    public function ValidateImage(String $image): void
    {
        $type = substr($image, 0, 11);
        $expectedType = "data:image/";

        $base64Data = substr($image, strpos($image, ',') + 1);
        $sizeInBytes = (int)(strlen($base64Data) * 3 / 4);
        $maxSizeInBytes = 2 * 1024 * 1024;

        if(strcmp($type, $expectedType) || $sizeInBytes > $maxSizeInBytes) {
            throw new Exception("Erro na validação da imagem.", 400);
        }
    }

    public function AddContact(array $contactData): void
    {
        try {

            $contactData['creator_user_id'] = Auth::user()->id;

            $this->phonebookRepository->AddContact($contactData);

        } catch(Exception $e) {

            throw new Exception($e->getMessage(), 500);

        }
    }

    public function DeleteContact(int $contactId): void
    {
        try {

            $contact = $this->phonebookRepository->GetContactById($contactId);

            $this->phonebookRepository->DeleteContact($contact);

        } catch(Exception $e) {

            throw new Exception($e->getMessage(), 500);

        }
    }
}
