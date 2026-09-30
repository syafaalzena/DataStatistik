<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_armada_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_armada_tangkap_id')->constrained('laporan_armada_tangkaps')->cascadeOnDelete();
            $table->string('nama_dokumen');
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_armada_dokumens');
    }
};