<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view for the user.
     */
    public function create(): View
    {
        return view('auth.login-user'); // Halaman login untuk pengguna
    }

    /**
     * Display the login view for the admin.
     */
    public function createAdmin(): View
    {
        return view('auth.login'); // Halaman login untuk admin
    }

    /**
     * Handle an incoming authentication request for the user.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Tentukan guard yang digunakan untuk login user biasa
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME); // Atau sesuaikan halaman tujuan
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle an incoming authentication request for the admin.
     */
    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        // Tentukan guard yang digunakan untuk login admin
        $credentials = $request->only('email', 'password');

        if (Auth::guard('pegawai')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin-dashboard'); // Atur rute untuk admin setelah login
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session for the user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout(); // Logout user

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Destroy an authenticated session for the admin.
     */
    public function destroyAdmin(Request $request): RedirectResponse
    {
        Auth::guard('pegawai')->logout(); // Logout admin

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
