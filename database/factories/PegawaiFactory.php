<?php

namespace Database\Factories;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PegawaiFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        // Get random jabatan_id
        $jabatan = Jabatan::inRandomOrder()->first();

        return [
            // 'foto' => $faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'nama' => $faker->name,
            'nip' => $faker->unique()->numerify('##########'),
            'jabatan_id' => $jabatan->id, // Changed from 'jabatan' to 'jabatan_id'
            'alamat' => $faker->address,
            'no_telp' => $faker->phoneNumber,
            'tanggal_lahir' => $faker->date,
            'jenis_kelamin' => $faker->randomElement(['L', 'P']),
            'tanggal_masuk' => $faker->date,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ];
    }
}
