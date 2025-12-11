<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_absensi_karyawan', function (Blueprint $table) {
            $table->string('id_karyawan', 50);
            $table->string('id_absensi', 50);
            $table->decimal('total_gaji', 12, 2)->default(100000.00);
            $table->decimal('bonus_lembur', 12, 2)->default(0.00);
            $table->decimal('potongan', 12, 2)->default(0.00);
            $table->integer('total_aktual')->default(0);
            $table->enum('status_absensi', ['hadir', 'tidak hadir', 'cuti']);

            $table->primary(['id_karyawan', 'id_absensi']);

            $table->foreign('id_karyawan')
                ->references('id_karyawan')
                ->on('m_karyawan')
                ->onDelete('cascade');

            $table->foreign('id_absensi')
                ->references('id_absensi')
                ->on('m_absensi')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_absensi_karyawan');
    }
};
