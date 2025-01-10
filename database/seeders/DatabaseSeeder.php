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

        // Seed Jabatan first
        $jabatans = [
            [
                'nama_jabatan' => 'Kepala Dinas',
                'deskripsi' => 'Memimpin dan mengkoordinasikan pelaksanaan urusan pemerintahan bidang administrasi kependudukan dan pencatatan sipil'
            ],
            [
                'nama_jabatan' => 'Sekretaris',
                'deskripsi' => 'Membantu Kepala Dinas dalam melaksanakan koordinasi kegiatan, pengelolaan keuangan dan urusan umum'
            ],
            [
                'nama_jabatan' => 'Kepala Bidang Pelayanan Pendaftaran Penduduk',
                'deskripsi' => 'Memimpin pelaksanaan pelayanan pendaftaran penduduk'
            ],
            [
                'nama_jabatan' => 'Kepala Bidang Pelayanan Pencatatan Sipil',
                'deskripsi' => 'Memimpin pelaksanaan pelayanan pencatatan sipil'
            ],
            [
                'nama_jabatan' => 'Kepala Bidang PIAK dan Pemanfaatan Data',
                'deskripsi' => 'Memimpin pengelolaan informasi administrasi kependudukan dan pemanfaatan data'
            ],
            [
                'nama_jabatan' => 'Staff Pelayanan',
                'deskripsi' => 'Melaksanakan tugas pelayanan langsung kepada masyarakat'
            ],
            [
                'nama_jabatan' => 'Staff Administrasi',
                'deskripsi' => 'Melaksanakan tugas administrasi dan pengarsipan dokumen'
            ],
            [
                'nama_jabatan' => 'Operator Sistem',
                'deskripsi' => 'Mengoperasikan dan memelihara sistem informasi kependudukan'
            ]
        ];

        foreach ($jabatans as $jabatan) {
            Jabatan::firstOrCreate(['nama_jabatan' => $jabatan['nama_jabatan']], $jabatan);
        }

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
            // Tentukan rentang tanggal presensi dari November 2024 hingga sekarang
            $startDate = \Carbon\Carbon::createFromDate(2024, 11, 1); // Mulai dari November 2024
            $endDate = \Carbon\Carbon::now(); // Sampai tanggal sekarang

            // Loop melalui setiap hari kerja (Senin sampai Jumat)
            for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                // Pastikan hanya hari kerja (Senin sampai Jumat)
                if ($date->isWeekday()) {
                    // Membuat presensi untuk pegawai pada tanggal tersebut
                    Presensi::create([
                        'pegawai_id' => $pegawai->nip,
                        'tgl_presensi' => $date->format('Y-m-d'),
                        'jam_in' => $date->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($date)->addHours(rand(8, 10))->addMinutes(rand(0, 59))->format('H:i:s'),
                        'jam_out' => $date->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($date)->addHours(rand(15, 18))->addMinutes(rand(0, 59))->format('H:i:s'),
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
