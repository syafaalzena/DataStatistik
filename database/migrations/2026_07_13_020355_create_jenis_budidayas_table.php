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
        Schema::create('jenis_budidayas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kabupaten_ikan_id')->constrained('kabupaten_ikans')->onDelete('cascade');
        $table->string('nama_jenis');
        $table->timestamps();

        $table->unique(['kabupaten_ikan_id', 'nama_jenis'], 'jenis_budidaya_unik_per_kab');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_budidayas');
    }
};
