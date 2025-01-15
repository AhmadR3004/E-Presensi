<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jabatans = Jabatan::when($search, function ($query, $search) {
            return $query->where('nama_jabatan', 'like', "%{$search}%");
        })->paginate(10);

        return view('jabatan.index', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jabatan' => 'required|string|max:20|unique:jabatan,kode_jabatan',
            'nama_jabatan' => 'required|string|max:100|unique:jabatan,nama_jabatan',
            'pangkat' => 'required|string|max:50',
            'departemen' => 'required|string|max:100',
            'tingkat_jabatan' => 'required|string|max:50',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'nullable|numeric',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')->with([
            'status' => 'success',
            'message' => 'Jabatan berhasil ditambahkan'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jabatan' => 'required|string|max:20|unique:jabatan,kode_jabatan,' . $id,
            'nama_jabatan' => 'required|string|max:100|unique:jabatan,nama_jabatan,' . $id,
            'pangkat' => 'required|string|max:50',
            'departemen' => 'required|string|max:100',
            'tingkat_jabatan' => 'required|string|max:50',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'nullable|numeric',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')->with([
            'status' => 'success',
            'message' => 'Jabatan berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with([
            'status' => 'success',
            'message' => 'Jabatan berhasil dihapus'
        ]);
    }

    public function checkJabatan($nama_jabatan)
    {
        // Periksa apakah nama_jabatan sudah ada di database
        $exists = Jabatan::where('nama_jabatan', $nama_jabatan)->exists();

        // Kembalikan response JSON
        return response()->json(['exists' => $exists]);
    }

    public function edit($id)
    {
        $jabatan = Jabatan::find($id);
        return response()->json($jabatan);
    }
}
