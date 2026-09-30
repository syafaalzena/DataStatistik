<?php

namespace Database\Seeders;

use App\Models\KabupatenIkan;
use App\Models\Pelabuhan;
use Illuminate\Database\Seeder;

class PelabuhanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Aceh Barat' => ['PP. Ujong Baroeh'],
            'Aceh Barat Daya' => ['PP. Ujung Serangga'],
            'Aceh Besar' => ['PP. Kareung', 'PP. Krueng Raya', 'PP. Lambada', 'PP. Lhok Seudu'],
            'Aceh Jaya' => ['PP. Calang'],
            'Aceh Selatan' => ['PP. Keude Meukek', 'PP. Labuhanhaji', 'PP. Lhok Bengkuang', "PP. Sawang Ba'u"],
            'Aceh Timur' => ['PPN. Idi'],
            'Aceh Utara' => ['PP. Blang Mee', 'PP. Krueng Mane', 'PP. Kuala Cangkoy'],
            'Bireuen' => ['PP. Peudada'],
            'Banda Aceh' => ['PPS. Kuta Raja'],
            'Langsa' => ['PP. Kuala Langsa'],
            'Lhokseumawe' => ['PP. Pusong'],
            'Sabang' => ['PP. Ie Meulee'],
            'Nagan Raya' => ['PP. Kuala Tadu', 'PP. Kuala Tuha'],
            'Pidie' => ['PP. Kuala Gigieng', 'PP. Kuala Peukan Baro', 'PP. Kuala Tari'],
            'Pidie Jaya' => ['PP. Mereudu', 'PP. Pante Raja'],
            'Simeulue' => ['PP. Teluk Sinabang'],
        ];

        foreach ($data as $namaKabupaten => $daftarPelabuhan) {
            $kabupaten = KabupatenIkan::where('nama_kabupaten', $namaKabupaten)->first();

            if (!$kabupaten) {
                $this->command->warn("Kabupaten '$namaKabupaten' tidak ditemukan, dilewati.");
                continue;
            }

            foreach ($daftarPelabuhan as $namaPelabuhan) {
                Pelabuhan::firstOrCreate([
                    'kabupaten_ikan_id' => $kabupaten->id,
                    'nama' => $namaPelabuhan,
                ], [
                    'jenis_lk' => 'Pelabuhan',
                ]);
            }
        }

        $this->command->info('Seeder pelabuhan selesai.');
    }
}