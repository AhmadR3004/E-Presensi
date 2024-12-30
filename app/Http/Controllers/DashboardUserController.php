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

        $pegawai = DB::table('pegawai')
            ->select('foto')
            ->where('id', Auth::guard('pegawai')->id())
            ->first();

        $presensihariini = DB::table('presensi')
            ->where('pegawai_id', $nip)
            ->where('tgl_presensi', $hariini)
            ->first();

        $historibulanini = DB::table('presensi')
            ->where('pegawai_id', $nip)
            ->whereRaw('MONTH(tgl_presensi) = "' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi) = "' . $tahunini . '"')
            ->orderBy('tgl_presensi')
            ->get();

        $rekapPresensi = DB::table('presensi')
            ->selectRaw('COUNT(pegawai_id) as jmlhadir, SUM(IF(jam_in > "09:00:00", 1, 0)) as jmlterlambat')
            ->where('pegawai_id', $nip)
            ->whereRaw('MONTH(tgl_presensi) = "' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi) = "' . $tahunini . '"')
            ->first();

        $leaderboard = DB::table('presensi')
            ->join('pegawai', 'presensi.pegawai_id', '=', 'pegawai.nip')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->select('presensi.*', 'pegawai.nama', 'jabatan.nama_jabatan')
            ->where('tgl_presensi', $hariini)
            ->orderBy('jam_in')
            ->get();

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('DashboardUser.dashboard', compact('pegawai', 'presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekapPresensi', 'leaderboard'));
    }
}
