<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // dd($data);

        if (Auth::attempt($data)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Username dan Password tidak cocok');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
