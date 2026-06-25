<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        if(
        $request->username == 'admin'
        &&
        $request->password == '12345'
        )
        {
            return redirect('/dashboard');
        }

        return back();
    }
}