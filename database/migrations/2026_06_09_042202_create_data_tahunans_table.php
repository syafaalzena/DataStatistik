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
        Schema::create('data_tahunans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statistik_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kabupaten_id')->constrained()->cascadeOnDelete();
            $table->integer('jumlah_petani');
            $table->string('luas_lahan_rebus');
            $table->integer('luas_lahan_jemur');
            $table->string('jumlah_lahan_unit');
            $table->string('lokasi')->nullable();
            $table->string('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_tahunans');
    }
};
