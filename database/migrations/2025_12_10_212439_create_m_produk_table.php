<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_produk', function (Blueprint $table) {
            $table->string('id_produk', 50)->primary();
            $table->string('nama_produk', 100);
            $table->enum('status_produk', ['aktif', 'nonaktif']);
            $table->string('satuan', 20)->default('pcs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_produk');
    }
};
