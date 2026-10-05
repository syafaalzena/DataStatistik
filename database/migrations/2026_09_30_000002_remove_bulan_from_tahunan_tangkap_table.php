<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tahunan itu rekap sekali per tahun (RTP/kapal/nelayan), bukan per bulan.
     * Migration ini aman dijalankan baik kalau kolom bulan sempat kebuat
     * (karena sudah migrate duluan sebelum fix ini) maupun kalau belum.
     */
    public function up(): void
    {
        if (Schema::hasColumn('tahunan_tangkaps', 'bulan')) {
            Schema::table('tahunan_tangkaps', function (Blueprint $table) {
                $table->dropColumn('bulan');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('tahunan_tangkaps', 'bulan')) {
            Schema::table('tahunan_tangkaps', function (Blueprint $table) {
                $table->unsignedSmallInteger('bulan')->default(1)->after('kategori_ukuran_kapal_id');
            });
        }
    }
};
