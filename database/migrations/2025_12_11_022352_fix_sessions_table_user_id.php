<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom user_id ada
        if (Schema::hasColumn('sessions', 'user_id')) {
            // Ubah tipe data menjadi string
            Schema::table('sessions', function (Blueprint $table) {
                $table->string('user_id', 255)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Kembalikan ke integer jika perlu rollback
        Schema::table('sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }
};
