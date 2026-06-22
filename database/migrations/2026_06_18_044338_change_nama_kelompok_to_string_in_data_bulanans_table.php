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
        DB::table('data_bulanans')->update(['nama_kelompok' => null]);

        Schema::table('data_bulanans', function (Blueprint $table) {
            $table->string('nama_kelompok')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_bulanans', function (Blueprint $table) {
            $table->integer('nama_kelompok')->nullable()->change();
        });
    }
};
