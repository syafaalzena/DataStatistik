<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wppnris', function (Blueprint $table) {
            $table->id();
            $table->string('kode'); // contoh: "WPPNRI 572"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wppnris');
    }
};