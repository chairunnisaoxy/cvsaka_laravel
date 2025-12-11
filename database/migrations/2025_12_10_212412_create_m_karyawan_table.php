<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya buat tabel jika belum ada
        if (!Schema::hasTable('m_karyawan')) {
            Schema::create('m_karyawan', function (Blueprint $table) {
                $table->string('id_karyawan', 50)->primary();
                $table->string('nama_karyawan', 100);
                $table->enum('jabatan', ['pemilik', 'supervisor', 'operator']);
                $table->decimal('gaji_harian', 12, 2)->default(100000.00);
                $table->string('email', 100)->nullable();
                $table->string('password', 255)->nullable();
                $table->string('no_telp', 20)->nullable();
                $table->text('alamat')->nullable();
                $table->enum('status_karyawan', ['aktif', 'nonaktif']);
                $table->integer('jml_target')->default(500);
                $table->integer('total_hadir')->default(0);
            });
        }
    }

    public function down(): void
    {
        // Jangan drop table jika ada data penting
        // Schema::dropIfExists('m_karyawan');

        // Atau bisa komentar drop table
        // Untuk safety, jangan drop table yang sudah ada data
    }
};
