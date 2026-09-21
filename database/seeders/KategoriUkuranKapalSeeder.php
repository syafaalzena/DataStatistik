<?php

namespace Database\Seeders;

use App\Models\KategoriUkuranKapal;
use Illuminate\Database\Seeder;

class KategoriUkuranKapalSeeder extends Seeder
{
    public function run(): void
    {
        $labels = ['< 5 GT', '6 - 10 GT', '11 - 30 GT', '31 - 60 GT', '61 - 100 GT', '> 100 GT'];

        foreach ($labels as $label) {
            KategoriUkuranKapal::firstOrCreate(['label' => $label]);
        }
    }
}