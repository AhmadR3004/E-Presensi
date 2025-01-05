<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presensi;
use App\Models\Izin_Sakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

use function Ramsey\Uuid\v1;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date('Y-m-d');
        $pegawai_id = Auth::guard('pegawai')->user()->nip;

        // Cek apakah sudah ada absen masuk untuk hari ini
        $presensiMasuk = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('pegawai_id', $pegawai_id)
            ->whereNotNull('jam_in') // Cek apakah jam_in sudah ada
            ->first();

        // Cek apakah sudah ada absen pulang untuk hari ini
        $presensiPulang = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('pegawai_id', $pegawai_id)
            ->whereNotNull('jam_out') // Cek apakah jam_out sudah ada
            ->first();

        // Tentukan status absen berdasarkan apakah sudah absen masuk dan pulang
        if ($presensiMasuk && $presensiPulang) {
            $cek = 2; // Sudah absen masuk dan pulang
        } elseif ($presensiMasuk) {
            $cek = 1; // Hanya absen masuk
        } else {
            $cek = 0; // Belum absen sama sekali
        }

        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $nip = Auth::guard('pegawai')->user()->nip;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');

        $latitudekantor = -3.334345495834711;
        $longitudekantor = 114.59274160520408;

        $lokasi = $request->lokasi;
        $lokasiuser = explode(',', $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak['meters']);

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('pegawai_id', $nip)->count();
        if ($cek > 0) {
            $ket = 'out';
        } else {
            $ket = 'in';
        }
        $image = $request->image;
        $folderpath = "public/uploads/absensi/";
        $formatName = $nip . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . '.png';
        $file = $folderpath . $fileName;

        if ($radius > 10) {
            echo "error|Maaf, Anda diluar jangkauan absen, jarak Anda " . $radius . " Meter dari kantor|radius";
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi,
                    'updated_at' => now(),
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('pegawai_id', $nip)->update($data_pulang);
                if ($update) {
                    echo "success|Terima kasih, Hati-hati di jalan|out";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Maaf gagal absen, hubungi Tim IT|";
                }
            } else {
                $data = [
                    'pegawai_id' => $nip,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                    'created_at' => now(),
                ];
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    echo "success|Terima kasih, Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Maaf gagal absen, hubungi Tim IT|";
                }
            }
        }
    }
    //Menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editProfile()
    {
        $nip = Auth::guard('pegawai')->user()->nip;
        $pegawai = DB::table('pegawai')->where('nip', $nip)->first();

        return view('presensi.editProfile', compact('pegawai'));
    }

    public function updateProfile(Request $request)
    {
        $nip = Auth::guard('pegawai')->user()->nip; // Menggunakan nip sebagai pengganti id
        $nama = $request->nama;
        $no_telp = $request->no_telp;
        $password = Hash::make($request->password);
        $pegawai = DB::table('pegawai')->where('nip', $nip)->first(); // Ganti id menjadi nip

        if ($request->hasFile('foto')) {
            $foto = $nip . '.' . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $pegawai->foto;
        }

        if (empty($request->password)) {
            $data = [
                'nama' => $nama,
                'no_telp' => $no_telp,
                'foto' => $foto,
                'updated_at' => now(),
            ];
        } else {
            $data = [
                'nama' => $nama,
                'no_telp' => $no_telp,
                'password' => $password,
                'foto' => $foto,
                'updated_at' => now(),
            ];
        }

        $update = DB::table('pegawai')->where('nip', $nip)->update($data); // Ganti id menjadi nip
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderpath = "public/uploads/pegawai/";
                $request->file('foto')->storeAs($folderpath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal diupdate']);
        }
    }

    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nip = Auth::guard('pegawai')->user()->nip;

        $histori = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi) ="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi) ="' . $tahun . '"')
            ->where('pegawai_id', $nip)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function izinSakit()
    {
        $nip = Auth::guard('pegawai')->user()->nip;
        $dataizin = DB::table('Izin_Sakit')->where('pegawai_id', $nip)->get();
        return view('presensi.izinSakit', compact('dataizin'));
    }

    public function createIzin()
    {
        return view('presensi.createIzin');
    }

    public function storeIzin(Request $request)
    {
        $nip = Auth::guard('pegawai')->user()->nip;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'pegawai_id' => $nip,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $simpan = DB::table('Izin_Sakit')->insert($data);

        if ($simpan) {
            return redirect('/presensi/izinSakit')->with(['success' => 'Data berhasil disimpan!']);
        } else {
            return redirect('/presensi/izinSakit')->with(['error' => 'Data gagal disimpan!']);
        }
    }

    public function destroy($id)
    {
        $dataIzin = Izin_Sakit::findOrFail($id);

        // Hapus data izin
        $dataIzin->delete();

        return redirect('/presensi/izinSakit')->with('success', 'Data izin berhasil dihapus.');
    }

    public function monitoring(Request $request)
    {
        // Cek apakah ada parameter tanggal yang dipilih
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));  // Default ke tanggal hari ini jika tidak ada filter

        // Ambil data presensi berdasarkan tanggal yang dipilih
        $presensi = Presensi::whereDate('tgl_presensi', $date)  // Gantilah 'tgl_presensi' dengan kolom yang sesuai di tabel presensi
            ->with('pegawai.jabatan')  // Memuat relasi pegawai dan jabatan
            ->get();

        return view('presensi.monitoring', compact('presensi', 'date'));
    }

    public function laporanPresensi()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $pegawai = DB::table('pegawai')->orderBy('nama')->get();
        return view('laporan.presensi', compact('namabulan', 'pegawai'));
    }

    public function cetakPresensi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nip = $request->nip;

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $pegawai = DB::table('pegawai')->where('nip', $nip)
            ->select('nama', 'jabatan_id', 'no_telp', 'foto')
            ->first();

        $jabatan = DB::table('jabatan')->where('id', $pegawai->jabatan_id)
            ->select('nama_jabatan')
            ->first();

        $presensi = DB::table('presensi')
            ->where('pegawai_id', $nip)
            ->whereRaw('MONTH(tgl_presensi) ="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi) ="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();

        return view('laporan.cetak.presensi', compact('presensi', 'nip', 'pegawai', 'jabatan', 'bulan', 'tahun', 'namabulan'));
    }

    public function laporanRekapPresensi()
    {
        return view('laporan.rekap-presensi');
    }
}
