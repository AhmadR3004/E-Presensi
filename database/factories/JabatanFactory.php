<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JabatanFactory extends Factory
{
    public function definition(): array
    {
        $jabatan = [
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

        return $this->faker->randomElement($jabatan);
    }
}
