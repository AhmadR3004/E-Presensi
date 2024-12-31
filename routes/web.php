<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;

/*
|-------------------------------------------------------------------------- 
| Web Routes
|-------------------------------------------------------------------------- 
| 
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider and all of them will 
| be assigned to the "web" middleware group. Make something great! 
|
*/

// Login route for pegawai
Route::get('/login-user', function () {
    return view('auth.login-user'); // This will load the view from resources/views/auth/login-user.blade.php
})->name('login-user');

// Route to process the login
Route::post('/prosesLogin', [AuthController::class, 'prosesLogin']);

// Protect routes for authenticated pegawai only
Route::middleware('auth:pegawai')->group(function () {

    // If the user is authenticated as pegawai, allow access to /user
    Route::get('/user', [DashboardUserController::class, 'index'])->name('user');

    // Route to logout the pegawai user and redirect to /login-user
    Route::get('/prosesLogout', [AuthController::class, 'prosesLogout'])->name('prosesLogout');

    // Presensi-related routes
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    Route::get('/editProfile', [PresensiController::class, 'editProfile']);
    Route::post('/presensi/{nip}/updateProfile', [PresensiController::class, 'updateProfile']);

    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);

    Route::get('/presensi/izinSakit', [PresensiController::class, 'izinSakit']);
    Route::get('/presensi/createIzin', [PresensiController::class, 'CreateIzin']);
    Route::post('/presensi/storeIzin', [PresensiController::class, 'storeIzin']);
});

// General routes for authenticated users (using default "web" guard)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Routes for managing profiles and resources (only accessible to authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('pegawai', PegawaiController::class);
    Route::get('/check-nip/{nip}', [PegawaiController::class, 'checkNip']);
    Route::get('/check-wa/{no_telp}', [PegawaiController::class, 'checkWa']);

    Route::resource('jabatan', JabatanController::class);
    Route::get('/check-jabatan/{nama_jabatan}', [JabatanController::class, 'checkJabatan']);
});

require __DIR__ . '/auth.php';  // Include authentication routes
