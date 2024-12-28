<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{

    public function index()
    {
        $pegawais = Pegawai::with('jabatan')->orderBy('created_at', 'desc')->paginate(10);
        $jabatans = Jabatan::all();
        return view('pegawai.index', compact('pegawais', 'jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string',
            'nip' => 'required|string|unique:pegawai',
            'jabatan_id' => 'required|exists:jabatan,id',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'email' => 'required|string|email|unique:pegawai',
            'password' => 'required|string',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        // Cek jika ada foto, dan simpan di folder fotos dalam public storage
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        // Simpan pegawai ke database
        Pegawai::create($data);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
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

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        // Cek jika ada foto baru, dan simpan di folder fotos dalam public storage
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        // Update data pegawai
        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // Hapus file foto dari direktori public
        if ($pegawai->foto) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
