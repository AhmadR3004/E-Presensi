<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinSakit extends Model
{
    use HasFactory;

    protected $table = 'izinSakit';
    protected $fillable = ['pegawai_id', 'tgl_izin', 'status', 'keterangan'];
    public $timestamps = true; // Aktifkan timestamps otomatis
}
