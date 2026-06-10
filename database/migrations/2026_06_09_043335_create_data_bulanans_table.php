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
        Schema::create('data_bulanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_id')->constrained()->cascadeOnDelete();
            $table->string('tahun');
            $table->string('bulan');
            $table->string('jenis_produksi');
            $table->string('produksi');
            $table->string('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bulanans');
    }
};
