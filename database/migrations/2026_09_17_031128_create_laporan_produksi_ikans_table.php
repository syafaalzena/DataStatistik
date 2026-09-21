<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_produksi_ikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_operasional_id')->constrained('laporan_operasionals')->cascadeOnDelete();
            $table->string('jenis_ikan'); // dinamis
            $table->decimal('produksi_kg', 14, 2)->default(0);
            $table->decimal('harga_rp', 14, 2)->default(0);
            $table->decimal('nilai_rp', 16, 2)->default(0);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_produksi_ikans');
    }
};