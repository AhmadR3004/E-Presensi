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
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\KonfigurasiLokasi;

use function Ramsey\Uuid\v1;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date('Y-m-d');
        $pegawai_id = Auth::guard('pegawai')->user()->nip;
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();

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

        return view('presensi.create', compact('cek', 'lok_kantor'));
    }

    public function store(Request $request)
    {
        $nip = Auth::guard('pegawai')->user()->nip;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');

        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $lok = explode(',', $lok_kantor->lokasi_kantor);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];

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

        if ($radius > $lok_kantor->radius) {
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
        // Urutkan berdasarkan tgl_izin secara menurun (terbaru di atas)
        $dataizin = DB::table('Izin_Sakit')
            ->where('pegawai_id', $nip)
            ->orderBy('tgl_izin', 'desc') // Menyusun dari yang terbaru
            ->get();
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
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));

        // Ambil data presensi pada tanggal yang diberikan
        $presensi = Presensi::whereDate('tgl_presensi', $date)
            ->with('pegawai.jabatan')
            ->get();

        // Ambil data lokasi kantor menggunakan query builder
        $lokasiKantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();

        // Pastikan mengirimkan lokasi_kantor ke view
        return view('presensi.monitoring', compact('presensi', 'date', 'lokasiKantor'));
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

        // Mendapatkan data pegawai
        $pegawai = DB::table('pegawai')->where('nip', $nip)
            ->select('nama', 'jabatan_id', 'no_telp', 'foto')
            ->first();

        // Mendapatkan data jabatan
        $jabatan = DB::table('jabatan')->where('id', $pegawai->jabatan_id)
            ->select('nama_jabatan')
            ->first();

        // Mendapatkan data presensi
        $presensi = DB::table('presensi')
            ->where('pegawai_id', $nip)
            ->whereRaw('MONTH(tgl_presensi) ="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi) ="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();

        // Menambahkan data pegawai dengan jabatan kepala dinas (asumsi nama jabatan = 'Kepala Dinas')
        $ttd1 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala Dinas')
            ->first();

        // Menambahkan data pegawai dengan jabatan kepala upt (asumsi nama jabatan = 'Kepala UPT')
        $ttd2 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala UPT')
            ->first();

        // Load view untuk laporan presensi
        $pdf = PDF::loadView('laporan.cetak.presensi', compact('presensi', 'nip', 'pegawai', 'jabatan', 'bulan', 'tahun', 'namabulan', 'ttd1', 'ttd2'));

        // Stream PDF ke browser
        return $pdf->stream('Laporan_Presensi_' . $pegawai->nama . '_' . $namabulan[$bulan] . '_' . $tahun . '.pdf');
    }


    public function laporanRekapPresensi()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('laporan.rekap-presensi', compact('namabulan'));
    }

    public function cetakRekapPresensi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $rekap = DB::table('presensi')
            ->selectRaw('
        presensi.pegawai_id, pegawai.nama,
        MAX(IF(DAY(tgl_presensi) = 1, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_1,
        MAX(IF(DAY(tgl_presensi) = 2, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_2,
        MAX(IF(DAY(tgl_presensi) = 3, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_3,
        MAX(IF(DAY(tgl_presensi) = 4, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_4,
        MAX(IF(DAY(tgl_presensi) = 5, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_5,
        MAX(IF(DAY(tgl_presensi) = 6, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_6,
        MAX(IF(DAY(tgl_presensi) = 7, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_7,
        MAX(IF(DAY(tgl_presensi) = 8, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_8,
        MAX(IF(DAY(tgl_presensi) = 9, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_9,
        MAX(IF(DAY(tgl_presensi) = 10, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_10,
        MAX(IF(DAY(tgl_presensi) = 11, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_11,
        MAX(IF(DAY(tgl_presensi) = 12, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_12,
        MAX(IF(DAY(tgl_presensi) = 13, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_13,
        MAX(IF(DAY(tgl_presensi) = 14, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_14,
        MAX(IF(DAY(tgl_presensi) = 15, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_15,
        MAX(IF(DAY(tgl_presensi) = 16, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_16,
        MAX(IF(DAY(tgl_presensi) = 17, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_17,
        MAX(IF(DAY(tgl_presensi) = 18, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_18,
        MAX(IF(DAY(tgl_presensi) = 19, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_19,
        MAX(IF(DAY(tgl_presensi) = 20, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_20,
        MAX(IF(DAY(tgl_presensi) = 21, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_21,
        MAX(IF(DAY(tgl_presensi) = 22, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_22,
        MAX(IF(DAY(tgl_presensi) = 23, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_23,
        MAX(IF(DAY(tgl_presensi) = 24, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_24,
        MAX(IF(DAY(tgl_presensi) = 25, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_25,
        MAX(IF(DAY(tgl_presensi) = 26, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_26,
        MAX(IF(DAY(tgl_presensi) = 27, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_27,
        MAX(IF(DAY(tgl_presensi) = 28, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_28,
        MAX(IF(DAY(tgl_presensi) = 29, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_29,
        MAX(IF(DAY(tgl_presensi) = 30, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_30,
        MAX(IF(DAY(tgl_presensi) = 31, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) AS tgl_31
        ')
            ->join('pegawai', 'presensi.pegawai_id', '=', 'pegawai.nip')
            ->whereMonth('tgl_presensi', $bulan)
            ->whereYear('tgl_presensi', $tahun)
            ->groupByRaw('presensi.pegawai_id, pegawai.nama')
            ->get();

        // Mengonfigurasi DOMPDF
        $dompdfOptions = new Options();
        $dompdfOptions->set('isHtml5ParserEnabled', true);
        $dompdfOptions->set('isPhpEnabled', true);
        $dompdf = new Dompdf($dompdfOptions);

        // Menambahkan data pegawai dengan jabatan kepala dinas (asumsi nama jabatan = 'Kepala Dinas')
        $ttd1 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala Dinas')
            ->first();

        // Menambahkan data pegawai dengan jabatan kepala upt (asumsi nama jabatan = 'Kepala UPT')
        $ttd2 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala UPT')
            ->first();

        // Load view untuk laporan rekap presensi
        $pdf = PDF::loadView('laporan.cetak.rekappresensi', compact('rekap', 'bulan', 'tahun', 'namabulan', 'ttd1', 'ttd2'));

        // Stream PDF ke browser (bukan diunduh)
        return $pdf->stream('Rekap_Presensi_' . $namabulan[$bulan] . '_' . $tahun . '.pdf');
    }

    public function dataizinsakit(Request $request)
    {
        $query = DB::table('izin_sakit')
            ->join('pegawai', 'izin_sakit.pegawai_id', '=', 'pegawai.nip')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->select('izin_sakit.*', 'pegawai.*', 'jabatan.nama_jabatan');

        // Filter berdasarkan input form
        if ($request->filled('dari')) {
            $query->whereDate('tgl_izin', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tgl_izin', '<=', $request->sampai);
        }

        if ($request->filled('nip')) {
            $query->where('pegawai.nip', 'like', '%' . $request->nip . '%');
        }

        if ($request->filled('nama')) {
            $query->where('pegawai.nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('status_approved')) {
            $query->where('izin_sakit.status_approved', '=', $request->status_approved);
        }

        // Paginate data, passing the query parameters to the pagination links
        $dataizinsakit = $query->orderBy('tgl_izin', 'desc')->paginate(10);

        // Preserve query parameters in pagination links
        $dataizinsakit->appends($request->except('page'));

        // Pass the paginated data to the view
        return view('presensi.dataizinSakit', compact('dataizinsakit'));
    }

    public function approveizinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $id_izinsakit_form = $request->id_izinsakit_form;
        $update = DB::table('izin_sakit')
            ->where('id', $id_izinsakit_form)
            ->update(['status_approved' => $status_approved]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil disetujui!']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal disetujui!']);
        }
    }

    public function batalkanizinsakit($id)
    {
        $update = DB::table('izin_sakit')
            ->where('id', $id)
            ->update(['status_approved' => 0]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil dikembalikan!']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal dikembalikan!']);
        }
    }

    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nip = Auth::guard('pegawai')->user()->nip;

        $cek = DB::table('izin_sakit')->where('pegawai_id', $nip)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }

    public function laporanIzinsakit()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $pegawai = DB::table('pegawai')->orderBy('nama')->get();
        return view('laporan.izinsakit', compact('namabulan', 'pegawai'));
    }

    public function cetakIzinSakit(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nip = $request->nip;

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Mengambil data pegawai berdasarkan NIP
        $pegawai = DB::table('pegawai')->where('nip', $nip)
            ->select('nama', 'jabatan_id', 'no_telp', 'foto')
            ->first();

        // Mengambil jabatan pegawai
        $jabatan = DB::table('jabatan')->where('id', $pegawai->jabatan_id)
            ->select('nama_jabatan')
            ->first();

        // Mengambil data izin sakit berdasarkan NIP, bulan, dan tahun
        $izinSakit = DB::table('izin_sakit')
            ->where('pegawai_id', $nip)
            ->whereRaw('MONTH(tgl_izin) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_izin) = ?', [$tahun])
            ->orderBy('tgl_izin')
            ->get();

        // Mengonfigurasi DOMPDF
        $dompdfOptions = new Options();
        $dompdfOptions->set('isHtml5ParserEnabled', true);
        $dompdfOptions->set('isPhpEnabled', true);
        $dompdf = new Dompdf($dompdfOptions);

        // Menyiapkan data yang akan diteruskan ke view
        $namaBulan = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        // Menambahkan data pegawai dengan jabatan kepala dinas (asumsi nama jabatan = 'Kepala Dinas')
        $ttd1 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala Dinas')
            ->first();

        // Menambahkan data pegawai dengan jabatan kepala upt (asumsi nama jabatan = 'Kepala UPT')
        $ttd2 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala UPT')
            ->first();

        // Load view untuk laporan izin sakit
        $pdf = PDF::loadView('laporan.cetak.izinsakit', compact('izinSakit', 'nip', 'pegawai', 'jabatan', 'bulan', 'tahun', 'namaBulan', 'ttd1', 'ttd2'));

        // Stream PDF ke browser (bukan diunduh)
        return $pdf->stream('Laporan_Izin_Sakit_' . $namaBulan[$bulan] . '_' . $tahun . '.pdf');
    }

    public function laporanRekapIzinsakit()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('laporan.rekap-izinsakit', compact('namabulan'));
    }

    public function cetakRekapIzinsakit(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Query untuk mengambil data izin sakit berdasarkan bulan dan tahun
        $rekap = DB::table('izin_sakit')
            ->selectRaw('
            pegawai.nip as pegawai_id, 
            pegawai.nama,
            MAX(IF(DAY(tgl_izin) = 1, status, "")) AS tgl_1,
            MAX(IF(DAY(tgl_izin) = 2, status, "")) AS tgl_2,
            MAX(IF(DAY(tgl_izin) = 3, status, "")) AS tgl_3,
            MAX(IF(DAY(tgl_izin) = 4, status, "")) AS tgl_4,
            MAX(IF(DAY(tgl_izin) = 5, status, "")) AS tgl_5,
            MAX(IF(DAY(tgl_izin) = 6, status, "")) AS tgl_6,
            MAX(IF(DAY(tgl_izin) = 7, status, "")) AS tgl_7,
            MAX(IF(DAY(tgl_izin) = 8, status, "")) AS tgl_8,
            MAX(IF(DAY(tgl_izin) = 9, status, "")) AS tgl_9,
            MAX(IF(DAY(tgl_izin) = 10, status, "")) AS tgl_10,
            MAX(IF(DAY(tgl_izin) = 11, status, "")) AS tgl_11,
            MAX(IF(DAY(tgl_izin) = 12, status, "")) AS tgl_12,
            MAX(IF(DAY(tgl_izin) = 13, status, "")) AS tgl_13,
            MAX(IF(DAY(tgl_izin) = 14, status, "")) AS tgl_14,
            MAX(IF(DAY(tgl_izin) = 15, status, "")) AS tgl_15,
            MAX(IF(DAY(tgl_izin) = 16, status, "")) AS tgl_16,
            MAX(IF(DAY(tgl_izin) = 17, status, "")) AS tgl_17,
            MAX(IF(DAY(tgl_izin) = 18, status, "")) AS tgl_18,
            MAX(IF(DAY(tgl_izin) = 19, status, "")) AS tgl_19,
            MAX(IF(DAY(tgl_izin) = 20, status, "")) AS tgl_20,
            MAX(IF(DAY(tgl_izin) = 21, status, "")) AS tgl_21,
            MAX(IF(DAY(tgl_izin) = 22, status, "")) AS tgl_22,
            MAX(IF(DAY(tgl_izin) = 23, status, "")) AS tgl_23,
            MAX(IF(DAY(tgl_izin) = 24, status, "")) AS tgl_24,
            MAX(IF(DAY(tgl_izin) = 25, status, "")) AS tgl_25,
            MAX(IF(DAY(tgl_izin) = 26, status, "")) AS tgl_26,
            MAX(IF(DAY(tgl_izin) = 27, status, "")) AS tgl_27,
            MAX(IF(DAY(tgl_izin) = 28, status, "")) AS tgl_28,
            MAX(IF(DAY(tgl_izin) = 29, status, "")) AS tgl_29,
            MAX(IF(DAY(tgl_izin) = 30, status, "")) AS tgl_30,
            MAX(IF(DAY(tgl_izin) = 31, status, "")) AS tgl_31,
            MAX(IF(DAY(tgl_izin) = 1, status_approved, "")) AS status_approved_1,
            MAX(IF(DAY(tgl_izin) = 2, status_approved, "")) AS status_approved_2,
            MAX(IF(DAY(tgl_izin) = 3, status_approved, "")) AS status_approved_3,
            MAX(IF(DAY(tgl_izin) = 4, status_approved, "")) AS status_approved_4,
            MAX(IF(DAY(tgl_izin) = 5, status_approved, "")) AS status_approved_5,
            MAX(IF(DAY(tgl_izin) = 6, status_approved, "")) AS status_approved_6,
            MAX(IF(DAY(tgl_izin) = 7, status_approved, "")) AS status_approved_7,
            MAX(IF(DAY(tgl_izin) = 8, status_approved, "")) AS status_approved_8,
            MAX(IF(DAY(tgl_izin) = 9, status_approved, "")) AS status_approved_9,
            MAX(IF(DAY(tgl_izin) = 10, status_approved, "")) AS status_approved_10,
            MAX(IF(DAY(tgl_izin) = 11, status_approved, "")) AS status_approved_11,
            MAX(IF(DAY(tgl_izin) = 12, status_approved, "")) AS status_approved_12,
            MAX(IF(DAY(tgl_izin) = 13, status_approved, "")) AS status_approved_13,
            MAX(IF(DAY(tgl_izin) = 14, status_approved, "")) AS status_approved_14,
            MAX(IF(DAY(tgl_izin) = 15, status_approved, "")) AS status_approved_15,
            MAX(IF(DAY(tgl_izin) = 16, status_approved, "")) AS status_approved_16,
            MAX(IF(DAY(tgl_izin) = 17, status_approved, "")) AS status_approved_17,
            MAX(IF(DAY(tgl_izin) = 18, status_approved, "")) AS status_approved_18,
            MAX(IF(DAY(tgl_izin) = 19, status_approved, "")) AS status_approved_19,
            MAX(IF(DAY(tgl_izin) = 20, status_approved, "")) AS status_approved_20,
            MAX(IF(DAY(tgl_izin) = 21, status_approved, "")) AS status_approved_21,
            MAX(IF(DAY(tgl_izin) = 22, status_approved, "")) AS status_approved_22,
            MAX(IF(DAY(tgl_izin) = 23, status_approved, "")) AS status_approved_23,
            MAX(IF(DAY(tgl_izin) = 24, status_approved, "")) AS status_approved_24,
            MAX(IF(DAY(tgl_izin) = 25, status_approved, "")) AS status_approved_25,
            MAX(IF(DAY(tgl_izin) = 26, status_approved, "")) AS status_approved_26,
            MAX(IF(DAY(tgl_izin) = 27, status_approved, "")) AS status_approved_27,
            MAX(IF(DAY(tgl_izin) = 28, status_approved, "")) AS status_approved_28,
            MAX(IF(DAY(tgl_izin) = 29, status_approved, "")) AS status_approved_29,
            MAX(IF(DAY(tgl_izin) = 30, status_approved, "")) AS status_approved_30,
            MAX(IF(DAY(tgl_izin) = 31, status_approved, "")) AS status_approved_31
        ')
            ->join('pegawai', 'izin_sakit.pegawai_id', '=', 'pegawai.nip')
            ->whereMonth('tgl_izin', $bulan)
            ->whereYear('tgl_izin', $tahun)
            ->groupByRaw('izin_sakit.pegawai_id, pegawai.nama')
            ->get();

        // Mengonfigurasi DOMPDF
        $dompdfOptions = new Options();
        $dompdfOptions->set('isHtml5ParserEnabled', true);
        $dompdfOptions->set('isPhpEnabled', true);
        $dompdf = new Dompdf($dompdfOptions);

        // Menambahkan data pegawai dengan jabatan kepala dinas (asumsi nama jabatan = 'Kepala Dinas')
        $ttd1 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala Dinas')
            ->first();

        // Menambahkan data pegawai dengan jabatan kepala upt (asumsi nama jabatan = 'Kepala UPT')
        $ttd2 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala UPT')
            ->first();

        // Load view untuk laporan rekap presensi
        $pdf = PDF::loadView('laporan.cetak.rekapizinsakit', compact('rekap', 'bulan', 'tahun', 'namabulan', 'ttd1', 'ttd2'));

        // Stream PDF ke browser (bukan diunduh)
        return $pdf->stream('Rekap_Izin_Sakit_' . $namabulan[$bulan] . '_' . $tahun . '.pdf');
    }

    public function laporanPegawai()
    {
        $jabatan = DB::table('jabatan')->orderBy('nama_jabatan')->get();
        return view('laporan.pegawai', compact('jabatan'));
    }

    public function cetakPegawai(Request $request)
    {
        // Mendapatkan jabatan_id dari request
        $jabatan_id = $request->jabatan;

        // Query untuk mengambil data pegawai beserta jabatan
        $pegawai = DB::table('pegawai')
            ->leftJoin('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->select(
                'pegawai.nip',
                'pegawai.nama',
                'pegawai.jabatan_id',
                'pegawai.no_telp',
                'pegawai.foto',
                'pegawai.alamat',
                'pegawai.tanggal_lahir',
                'pegawai.email',
                'pegawai.tanggal_masuk',
                'pegawai.jenis_kelamin',
                'jabatan.nama_jabatan as jabatan_nama',
                'jabatan.kode_jabatan',
                'jabatan.pangkat',
                'jabatan.departemen',
                'jabatan.tingkat_jabatan',
                'jabatan.gaji_pokok',
                'jabatan.tunjangan'
            )
            ->when($jabatan_id, function ($query) use ($jabatan_id) {
                return $query->where('pegawai.jabatan_id', $jabatan_id);
            })
            ->get();

        // Jika jabatan_id ada, ambil jabatan untuk ditampilkan
        $jabatan = null;
        if ($jabatan_id) {
            $jabatan = DB::table('jabatan')->where('id', $jabatan_id)->first();
        }

        // Menambahkan data pegawai dengan jabatan kepala dinas (asumsi nama jabatan = 'Kepala Dinas')
        $ttd1 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala Dinas')
            ->first();

        // Menambahkan data pegawai dengan jabatan kepala upt (asumsi nama jabatan = 'Kepala UPT')
        $ttd2 = DB::table('pegawai')
            ->join('jabatan', 'pegawai.jabatan_id', '=', 'jabatan.id')
            ->where('jabatan.nama_jabatan', 'Kepala UPT')
            ->first();

        // Preview PDF sebelum download
        $pdf = Pdf::loadView('laporan.cetak.pegawai', compact('pegawai', 'jabatan', 'jabatan_id', 'ttd1', 'ttd2'));
        return $pdf->stream('laporan-pegawai.pdf');
    }
}
