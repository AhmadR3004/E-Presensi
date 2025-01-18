<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';

    protected $fillable = [
        'kode_jabatan',
        'nama_jabatan',
        'pangkat',
        'departemen',
        'tingkat_jabatan',
        'gaji_pokok',
        'tunjangan',
    ];

    /**
     * Relasi ke tabel pegawai.
     */
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
