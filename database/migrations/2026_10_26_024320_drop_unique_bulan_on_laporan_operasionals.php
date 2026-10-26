<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('laporan_operasionals', function (Blueprint $table) {
            $table->index('pelabuhan_id'); // harus dibuat dulu, kalau tidak MySQL menolak
            $table->dropUnique(['pelabuhan_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::table('laporan_operasionals', function (Blueprint $table) {
            $table->unique(['pelabuhan_id', 'bulan', 'tahun']);
            $table->dropIndex(['pelabuhan_id']);
        });
    }
};
