<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function prosesLogin(Request $request)
    {
        $credentials = $request->only('nip', 'password');

        if (Auth::guard('pegawai')->attempt($credentials)) {
            return redirect('/user');
        } else {
            return redirect('/')
                ->withErrors(['login' => 'NIP atau password salah!']);
        }
    }
}
