<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksi_lauts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_ikan_id')->constrained('kabupaten_ikans')->cascadeOnDelete();
            $table->foreignId('pelabuhan_id')->constrained('pelabuhans')->cascadeOnDelete();
            $table->foreignId('wppnri_id')->constrained('wppnris');
            $table->foreignId('jenis_api_id')->constrained('jenis_apis');
            $table->foreignId('kategori_ukuran_kapal_id')->constrained('kategori_ukuran_kapals');
            $table->foreignId('komoditas_ikan_id')->constrained('komoditas_ikans');
            $table->unsignedTinyInteger('bulan')->comment('1-12');
            $table->unsignedSmallInteger('tahun');
            $table->decimal('volume_produksi_kg', 14, 2);
            $table->decimal('harga_rp', 12, 2);
            $table->decimal('nilai_rp', 16, 2);
            $table->timestamps();

            $table->index(['kabupaten_ikan_id', 'tahun', 'bulan']);
            $table->index(['tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_lauts');
    }
};