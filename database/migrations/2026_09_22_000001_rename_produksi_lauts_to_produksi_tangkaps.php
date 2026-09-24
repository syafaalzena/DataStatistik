<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fix untuk bug lama: migration awal sempat membuat tabel dengan nama
     * 'produksi_lauts' padahal seharusnya 'produksi_tangkaps'. Migration ini
     * aman dijalankan baik di database yang sudah kadung punya tabel lama,
     * maupun di database baru yang sudah benar dari awal (tidak melakukan apa-apa).
     */
    public function up(): void
    {
        if (Schema::hasTable('produksi_lauts') && ! Schema::hasTable('produksi_tangkaps')) {
            Schema::rename('produksi_lauts', 'produksi_tangkaps');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('produksi_tangkaps') && ! Schema::hasTable('produksi_lauts')) {
            Schema::rename('produksi_tangkaps', 'produksi_lauts');
        }
    }
};
