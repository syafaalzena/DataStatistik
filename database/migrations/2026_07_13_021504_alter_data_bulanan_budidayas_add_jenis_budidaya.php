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
    { Schema::table('data_bulanan_budidayas', function (Blueprint $table) {
        $table->foreignId('jenis_budidaya_id')
            ->after('komoditas_budidaya_id')
            ->constrained('jenis_budidayas')
            ->onDelete('cascade');

        $table->dropColumn('jumlah_pembudidaya');
    });
}

public function down(): void
{
    Schema::table('data_bulanan_budidayas', function (Blueprint $table) {
        $table->dropForeign(['jenis_budidaya_id']);
        $table->dropColumn('jenis_budidaya_id');
        $table->unsignedInteger('jumlah_pembudidaya')->nullable();
    });
}
};
