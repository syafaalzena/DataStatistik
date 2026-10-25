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
            Schema::table('laporan_armada_tangkaps', function (Blueprint $table) {
            $table->foreignId('wppnri_id')
                ->nullable()                       // data lama belum punya WPPNRI
                ->after('jenis_alat_tangkap')
                ->constrained('wppnris')
                ->nullOnDelete();                  // kalau WPPNRI dihapus, kolom jadi NULL
        });
    }

    public function down(): void
    {
        Schema::table('laporan_armada_tangkaps', function (Blueprint $table) {
            $table->dropConstrainedForeignId('wppnri_id');
        });
    }
};
