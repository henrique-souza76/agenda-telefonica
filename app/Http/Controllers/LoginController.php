<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function Index()
    {
        if(Auth::user())
            return redirect('/');

        return view('login');
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

        return response()->json(['message' => 'Incorrect phone number and/or password.'], 401);
    }

    public function Logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['redirect' => '/login']);
    }
}
