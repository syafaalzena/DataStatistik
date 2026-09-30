<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kabupaten_ikans', function (Blueprint $table) {
            $table->boolean('aktif_tangkap')->default(true)->after('nama_kabupaten');
        });
    }

    public function down(): void
    {
        Schema::table('kabupaten_ikans', function (Blueprint $table) {
            $table->dropColumn('aktif_tangkap');
        });
    }
};