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

        return redirect()->route('pegawai.index')->with('status', 'success')->with('message', 'Pegawai berhasil ditambahkan');
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
        $request->validate([
            'nip' => 'required|string|unique:pegawai,nip,' . $nip . ',nip',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string',
            'jabatan_id' => 'required|exists:jabatan,id',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|unique:pegawai,no_telp,' . $nip . ',nip',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'email' => 'required|string|email',
            'password' => 'nullable|string',
        ]);

        $pegawai = Pegawai::where('nip', $nip)->firstOrFail();
        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::disk('public')->delete('uploads/pegawai/' . $pegawai->foto);
            }

            $fotoName = $pegawai->nip . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->storeAs('uploads/pegawai', $fotoName, 'public');
            $data['foto'] = $fotoName;
        }

        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('status', 'success')->with('message', 'Pegawai berhasil diperbarui');
    }

    public function destroy($nip)
    {
        $pegawai = Pegawai::where('nip', $nip)->firstOrFail();

        if ($pegawai->foto) {
            Storage::disk('public')->delete('uploads/pegawai/' . $pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('status', 'success')->with('message', 'Pegawai berhasil dihapus.');
    }
}
