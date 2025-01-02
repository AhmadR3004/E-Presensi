<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin_Sakit extends Model
{
    use HasFactory;

    protected $table = 'Izin_Sakit';
    protected $fillable = ['pegawai_id', 'tgl_izin', 'status', 'keterangan'];
    public $timestamps = true; // Aktifkan timestamps otomatis

    /**
     * Relasi ke model Pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
