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
        Schema::table('data_bulanans', function (Blueprint $table) {
            $table->string('lokasi')->nullable();
            $table->string('jumlah_petani')->nullable();
            $table->integer('nama_kelompok')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_bulanans', function (Blueprint $table) {
            //
        });
    }
};
