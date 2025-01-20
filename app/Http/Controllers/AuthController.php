<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
                ->withErrors(['login' => 'NIP atau Password salah!']);
        }
    }

    public function prosesLogout()
    {
        if (Auth::guard('pegawai')->check()) {
            Auth::guard('pegawai')->logout();
            return redirect('/');
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password-user');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|exists:pegawai,nip',
            'email' => 'required|email|exists:pegawai,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pegawai = Pegawai::where('nip', $request->nip)
            ->where('email', $request->email)
            ->first();

        if ($pegawai) {
            $pegawai->password = Hash::make('123');
            $pegawai->save();

            return redirect('/')
                ->with([
                    'status' => 'success',
                    'message' => 'Password berhasil direset ke default.'
                ]);
        } else {
            return redirect()->back()
                ->with([
                    'status' => 'error',
                    'message' => 'NIP atau Email tidak valid.'
                ]);
        }
    }
}
