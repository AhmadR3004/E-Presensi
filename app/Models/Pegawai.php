<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    
    protected $fillable = [
        'foto',
        'nama',
        'nip',
        'jabatan_id',
        'alamat',
        'no_telp',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_masuk',
        'email',
        'password'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}