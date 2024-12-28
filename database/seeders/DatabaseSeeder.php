<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Pegawai;

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
        Pegawai::factory()->count(20)->create();
    }
}
