<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produksi_tangkaps', function (Blueprint $table) {
            $table->string('nama_latin_input')->nullable()->after('komoditas_ikan_id');
        });
    }

    public function down(): void
    {
        Schema::table('produksi_tangkaps', function (Blueprint $table) {
            $table->dropColumn('nama_latin_input');
        });
    }
};