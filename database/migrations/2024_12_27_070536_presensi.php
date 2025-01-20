<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->char('pegawai_id', 18); // Foreign key ke tabel pegawai (menggunakan nip dengan tipe CHAR(18))
            $table->foreign('pegawai_id') // Definisi foreign key
                ->references('nip') // Referensi ke kolom 'nip' di tabel pegawai
                ->on('pegawai') // Nama tabel referensi
                ->cascadeOnUpdate() // Update otomatis jika NIP pegawai berubah
                ->cascadeOnDelete(); // Hapus otomatis jika pegawai dihapus
            $table->date('tgl_presensi'); // Tanggal presensi
            $table->time('jam_in')->nullable(); // Waktu jam masuk
            $table->time('jam_out')->nullable(); // Waktu jam keluar
            $table->string('foto_in')->nullable(); // Path/nama file foto masuk
            $table->string('foto_out')->nullable(); // Path/nama file foto keluar
            $table->text('lokasi_in')->nullable(); // Lokasi jam masuk
            $table->text('lokasi_out')->nullable(); // Lokasi jam keluar
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
