<?php

namespace App\Http\Controllers;

use App\Interfaces\IUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    private $userService;

    public function __construct(
        IUserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function Index()
    {
        if(Auth::user())
            return redirect('/');

        $numbers = $this->userService->GetPhoneNumbers()->toArray();
        $numbersArray = array_map(fn($number) => $number['phone'], $numbers);

        return view('login', ['numbers' => json_encode($numbersArray)]);
    }

    public function Authenticate(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'phone' => ['required', 'regex:/\([0-9]{2}\) [0-9]{5}-[0-9]{4}/'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials, $request->input('remember_value'))) {
            $request->session()->regenerate();

            return response()->json(['redirect' => '/']);
        }

        return response()->json(['message' => 'Telefone e/ou senha incorretos.'], 401);
    }

    public function Logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['redirect' => '/login']);
    }
}
