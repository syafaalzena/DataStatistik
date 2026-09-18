<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_logistiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_operasional_id')->constrained('laporan_operasionals')->cascadeOnDelete();
            $table->string('nama_item'); // dinamis, cth BBM, Air, Es, Garam, Oli, Gas, Ransum, dll
            $table->decimal('jumlah', 14, 2)->default(0);
            $table->string('satuan')->nullable();
            $table->decimal('harga_rp', 14, 2)->nullable();
            $table->decimal('total_rp', 16, 2)->default(0);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_logistiks');
    }
};