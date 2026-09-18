<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_operasionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelabuhan_id')->constrained('pelabuhans')->cascadeOnDelete();
            $table->unsignedTinyInteger('bulan')->comment('1-12');
            $table->unsignedSmallInteger('tahun');
            $table->string('nama_pengelola')->nullable();
            $table->string('nip_pengelola')->nullable();
            $table->timestamps();

            $table->unique(['pelabuhan_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_operasionals');
    }
};