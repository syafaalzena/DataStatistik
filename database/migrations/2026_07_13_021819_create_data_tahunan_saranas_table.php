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
    {Schema::create('data_tahunan_saranas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kabupaten_ikan_id')->constrained('kabupaten_ikans')->onDelete('cascade');
        $table->foreignId('jenis_budidaya_id')->constrained('jenis_budidayas')->onDelete('cascade');
        $table->unsignedSmallInteger('tahun');
        $table->unsignedInteger('jumlah_rtp')->default(0);
        $table->unsignedInteger('jumlah_pembudidaya')->nullable();
        $table->unsignedBigInteger('luas_lahan')->nullable();
        $table->timestamps();

        $table->unique(['kabupaten_ikan_id', 'jenis_budidaya_id', 'tahun'], 'sarana_tahunan_unik');
    });
}

public function down(): void
{
    Schema::dropIfExists('data_tahunan_saranas');
}
};
