<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komoditas_ikans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ikan');
            $table->string('nama_latin')->nullable();
            $table->string('kode_fao')->nullable();
            $table->string('kelompok_sdi')->nullable();
            $table->timestamps();

            $table->unique('nama_ikan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komoditas_ikans');
    }
};