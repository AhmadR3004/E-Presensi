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

        // Cek apakah ada parameter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            // Menambahkan kondisi pencarian untuk 'nama' dan 'nip'
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('nip', 'like', '%' . $search . '%');
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string',
            'nip' => 'required|string|unique:pegawai,nip',
            'jabatan_id' => 'required|exists:jabatan,id',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|unique:pegawais,no_telp',
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
        // Periksa apakah NIP sudah ada di database
        $exists = Pegawai::where('nip', $nip)->exists();

        // Kembalikan response JSON
        return response()->json(['exists' => $exists]);
    }

    public function checkWa($no_telp)
    {
        // Periksa apakah no_telp sudah ada di database
        $exists = Pegawai::where('no_telp', $no_telp)->exists();

        // Kembalikan response JSON
        return response()->json(['exists' => $exists]);
    }

    public function show($id)
    {
        $pegawai = Pegawai::with('jabatan')->findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $jabatans = Jabatan::all();
        return response()->json([
            'pegawai' => $pegawai,
            'jabatans' => $jabatans
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string',
            'nip' => 'required|string|unique:pegawai,nip,' . $id,
            'jabatan_id' => 'required|exists:jabatan,id',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'email' => 'required|string|email|unique:pegawai,email,' . $id,
            'password' => 'nullable|string',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $data = $request->all();

        // Cek dan update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        // Cek jika ada foto baru, dan simpan di folder yang sama dalam public storage
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pegawai->foto) {
                Storage::disk('public')->delete('uploads/pegawai/' . $pegawai->foto);
            }

            // Ambil nama file foto baru dengan nama berdasarkan NIP
            $fotoName = $pegawai->nip . '.' . $request->file('foto')->getClientOriginalExtension();

            // Simpan foto baru dan ambil nama file saja (tanpa path folder)
            $request->file('foto')->storeAs('uploads/pegawai', $fotoName, 'public');

            // Simpan hanya nama file di database (tanpa path folder)
            $data['foto'] = $fotoName;
        }

        // Update data pegawai
        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // Hapus file foto dari direktori public jika ada
        if ($pegawai->foto) {
            // Menghapus file foto berdasarkan nama file (tanpa path folder)
            Storage::disk('public')->delete('uploads/pegawai/' . $pegawai->foto);
        }

        // Hapus data pegawai
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
