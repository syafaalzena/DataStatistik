<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_armada_tangkaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_operasional_id')->constrained('laporan_operasionals')->cascadeOnDelete();
            $table->string('ukuran_kapal'); // dinamis, cth "< 5", "6 - 10"
            $table->decimal('jumlah_kapal', 12, 2)->default(0);
            $table->decimal('jumlah_abk', 12, 2)->default(0);
            $table->string('status_dokumen')->nullable(); // Lengkap / Tidak Lengkap / dll
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_armada_tangkaps');
    }
};