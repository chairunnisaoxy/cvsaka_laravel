<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_penggajian', function (Blueprint $table) {
            $table->string('id_laporan', 50)->primary();
            $table->string('id_karyawan', 20)->nullable();
            $table->date('periode_start')->nullable();
            $table->date('periode_end')->nullable();
            $table->decimal('total_gaji', 12, 2)->nullable();
            $table->decimal('total_bonus', 12, 2)->nullable();
            $table->decimal('total_potongan', 12, 2)->nullable();
            $table->decimal('total_bersih', 12, 2)->nullable();
            $table->integer('jumlah_hari')->nullable();
            $table->datetime('created_at')->nullable();

            $table->foreign('id_karyawan')
                ->references('id_karyawan')
                ->on('m_karyawan')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_penggajian');
    }
};
