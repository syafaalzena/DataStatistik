<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produksi_tangkaps', function (Blueprint $table) {
            $table->enum('jenis_lk', ['Pelabuhan', 'Non Pelabuhan'])->default('Pelabuhan')->after('wppnri_id');
        });
    }

    public function down(): void
    {
        Schema::table('produksi_tangkaps', function (Blueprint $table) {
            $table->dropColumn('jenis_lk');
        });
    }
};