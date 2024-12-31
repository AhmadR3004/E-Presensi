<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::middleware('guest:pegawai')->group(function () {
    Route::get('/', function () {
        return view('auth.login-user');
    })->name('login-user');
    Route::post('/prosesLogin', [AuthController::class, 'prosesLogin']);
});

Route::middleware('auth:pegawai')->group(function () {
    Route::get('/user', [DashboardUserController::class, 'index']);
    Route::get('/prosesLogout', [AuthController::class, 'prosesLogout']);
});

Route::get('/presensi/create', [PresensiController::class, 'create']);
Route::post('/presensi/store', [PresensiController::class, 'store']);

Route::get('/editProfile', [PresensiController::class, 'editProfile']);
Route::post('/presensi/{nip}/updateProfile', [PresensiController::class, 'updateProfile']);

Route::get('/presensi/histori', [PresensiController::class, 'histori']);
Route::post('/gethistori', [PresensiController::class, 'gethistori']);

Route::get('/presensi/izinSakit', [PresensiController::class, 'izinSakit']);
Route::get('/presensi/createIzin', [PresensiController::class, 'CreateIzin']);
Route::post('/presensi/storeIzin', [PresensiController::class, 'storeIzin']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/admin', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('pegawai', PegawaiController::class);
    Route::get('/check-nip/{nip}', [PegawaiController::class, 'checkNip']);
    Route::get('/check-wa/{no_telp}', [PegawaiController::class, 'checkWa']);

    Route::resource('jabatan', JabatanController::class);
});

require __DIR__ . '/auth.php';
