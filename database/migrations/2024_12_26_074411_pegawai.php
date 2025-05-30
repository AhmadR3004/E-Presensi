<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->char('nip', 18)->primary(); // Menggunakan char(18) untuk nip sebagai primary key
            $table->string('foto')->nullable();
            $table->string('nama');
            $table->foreignId('jabatan_id')
                ->constrained('jabatan')
                ->onDelete('cascade')  // Menambahkan pengaturan untuk menghapus data terkait di tabel pegawai saat jabatan dihapus
                ->cascadeOnUpdate();
            $table->text('alamat');
            $table->string('no_telp')->unique();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_masuk');
            $table->string('email');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
