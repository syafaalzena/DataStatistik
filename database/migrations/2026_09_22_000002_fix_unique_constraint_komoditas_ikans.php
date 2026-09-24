<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Di Excel sumber, satu nama ikan umum (nama_ikan) bisa dipakai oleh
     * beberapa spesies berbeda (nama_latin beda-beda, misal beberapa varian
     * "Abalon"). Constraint unique(nama_ikan) yang lama menghalangi itu,
     * jadi diganti jadi unique gabungan (nama_ikan + nama_latin).
     */
    public function up(): void
    {
        Schema::table('komoditas_ikans', function (Blueprint $table) {
            try {
                $table->dropUnique('komoditas_ikans_nama_ikan_unique');
            } catch (\Throwable $e) {
                // index lama mungkin belum pernah kebuat, aman diabaikan
            }
        });

        Schema::table('komoditas_ikans', function (Blueprint $table) {
            $table->unique(['nama_ikan', 'nama_latin'], 'komoditas_ikans_nama_ikan_nama_latin_unique');
        });
    }

    public function down(): void
    {
        Schema::table('komoditas_ikans', function (Blueprint $table) {
            $table->dropUnique('komoditas_ikans_nama_ikan_nama_latin_unique');
            $table->unique('nama_ikan', 'komoditas_ikans_nama_ikan_unique');
        });
    }
};
