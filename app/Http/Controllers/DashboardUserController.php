<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        $hariini = date('Y-m-d');
        $bulanini = date('m') * 1;
        $tahunini = date('Y');
        $nip = Auth::guard('pegawai')->user()->nip;
        $presensihariini = DB::table('presensi')
            ->where('pegawai_id', $nip)
            ->where('tgl_presensi', $hariini)
            ->first();
        $historibulanini = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi) = "' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi) = "' . $tahunini . '"')
            ->orderBy('tgl_presensi')
            ->get();

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('DashboardUser.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini'));
    }
}
