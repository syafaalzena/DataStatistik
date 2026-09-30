<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_tangkaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_ikan_id')->constrained('kabupaten_ikans')->cascadeOnDelete();
            $table->foreignId('pelabuhan_id')->constrained('pelabuhans')->cascadeOnDelete();
            $table->foreignId('wppnri_id')->constrained('wppnris');
            $table->enum('jenis_lk', ['Pelabuhan', 'Non Pelabuhan'])->default('Pelabuhan');
            $table->foreignId('jenis_api_id')->constrained('jenis_apis');
            $table->foreignId('kategori_ukuran_kapal_id')->constrained('kategori_ukuran_kapals');
            $table->date('tanggal');
            $table->unsignedInteger('jumlah_trip')->default(1);
            $table->timestamps();

            $table->index(['kabupaten_ikan_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_tangkaps');
    }
};