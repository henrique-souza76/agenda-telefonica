<?php

namespace App\Http\Controllers;

use App\Interfaces\IPhonebookService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PhonebookController extends Controller
{

    private $phonebookService;

    public function __construct(
        IPhonebookService $phonebookService
    )
    {
        $this->phonebookService = $phonebookService;
    }

    public function Index()
    {
        if(!Auth::user())
            return redirect('/login');

        $data = $this->phonebookService->GetViewData();

        return view('phonebook', $data);
    }

    public function GetContacts(): JsonResponse
    {
        $contacts = $this->phonebookService->GetContacts();

        return response()->json([
            'contacts' => $contacts
        ]);
    }

    public function DeleteContact(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'phone' => ['required', 'regex:/\([0-9]{2}\) [0-9]{5}-[0-9]{4}/'],
                'password' => ['required']
            ]);

            $this->phonebookService->DeleteContact($request->input('contact_id'));

            return response()->json([
                "message" => "Contato excluído com sucesso!"
            ]);

        } catch(Exception $e) {

            return response()->json([
                "message" => "Não foi possível excluir o contato.",
                "line" => $e->getLine(),
                "error" => $e->getMessage(),
                "file" => $e->getFile(),
                "stack_trace" => $e->getTrace()
            ], 500);

        }
    }
}
