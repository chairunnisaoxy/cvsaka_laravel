<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_produk_karyawan', function (Blueprint $table) {
            $table->string('id_produk', 50);
            $table->string('id_karyawan', 50);
            $table->integer('jml_aktual');
            $table->integer('jml_keranjang')->default(0);

            $table->primary(['id_produk', 'id_karyawan']);

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('m_produk')
                ->onDelete('cascade');

            $table->foreign('id_karyawan')
                ->references('id_karyawan')
                ->on('m_karyawan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_produk_karyawan');
    }
};
