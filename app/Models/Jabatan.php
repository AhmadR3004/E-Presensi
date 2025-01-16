<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan'; // Nama tabel

    // Kolom-kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'kode_jabatan',
        'nama_jabatan',
        'pangkat',
        'departemen',
        'tingkat_jabatan',
        'gaji_pokok',
        'tunjangan'
    ];

    // Relasi dengan model Pegawai
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'jabatan_id');
    }
}
