<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    // Specify the table name (if it's not the plural form of the model name)
    protected $table = 'presensi';

    // Specify the fillable columns to allow mass assignment
    protected $fillable = [
        'pegawai_id',
        'tgl_presensi',
        'jam_in',
        'jam_out',
        'foto_in',
        'foto_out',
        'lokasi_in',
        'lokasi_out'
    ];

    // The dates for the 'tgl_presensi' column (if it is stored as a date)
    protected $dates = ['tgl_presensi'];

    /**
     * Relationship: A Presensi belongs to a Pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function konfigurasiLokasi()
    {
        return $this->hasOne(KonfigurasiLokasi::class);
    }

    /**
     * Check if the presensi is late (after 9:00 AM)
     */
    public function isLate()
    {
        return $this->jam_in && $this->jam_in > '09:00:00';
    }
}
