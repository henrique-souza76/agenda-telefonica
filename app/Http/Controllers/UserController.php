<?php

namespace App\Http\Controllers;

use App\Interfaces\IUserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    private $userService;

    public function __construct(
        IUserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function CreateUser(Request $request): JsonResponse
    {
        try {

            $numbers = $this->userService->GetPhoneNumbers()->toArray();
            $numbersArray = array_map(fn($number) => $number['phone'], $numbers);

            $request->validate([
                'name' => ['required'],
                'phone' => ['required', 'regex:/\([0-9]{2}\) [0-9]{5}-[0-9]{4}/', Rule::notIn($numbersArray)],
                'password' => ['required'],
                'password_confirmation' => ['required', 'same:password']
            ]);

            $this->userService->CreateUser($request->all());

            return response()->json([
                "message" => "Usuário cadastrado com sucesso!"
            ]);

        } catch(Exception $e) {

            return response()->json([
                "message" => "Não foi possível criar o usuário.",
                "line" => $e->getLine(),
                "error" => $e->getMessage(),
                "file" => $e->getFile(),
                "stack_trace" => $e->getTrace()
            ], 500);

        }
    }

    public function GetAuthUserName(): JsonResponse
    {
        $name = Auth::user()->name;

        return response()->json(['name' => $name]);
    }
}
