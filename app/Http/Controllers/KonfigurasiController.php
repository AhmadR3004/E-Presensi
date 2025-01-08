<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('konfigurasi.lokasikantor', compact('lok_kantor'));
    }

    public function updatelokasikantor(Request $request)
    {
        // Ambil nilai dari request
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        // Ambil data konfigurasi lokasi sebelumnya
        $data_lama = DB::table('konfigurasi_lokasi')->where('id', 1)->first();

        // Jika lokasi_kantor tidak diubah (kosong), gunakan lokasi_kantor sebelumnya
        if (empty($lokasi_kantor)) {
            $lokasi_kantor = $data_lama->lokasi_kantor; // Ambil lokasi sebelumnya
        } else {
            // Jika lokasi_kantor diubah, hapus spasi setelah koma
            $lokasi_kantor = preg_replace('/\s*,\s*/', ',', $lokasi_kantor);
        }

        // Jika radius tidak diubah, gunakan radius sebelumnya
        if (empty($radius)) {
            $radius = $data_lama->radius;
        }

        // Update data ke tabel konfigurasi_lokasi
        $update = DB::table('konfigurasi_lokasi')->where('id', 1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius,
            'updated_at' => now(), // Update kolom updated_at
        ]);

        // Cek apakah update berhasil atau tidak
        if ($update) {
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Lokasi dan Radius Berhasil diUpdate!'
            ]);
        } else {
            return redirect()->back()->with([
                'status' => 'warning',
                'message' => 'Data Gagal diUpdate!'
            ]);
        }
    }
}
