<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanPenggajianTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_penggajian', function (Blueprint $table) {
            $table->string('id_laporan', 50)->primary();
            $table->string('id_karyawan', 20);
            $table->date('periode_start');
            $table->date('periode_end');
            $table->decimal('total_gaji', 12, 2)->default(0);
            $table->decimal('total_bonus', 12, 2)->default(0);
            $table->decimal('total_potongan', 12, 2)->default(0);
            $table->decimal('total_bersih', 12, 2)->default(0);
            $table->integer('jumlah_hari')->default(0);
            $table->timestamps();

            $table->foreign('id_karyawan')
                ->references('id_karyawan')
                ->on('m_karyawan')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_penggajian');
    }
}
