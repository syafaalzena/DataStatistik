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
        Schema::create('data_bulanan_budidayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_ikan_id')->constrained('kabupaten_ikans')->cascadeOnDelete();
            $table->foreignId('komoditas_budidaya_id')->constrained('komoditas_budidayas')->cascadeOnDelete();
            $table->unsignedTinyInteger('bulan')->comment('1-12');
            $table->unsignedSmallInteger('tahun');
            $table->decimal('hasil_produksi', 14, 2)->comment('kg');
            $table->unsignedInteger('jumlah_pembudidaya')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['kabupaten_ikan_id', 'tahun', 'bulan']);
            $table->index(['tahun', 'bulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bulanan_budidayas');
    }
};
