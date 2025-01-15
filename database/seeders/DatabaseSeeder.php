<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Presensi;
use App\Models\Izin_Sakit;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create static admin user
        User::create([
            'name' => 'Ahmad Rosyad',
            'email' => 'ahmadrosyad3004@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);

        // Seed Jabatan secara manual agar kode jabatan unik
        Jabatan::create([
            'kode_jabatan' => 'KD01',
            'nama_jabatan' => 'Kepala Dinas',
            'pangkat' => 'IV/e',
            'departemen' => 'Administrasi Kependudukan',
            'tingkat_jabatan' => 'Struktural',
            'gaji_pokok' => 10000000,
            'tunjangan' => 5000000,
        ]);
        Jabatan::create([
            'kode_jabatan' => 'KD02',
            'nama_jabatan' => 'Sekretaris',
            'pangkat' => 'IV/d',
            'departemen' => 'Administrasi Kependudukan',
            'tingkat_jabatan' => 'Struktural',
            'gaji_pokok' => 9000000,
            'tunjangan' => 4000000,
        ]);
        Jabatan::create([
            'kode_jabatan' => 'KD03',
            'nama_jabatan' => 'Kepala Bidang Pelayanan Pendaftaran Penduduk',
            'pangkat' => 'IV/c',
            'departemen' => 'Pelayanan Pendaftaran Penduduk',
            'tingkat_jabatan' => 'Struktural',
            'gaji_pokok' => 8500000,
            'tunjangan' => 3500000,
        ]);
        Jabatan::create([
            'kode_jabatan' => 'KD04',
            'nama_jabatan' => 'Kepala Bidang Pelayanan Pencatatan Sipil',
            'pangkat' => 'IV/c',
            'departemen' => 'Pelayanan Pencatatan Sipil',
            'tingkat_jabatan' => 'Struktural',
            'gaji_pokok' => 8500000,
            'tunjangan' => 3500000,
        ]);
        Jabatan::create([
            'kode_jabatan' => 'KD05',
            'nama_jabatan' => 'Kepala Bidang PIAK dan Pemanfaatan Data',
            'pangkat' => 'IV/b',
            'departemen' => 'PIAK dan Pemanfaatan Data',
            'tingkat_jabatan' => 'Struktural',
            'gaji_pokok' => 8000000,
            'tunjangan' => 3000000,
        ]);
        Jabatan::create([
            'kode_jabatan' => 'KD06',
            'nama_jabatan' => 'Staff Pelayanan',
            'pangkat' => 'III/a',
            'departemen' => 'Pelayanan',
            'tingkat_jabatan' => 'Fungsional',
            'gaji_pokok' => 5000000,
            'tunjangan' => 2000000,
        ]);
        Jabatan::create([
            'kode_jabatan' => 'KD07',
            'nama_jabatan' => 'Staff Administrasi',
            'pangkat' => 'III/a',
            'departemen' => 'Administrasi',
            'tingkat_jabatan' => 'Fungsional',
            'gaji_pokok' => 5000000,
            'tunjangan' => 2000000,
        ]);
        Jabatan::create([
            'kode_jabatan' => 'KD08',
            'nama_jabatan' => 'Operator Sistem',
            'pangkat' => 'III/b',
            'departemen' => 'Sistem Informasi',
            'tingkat_jabatan' => 'Fungsional',
            'gaji_pokok' => 6000000,
            'tunjangan' => 2500000,
        ]);
        // Tambahkan jabatan lainnya sesuai kebutuhan

        // Seed Pegawai with random Jabatan
        Pegawai::factory()->count(9)->create();

        // Create static Pegawai
        Pegawai::create([
            'nip' => '2110020078',
            'foto' => '2110020078.png',
            'nama' => 'Ahmad Rosyad',
            'jabatan_id' => 6, // Jabatan ID untuk Staff Pelayanan
            'alamat' => 'JL.Kelayan B, Gg Setia rahman no.23',
            'no_telp' => '089692572431',
            'tanggal_lahir' => '2025-01-02',
            'jenis_kelamin' => 'L',
            'tanggal_masuk' => '2025-01-02',
            'email' => 'ahmadrosyad3004@gmail.com',
            'password' => Hash::make('123'), // Enkripsi password
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Loop untuk setiap pegawai
        Pegawai::all()->each(function ($pegawai) {
            // Tentukan rentang tanggal presensi dari 1 Desember 2024 hingga sekarang
            $startDate = \Carbon\Carbon::createFromDate(2024, 12, 1); // Mulai dari 1 Desember 2024
            $endDate = \Carbon\Carbon::now(); // Sampai tanggal sekarang

            // Loop melalui setiap hari kerja (Senin sampai Jumat)
            for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                // Pastikan hanya hari kerja (Senin sampai Jumat)
                if ($date->isWeekday()) {
                    // Menentukan jam masuk (jam_in) antara jam 8:00 hingga 10:00
                    $jamInHour = rand(8, 10);
                    $jamInMinute = rand(0, 59);
                    $jamIn = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . sprintf('%02d', $jamInHour) . ':' . sprintf('%02d', $jamInMinute) . ':00');

                    // Menentukan jam keluar (jam_out) antara jam 15:00 hingga 17:00
                    $jamOutHour = rand(15, 17);
                    $jamOutMinute = rand(0, 59);
                    $jamOut = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . sprintf('%02d', $jamOutHour) . ':' . sprintf('%02d', $jamOutMinute) . ':00');

                    // Membuat presensi untuk pegawai pada tanggal tersebut
                    Presensi::create([
                        'pegawai_id' => $pegawai->nip,
                        'tgl_presensi' => $date->format('Y-m-d'),
                        'jam_in' => $jamIn->format('Y-m-d H:i:s'),
                        'jam_out' => $jamOut->format('Y-m-d H:i:s'),
                        'foto_in' => null,
                        'foto_out' => null,
                        'lokasi_in' => '-3.3343281,114.5927959',
                        'lokasi_out' => '-3.3343259,114.5927948',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        Izin_Sakit::factory()->count(50)->create();
    }
}
