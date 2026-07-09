<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('komoditas_budidayas')) {
            return;
        }

        Schema::create('komoditas_budidayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_ikan_id')->constrained('kabupaten_ikans')->cascadeOnDelete();
            $table->string('nama_komoditas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komoditas_budidayas');
    }
};