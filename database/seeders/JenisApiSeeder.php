<?php

namespace Database\Seeders;

use App\Models\JenisApi;
use Illuminate\Database\Seeder;

class JenisApiSeeder extends Seeder
{
    /**
     * Sumber data: kolom Jenis_API pada sheet "Master Produksi",
     * Kertas_Kerja_Laut_Provinsi_R2.xlsx (81 jenis alat tangkap).
     */
    public function run(): void
    {
        $path = database_path('seeders/data/jenis_api.csv');

        if (! file_exists($path)) {
            $this->command?->warn("File tidak ditemukan: $path");
            return;
        }

        $handle = fopen($path, 'r');
        fgetcsv($handle); // lewati header

        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $nama = trim($row[0] ?? '');
            if ($nama === '') {
                continue;
            }
            JenisApi::firstOrCreate(['nama' => $nama]);
            $count++;
        }
        fclose($handle);

        $this->command?->info("JenisApiSeeder: $count jenis API di-seed.");
    }
}
