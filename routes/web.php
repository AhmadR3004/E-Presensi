<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PresensiController;
use App\Models\Presensi;

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

Route::get('/', function () {
    return view('auth.login-user');
})->name('login-user');

// Route to process the login
Route::post('/prosesLogin', [AuthController::class, 'prosesLogin']);

// Route::get('/forgor-password-user', function () {
//     return view('auth.forgot-password-user');
// })->name('forgot-password-user');

// Forgot Password Routes
Route::get('/forgot-password-user', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password-user');
Route::post('/reset-password-user', [AuthController::class, 'resetPassword'])->name('reset-password');

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
    Route::delete('/presensi/izinsakit/{id}', [PresensiController::class, 'destroy'])->name('dataizin.destroy');
    Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);
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
    Route::get('/pegawai/{nip}/edit', [PegawaiController::class, 'edit']);
    Route::get('/check-nip/{nip}', [PegawaiController::class, 'checkNip']);
    Route::get('/check-wa/{no_telp}', [PegawaiController::class, 'checkWa']);

    Route::resource('jabatan', JabatanController::class);
    Route::get('/check-jabatan/{nama_jabatan}', [JabatanController::class, 'checkJabatan']);

    Route::get('presensi/monitoring', [PresensiController::class, 'monitoring'])->name('presensi.monitoring');
    Route::get('/presensi/showmap', [PresensiController::class, 'showMap'])->name('presensi.showmap');

    Route::get('presensi/dataizinsakit', [PresensiController::class, 'dataizinsakit'])->name('presensi.dataizinsakit');
    Route::post('/presensi/approveizinsakit', [PresensiController::class, 'approveizinsakit'])->name('presensi.approveizinsakit');
    Route::get('/presensi/{id}/batalkanizinsakit', [PresensiController::class, 'batalkanizinsakit']);

    Route::get('/laporan/presensi', [PresensiController::class, 'laporanPresensi'])->name('laporan.presensi');
    Route::get('/laporan/rekap-presensi', [PresensiController::class, 'laporanRekapPresensi'])->name('laporan.rekap-presensi');

    Route::get('/laporan/pegawai', [PresensiController::class, 'laporanPegawai'])->name('laporan.pegawai');
    Route::post('/laporan/cetak/pegawai', [PresensiController::class, 'cetakPegawai'])->name('laporan.cetakpegawai');

    Route::post('/laporan/cetak/presensi', [PresensiController::class, 'cetakPresensi'])->name('laporan.cetakpresensi');
    Route::post('/laporan/cetak/rekap-presensi', [PresensiController::class, 'cetakRekapPresensi'])->name('laporan.cetakrekap-presensi');

    Route::get('/laporan/izinsakit', [PresensiController::class, 'laporanIzinsakit'])->name('laporan.izinsakit');
    Route::get('/laporan/rekap-izinsakit', [PresensiController::class, 'laporanRekapIzinsakit'])->name('laporan.rekap-izinsakit');

    Route::post('/laporan/cetak/izinsakit', [PresensiController::class, 'cetakIzinSakit'])->name('laporan.cetakizinsakit');
    Route::post('/laporan/cetak/rekap-izinsakit', [PresensiController::class, 'cetakRekapIzinsakit'])->name('laporan.cetakrekap-izinsakit');

    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor'])->name('konfigurasi.lokasikantor');
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor'])->name('konfigurasi.updatelokasikantor');
});

require __DIR__ . '/auth.php';  // Include authentication routes
