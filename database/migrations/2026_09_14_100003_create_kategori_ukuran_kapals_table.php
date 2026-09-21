<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_ukuran_kapals', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // contoh: "< 5 GT", "6 - 10 GT"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_ukuran_kapals');
    }
};