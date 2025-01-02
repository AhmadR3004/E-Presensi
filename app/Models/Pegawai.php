<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Primary key adalah 'nip'
    protected $primaryKey = 'nip';
    public $incrementing = false; // Karena primary key bukan auto increment
    protected $keyType = 'string'; // Primary key bertipe string
    protected $table = 'pegawai'; // Nama tabel di database

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'nip',
        'foto',
        'nama',
        'jabatan_id',
        'alamat',
        'no_telp',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_masuk',
        'email',
        'password'
    ];

    // Kolom yang disembunyikan saat model dikonversi ke array atau JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting kolom ke tipe data yang sesuai
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi dengan model Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
