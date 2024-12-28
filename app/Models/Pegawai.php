<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false; // Karena id bukan auto increment
    protected $keyType = 'string'; // Karena id bertipe string
    protected $primaryKey = 'id'; // Set primary key
    protected $table = 'pegawai'; // Sesuaikan dengan nama tabel di database

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = $model->nip; // Set id sama dengan nip saat membuat record baru
        });
    }
}
