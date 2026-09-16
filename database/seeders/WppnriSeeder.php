<?php

namespace Database\Seeders;

use App\Models\Wppnri;
use Illuminate\Database\Seeder;

class WppnriSeeder extends Seeder
{
    public function run(): void
    {
        $kodes = [
            'WPPNRI 571', 'WPPNRI 572', 'WPPNRI 573',
            'WPPNRI 711', 'WPPNRI 712', 'WPPNRI 713',
            'WPPNRI 714', 'WPPNRI 715', 'WPPNRI 716',
            'WPPNRI 717', 'WPPNRI 718',
        ];

        foreach ($kodes as $kode) {
            Wppnri::firstOrCreate(['kode' => $kode]);
        }
    }
}