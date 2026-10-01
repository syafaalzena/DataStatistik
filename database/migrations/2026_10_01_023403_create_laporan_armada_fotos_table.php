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
        Schema::create('laporan_armada_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_armada_tangkap_id')->constrained('laporan_armada_tangkaps')->cascadeOnDelete();
            $table->string('foto');
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_armada_fotos');
    }
};
