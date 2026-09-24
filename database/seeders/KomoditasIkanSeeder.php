<?php

namespace Database\Seeders;

use App\Models\KomoditasIkan;
use Illuminate\Database\Seeder;

class KomoditasIkanSeeder extends Seeder
{
    /**
     * Sumber data: sheet "Master Produksi" kolom Jenis_Ikan / Nama_Latin /
     * Kode_FAO / Kelompok_Sdi, Kertas_Kerja_Laut_Provinsi_R2.xlsx (1.731 spesies).
     *
     * Catatan: banyak spesies berbeda punya nama umum (nama_ikan) yang sama
     * tapi nama_latin beda, makanya unique constraint di migration sudah
     * diubah jadi gabungan (nama_ikan + nama_latin) supaya semua bisa masuk.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/komoditas_ikan.csv');

        if (! file_exists($path)) {
            $this->command?->warn("File tidak ditemukan: $path");
            return;
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle); // jenis_ikan_nama_latin,jenis_ikan,nama_latin,kode_fao,kelompok_sdi

        $count = 0;
        $rows = [];
        while (($row = fgetcsv($handle)) !== false) {
            $namaIkan = trim($row[1] ?? '');
            if ($namaIkan === '') {
                continue;
            }

            $rows[] = [
                'nama_ikan' => $namaIkan,
                'nama_latin' => trim($row[2] ?? '') ?: null,
                'kode_fao' => trim($row[3] ?? '') ?: null,
                'kelompok_sdi' => trim($row[4] ?? '') ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $count++;

            // insert per batch 500 baris biar hemat query
            if (count($rows) >= 500) {
                KomoditasIkan::upsert($rows, ['nama_ikan', 'nama_latin'], ['kode_fao', 'kelompok_sdi', 'updated_at']);
                $rows = [];
            }
        }
        if (! empty($rows)) {
            KomoditasIkan::upsert($rows, ['nama_ikan', 'nama_latin'], ['kode_fao', 'kelompok_sdi', 'updated_at']);
        }
        fclose($handle);

        $this->command?->info("KomoditasIkanSeeder: $count spesies ikan di-seed.");
    }
}
