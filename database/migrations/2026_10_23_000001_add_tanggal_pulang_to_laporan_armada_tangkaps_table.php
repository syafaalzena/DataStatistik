<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_armada_tangkaps', function (Blueprint $table) {
            $table->date('tanggal_pulang')->nullable()->after('tanggal_berangkat');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_armada_tangkaps', function (Blueprint $table) {
            $table->dropColumn('tanggal_pulang');
        });
    }
};
