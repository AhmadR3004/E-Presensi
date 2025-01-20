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
        Schema::create('izin_sakit', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->char('pegawai_id', 18); // Foreign key ke tabel pegawai (menggunakan nip dengan tipe CHAR(18))
            $table->foreign('pegawai_id') // Definisi foreign key
                ->references('nip') // Referensi ke kolom 'nip' di tabel pegawai
                ->on('pegawai') // Tabel referensi
                ->cascadeOnUpdate() // Update otomatis jika NIP pegawai berubah
                ->cascadeOnDelete(); // Hapus otomatis jika data pegawai dihapus
            $table->date('tgl_izin'); // Kolom untuk tanggal izin
            $table->char('status', 1) // Status izin (S: Sakit, I: Izin)
                ->comment('s: Sakit, i: Izin');
            $table->text('keterangan')->nullable(); // Kolom untuk keterangan (opsional)
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
        Schema::dropIfExists('izin_sakit');
    }
};
