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
            $table->id();
            // Foreign key nik pegawai
            $table->foreignId('pegawai_id')
                ->constrained('pegawai') // Referensi ke tabel pegawai
                ->cascadeOnUpdate(); // Update otomatis jika ID pegawai berubah
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
