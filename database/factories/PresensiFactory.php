<?php

namespace Database\Factories;

use App\Models\Presensi;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PresensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil pegawai secara acak
        $pegawai = Pegawai::all()->random();

        // Tentukan rentang tanggal presensi dari Desember 2024 hingga sekarang
        $startDate = Carbon::createFromDate(2024, 12, 1); // Mulai dari Desember 2024
        $endDate = Carbon::now(); // Sampai tanggal sekarang

        // Loop melalui setiap hari kerja (Senin sampai Jumat)
        $presensiDates = [];
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            // Pastikan hanya hari kerja (Senin sampai Jumat)
            if ($date->isWeekday()) {
                $presensiDates[] = $date->format('Y-m-d');
            }
        }

        // Pilih secara acak satu tanggal presensi
        $tgl_presensi = $this->faker->randomElement($presensiDates);

        // Tentukan jam masuk (antara jam 8 hingga 10) dan keluar (antara jam 15 hingga 17)
        $jam_in = Carbon::parse($tgl_presensi . ' ' . $this->faker->numberBetween(8, 10) . ':' . $this->faker->numberBetween(0, 59))->format('H:i:s');
        $jam_out = Carbon::parse($tgl_presensi . ' ' . $this->faker->numberBetween(15, 17) . ':' . $this->faker->numberBetween(0, 59))->format('H:i:s');

        return [
            'pegawai_id' => $pegawai->nip,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam_in,
            'jam_out' => $jam_out,
            'foto_in' => null,
            'foto_out' => null,
            'lokasi_in' => '-3.3343281,114.5927959',
            'lokasi_out' => '-3.3343259,114.5927948',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
