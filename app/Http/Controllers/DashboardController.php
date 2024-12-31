<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\IzinSakit; // Model IzinSakit
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with the logged-in user's name and relevant data.
     */
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Fetch the user's name or set a default value
        $userName = $user ? $user->name : 'Guest';

        // Get today's date
        $today = date('Y-m-d');

        // Get Pegawai who are present today
        $hadir = Presensi::where('tgl_presensi', $today)
            ->whereNotNull('jam_in') // Means hadir
            ->count();

        // Get Pegawai who are absent due to izin
        $izin = IzinSakit::where('tgl_izin', $today)
            ->where('status', 'I') // 'I' for izin
            ->where('status_approved', 1) // Only approved izin
            ->count();

        // Get Pegawai who are absent due to sakit
        $sakit = IzinSakit::where('tgl_izin', $today)
            ->where('status', 'S') // 'S' for sakit
            ->where('status_approved', 1) // Only approved sakit
            ->count();

        // Get Pegawai who are late (jam_in after 09:00:00)
        $terlambat = Presensi::where('tgl_presensi', $today)
            ->whereNotNull('jam_in')
            ->where('jam_in', '>', '09:00:00') // Late arrival condition
            ->count();

        // Return the dashboard view with all required data
        return view('dashboard', compact('userName', 'hadir', 'izin', 'sakit', 'terlambat'));
    }
}
