<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

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

    public function resetPassword(Request $request)
    {
        // Validasi input form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8', // pastikan password minimal 8 karakter
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Update password
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('login')->with('status', 'Password berhasil direset!');
        }

        return back()->withErrors(['email' => 'Email tidak ditemukan']);
    }
}
