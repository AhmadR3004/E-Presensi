<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JabatanFactory extends Factory
{
    public function definition(): array
    {
        // Data jabatan dengan tambahan informasi
        $jabatan = [
            [
                'kode_jabatan' => 'KD01',
                'nama_jabatan' => 'Kepala Dinas',
                'pangkat' => 'IV/e',
                'departemen' => 'Administrasi Kependudukan',
                'tingkat_jabatan' => 'Struktural',
                'gaji_pokok' => 10000000.00,
                'tunjangan' => 5000000.00,
            ],
            [
                'kode_jabatan' => 'KD02',
                'nama_jabatan' => 'Sekretaris',
                'pangkat' => 'IV/d',
                'departemen' => 'Administrasi Kependudukan',
                'tingkat_jabatan' => 'Struktural',
                'gaji_pokok' => 9000000.00,
                'tunjangan' => 4000000.00,
            ],
            [
                'kode_jabatan' => 'KD03',
                'nama_jabatan' => 'Kepala Bidang Pelayanan Pendaftaran Penduduk',
                'pangkat' => 'IV/c',
                'departemen' => 'Pelayanan Pendaftaran Penduduk',
                'tingkat_jabatan' => 'Struktural',
                'gaji_pokok' => 8500000.00,
                'tunjangan' => 3500000.00,
            ],
            [
                'kode_jabatan' => 'KD04',
                'nama_jabatan' => 'Kepala Bidang Pelayanan Pencatatan Sipil',
                'pangkat' => 'IV/c',
                'departemen' => 'Pelayanan Pencatatan Sipil',
                'tingkat_jabatan' => 'Struktural',
                'gaji_pokok' => 8500000.00,
                'tunjangan' => 3500000.00,
            ],
            [
                'kode_jabatan' => 'KD05',
                'nama_jabatan' => 'Kepala Bidang PIAK dan Pemanfaatan Data',
                'pangkat' => 'IV/b',
                'departemen' => 'PIAK dan Pemanfaatan Data',
                'tingkat_jabatan' => 'Struktural',
                'gaji_pokok' => 8000000.00,
                'tunjangan' => 3000000.00,
            ],
            [
                'kode_jabatan' => 'KD06',
                'nama_jabatan' => 'Staff Pelayanan',
                'pangkat' => 'III/a',
                'departemen' => 'Pelayanan',
                'tingkat_jabatan' => 'Fungsional',
                'gaji_pokok' => 5000000.00,
                'tunjangan' => 2000000.00,
            ],
            [
                'kode_jabatan' => 'KD07',
                'nama_jabatan' => 'Staff Administrasi',
                'pangkat' => 'III/a',
                'departemen' => 'Administrasi',
                'tingkat_jabatan' => 'Fungsional',
                'gaji_pokok' => 5000000.00,
                'tunjangan' => 2000000.00,
            ],
            [
                'kode_jabatan' => 'KD08',
                'nama_jabatan' => 'Operator Sistem',
                'pangkat' => 'III/b',
                'departemen' => 'Sistem Informasi',
                'tingkat_jabatan' => 'Fungsional',
                'gaji_pokok' => 6000000.00,
                'tunjangan' => 2500000.00,
            ]
        ];

        // Mengembalikan salah satu data jabatan secara acak
        return $this->faker->randomElement($jabatan);
    }
}
