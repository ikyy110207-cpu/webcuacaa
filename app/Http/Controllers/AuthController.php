<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->email;
    $password = $request->password;

    if ($email == "admin@gmail.com" && $password == "123456") {
        return redirect('/cuaca');
    }

    return back()->with('error', 'Email atau Password salah');
    
    }
}