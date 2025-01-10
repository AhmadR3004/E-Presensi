<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IzinSakit>
 */
class Izin_SakitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pegawai_id' => Pegawai::inRandomOrder()->first()->nip, // Mengambil nip secara acak dari pegawai yang ada
            'tgl_izin' => $this->faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'), // Tanggal izin acak dalam rentang 2 bulan terakhir
            'status' => $this->faker->randomElement(['s', 'i']), // Status izin acak antara S (Sakit) atau I (Izin)
            'keterangan' => $this->faker->optional()->sentence(), // Keterangan opsional
            'status_approved' => $this->faker->randomElement([0, 1, 2]), // Status persetujuan acak (0: Pending, 1: Disetujui, 2: Ditolak)
        ];
    }
}
