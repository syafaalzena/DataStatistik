<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahunan_tangkaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_ikan_id')->constrained('kabupaten_ikans')->cascadeOnDelete();
            $table->foreignId('pelabuhan_id')->constrained('pelabuhans')->cascadeOnDelete();
            $table->foreignId('wppnri_id')->constrained('wppnris');
            $table->enum('jenis_lk', ['Pelabuhan', 'Non Pelabuhan'])->default('Pelabuhan');
            $table->foreignId('jenis_api_id')->constrained('jenis_apis');
            $table->foreignId('kategori_ukuran_kapal_id')->constrained('kategori_ukuran_kapals');
            $table->unsignedSmallInteger('bulan');
            $table->unsignedSmallInteger('tahun');
            $table->unsignedInteger('jumlah_rtp')->default(0);
            $table->unsignedInteger('jumlah_kapal')->default(0);
            $table->unsignedInteger('jumlah_api')->default(0);
            $table->unsignedInteger('jumlah_nelayan_buruh')->default(0);
            $table->unsignedInteger('jumlah_nelayan')->default(0); // = jumlah_rtp + jumlah_nelayan_buruh
            $table->timestamps();

            $table->index(['kabupaten_ikan_id', 'tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahunan_tangkaps');
    }
};
