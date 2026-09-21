<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_pemasarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_operasional_id')->constrained('laporan_operasionals')->cascadeOnDelete();
            $table->enum('kategori', ['Lokal', 'Regional', 'Ekspor']);
            $table->string('jenis_ikan');
            $table->decimal('quantity_kg', 14, 2)->default(0);
            $table->string('tujuan')->nullable(); // kabupaten (Lokal) / provinsi (Regional) / negara (Ekspor)
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_pemasarans');
    }
};