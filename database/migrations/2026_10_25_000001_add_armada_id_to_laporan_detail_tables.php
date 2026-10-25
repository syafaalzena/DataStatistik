<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tabel = [
        'laporan_produksi_ikans',
        'laporan_logistiks',
        'laporan_pemasarans',
    ];

    public function up(): void
    {
        foreach ($this->tabel as $nama) {
            Schema::table($nama, function (Blueprint $table) {
                // Kalau kapal dihapus, data produksi/logistik/pemasaran miliknya ikut terhapus
                $table->foreignId('laporan_armada_tangkap_id')
                    ->nullable()
                    ->after('laporan_operasional_id')
                    ->constrained('laporan_armada_tangkaps')
                    ->cascadeOnDelete();
            });
        }

        // Data lama belum punya kaitan ke kapal: masukkan ke kapal pertama di laporan yang sama
        foreach ($this->tabel as $nama) {
            $rows = DB::table($nama)->whereNull('laporan_armada_tangkap_id')->select('id', 'laporan_operasional_id')->get();
            foreach ($rows as $r) {
                $kapalId = DB::table('laporan_armada_tangkaps')
                    ->where('laporan_operasional_id', $r->laporan_operasional_id)
                    ->orderBy('urutan')->orderBy('id')
                    ->value('id');
                if ($kapalId) {
                    DB::table($nama)->where('id', $r->id)->update(['laporan_armada_tangkap_id' => $kapalId]);
                }
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tabel as $nama) {
            Schema::table($nama, function (Blueprint $table) {
                $table->dropConstrainedForeignId('laporan_armada_tangkap_id');
            });
        }
    }
};
