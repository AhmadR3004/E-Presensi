<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        // Membuat query untuk model Pegawai
        $query = Pegawai::with('jabatan')->orderBy('created_at', 'desc');

        // Cek apakah ada parameter pencarian untuk 'search' dan 'jabatan_id'
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            // Menambahkan kondisi pencarian untuk 'nama' dan 'nip'
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }

        // Cek jika ada 'jabatan_id' dan tambahkan filter pencarian berdasarkan jabatan
        if ($request->has('jabatan_id') && $request->jabatan_id != '') {
            $jabatanId = $request->jabatan_id;

            // Menambahkan kondisi pencarian untuk 'jabatan_id'
            $query->where('jabatan_id', $jabatanId);
        }

        // Melakukan paginate pada hasil query dengan 10 data per halaman
        $pegawais = $query->paginate(10);

        // Mengambil semua data Jabatan
        $jabatans = Jabatan::all();

        // Mengirim data pegawai dan jabatan ke view
        return view('pegawai.index', compact('pegawais', 'jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:pegawai,nip',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string',
            'jabatan_id' => 'required|exists:jabatan,id',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|unique:pegawai,no_telp',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        // Process and save the data
        if ($request->hasFile('foto')) {
            $fotoName = $data['nip'] . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->storeAs('uploads/pegawai', $fotoName, 'public');
            $data['foto'] = $fotoName;
        }

        Pegawai::create($data);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function checkNip($nip)
    {
        $exists = Pegawai::where('nip', $nip)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function checkWa($no_telp)
    {
        // Periksa apakah no_telp sudah ada di database
        $exists = Pegawai::where('no_telp', $no_telp)->exists();

        // Kembalikan response JSON
        return response()->json(['exists' => $exists]);
    }

    public function show($nip)
    {
        // Gunakan NIP sebagai primary key
        $pegawai = Pegawai::with('jabatan')->where('nip', $nip)->firstOrFail();
        return view('pegawai.show', compact('pegawai'));
    }

    public function edit($nip)
    {
        // Gunakan NIP sebagai primary key
        $pegawai = Pegawai::where('nip', $nip)->firstOrFail();
        $jabatans = Jabatan::all();
        return response()->json([
            'pegawai' => $pegawai,
            'jabatans' => $jabatans
        ]);
    }

    public function update(Request $request, $nip)
    {
        // Validasi input dari form
        $request->validate([
            'nip' => 'required|string|unique:pegawai,nip,' . $nip . ',nip',  // Validasi NIP, kecuali untuk NIP yang sedang diupdate
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validasi file foto
            'nama' => 'required|string',  // Validasi nama
            'jabatan_id' => 'required|exists:jabatan,id',  // Validasi jabatan_id harus ada di tabel jabatan
            'alamat' => 'required|string',  // Validasi alamat
            'no_telp' => 'required|string|unique:pegawai,no_telp,' . $nip . ',nip',  // Validasi nomor telepon, kecuali untuk NIP yang sedang diupdate
            'tanggal_lahir' => 'required|date',  // Validasi tanggal lahir
            'jenis_kelamin' => 'required|in:L,P',  // Validasi jenis kelamin, L untuk laki-laki, P untuk perempuan
            'tanggal_masuk' => 'required|date',  // Validasi tanggal masuk
            'email' => 'required|string|email',  // Validasi email
            'password' => 'nullable|string',  // Validasi password (opsional)
        ]);

        // Cari pegawai berdasarkan NIP
        $pegawai = Pegawai::where('nip', $nip)->firstOrFail();

        // Ambil semua data dari request
        $data = $request->all();

        // Cek dan update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);  // Enkripsi password jika diubah
        } else {
            unset($data['password']);  // Hapus password dari data jika tidak diubah
        }

        // Cek jika ada foto baru yang diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pegawai->foto) {
                Storage::disk('public')->delete('uploads/pegawai/' . $pegawai->foto);  // Hapus foto lama dari penyimpanan
            }

            // Ambil nama file foto baru berdasarkan NIP pegawai
            $fotoName = $pegawai->nip . '.' . $request->file('foto')->getClientOriginalExtension();  // Nama file berdasarkan NIP

            // Simpan foto baru dan ambil nama file saja (tanpa path folder)
            $request->file('foto')->storeAs('uploads/pegawai', $fotoName, 'public');  // Simpan di folder uploads/pegawai

            // Simpan nama file foto baru di database
            $data['foto'] = $fotoName;
        }

        // Update data pegawai dengan data baru
        $pegawai->update($data);

        // Redirect dengan pesan sukses
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy($nip)
    {
        // Gunakan NIP sebagai primary key
        $pegawai = Pegawai::where('nip', $nip)->firstOrFail();

        // Hapus file foto dari direktori public jika ada
        if ($pegawai->foto) {
            Storage::disk('public')->delete('uploads/pegawai/' . $pegawai->foto);
        }

        // Hapus data pegawai
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
