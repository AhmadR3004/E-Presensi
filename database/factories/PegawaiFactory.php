<?php

namespace Database\Factories;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        // Cek jika tabel Jabatan kosong dan ambil jabatan pertama sebagai fallback
        $jabatan = Jabatan::inRandomOrder()->first();
        $jabatanId = $jabatan ? $jabatan->id : Jabatan::first()->id; // Menggunakan Jabatan pertama sebagai fallback

        return [
            'nama' => $faker->name,
            'nip' => $faker->unique()->numerify('##########'), // NIP 10 digit
            'jabatan_id' => $jabatanId, // Foreign key ke tabel jabatan
            'alamat' => $faker->address,
            'no_telp' => '08' . $faker->unique()->numerify('##########'), // Nomor telepon diawali "08"
            'tanggal_lahir' => $faker->date('Y-m-d', '-20 years'), // Maksimal umur 20 tahun
            'jenis_kelamin' => $faker->randomElement(['L', 'P']),
            'tanggal_masuk' => $faker->date('Y-m-d', '-5 years'), // Maksimal 5 tahun ke belakang
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('123'), // Password default "123"
        ];
    }
}
