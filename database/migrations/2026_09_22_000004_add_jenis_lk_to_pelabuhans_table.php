<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Di Excel, Jenis_LK otomatis mengikuti Pelabuhan: kalau pelabuhannya "-"
     * berarti "Non Pelabuhan", selain itu "Pelabuhan". Supaya aturan ini
     * dipindah ke database (bukan diketik manual tiap input), tiap baris
     * pelabuhan ditandai jenis_lk-nya sekali di data master.
     */
    public function up(): void
    {
        Schema::table('pelabuhans', function (Blueprint $table) {
            $table->enum('jenis_lk', ['Pelabuhan', 'Non Pelabuhan'])->default('Pelabuhan')->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('pelabuhans', function (Blueprint $table) {
            $table->dropColumn('jenis_lk');
        });
    }
};
