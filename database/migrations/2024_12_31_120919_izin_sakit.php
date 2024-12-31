<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izinSakit', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('pegawai_id') // Foreign key ke tabel pegawai
                ->constrained('pegawai') // Referensi ke tabel pegawai
                ->cascadeOnUpdate(); // Update otomatis jika ID pegawai berubah
            $table->date('tgl_izin'); // Kolom untuk tanggal izin
            $table->char('status', 1) // Status izin (S untuk sakit, I untuk izin)
                ->comment('S: Sakit, I: Izin');
            $table->text('keterangan')->nullable(); // Kolom untuk keterangan, opsional
            $table->tinyInteger('status_approved') // Status persetujuan (0: Pending, 1: Disetujui, 2: Ditolak)
                ->default(0)
                ->comment('0: Pending, 1: Disetujui, 2: Ditolak');
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('izin');
    }
};
