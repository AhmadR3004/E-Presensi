<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Membuat tabel konfigurasilokasi
        Schema::create('konfigurasi_lokasi', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->string('lokasi_kantor');
            $table->smallInteger('radius');
            $table->timestamps(); // Kolom created_at dan updated_at
        });

        // Mengisi data default jika tabel baru saja dibuat (hanya jika tabel kosong)
        DB::table('konfigurasi_lokasi')->insert([
            'lokasi_kantor' => '-3.33439004814505,114.59285502140446',
            'radius' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_lokasi');
    }
};
