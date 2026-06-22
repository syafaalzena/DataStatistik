<?php

namespace App\Exports;

use App\Models\DataBulanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DetailProduksiExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $type;
    protected $tahun;
    protected $bulan;
    protected $kabupaten_id;

    public function __construct($type = 'bulanan', $tahun = null, $bulan = null, $kabupaten_id = null)
    {
        $this->type         = $type;
        $this->tahun        = $tahun;
        $this->bulan        = $bulan;
        $this->kabupaten_id = $kabupaten_id;
    }

    public function collection()
    {
        if ($this->type === 'tahunan') {
            $query = DataBulanan::with('kabupaten')
                ->select('tahun', 'jenis_produksi', 'lokasi')
                ->selectRaw('SUM(produksi) as total_produksi, SUM(harga) as total_harga, SUM(jumlah_petani) as total_petani')
                ->groupBy('tahun', 'jenis_produksi', 'lokasi')
                ->orderBy('tahun');

            if ($this->tahun) $query->where('tahun', $this->tahun);
            if ($this->kabupaten_id) $query->where('kabupaten_id', $this->kabupaten_id);

            return $query->get()->map(fn($row) => [
                $row->tahun,
                $row->jenis_produksi,
                $row->lokasi,
                $row->total_produksi,
                $row->total_harga,
                $row->total_petani,
            ]);
        }

        $query = DataBulanan::with('kabupaten')
            ->select('tahun', 'bulan', 'jenis_produksi', 'lokasi', 'nama_kelompok', 'jumlah_petani', 'produksi', 'harga')
            ->orderBy('tahun')
            ->orderBy('bulan');

        if ($this->tahun) $query->where('tahun', $this->tahun);
        if ($this->bulan) $query->where('bulan', $this->bulan);
        if ($this->kabupaten_id) $query->where('kabupaten_id', $this->kabupaten_id);

        return $query->get()->map(fn($row) => [
            $row->tahun,
            $row->bulan,
            $row->jenis_produksi,
            $row->lokasi,
            $row->nama_kelompok,
            $row->jumlah_petani,
            $row->produksi,
            $row->harga,
        ]);
    }

    public function headings(): array
    {
        if ($this->type === 'tahunan') {
            return ['Tahun', 'Jenis Produksi', 'Lokasi', 'Total Produksi', 'Total Harga', 'Total Petani'];
        }

        return ['Tahun', 'Bulan', 'Jenis Produksi', 'Lokasi', 'Nama Kelompok', 'Jumlah Petani', 'Produksi', 'Harga'];
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = $this->type === 'tahunan' ? 'F' : 'H';

        return [
            // Header row: bold + background hijau + teks putih
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2E7D32'],
                ],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        if ($this->type === 'tahunan') {
            return [
                'A' => 10,  // Tahun
                'B' => 20,  // Jenis Produksi
                'C' => 20,  // Lokasi
                'D' => 18,  // Total Produksi
                'E' => 18,  // Total Harga
                'F' => 15,  // Total Petani
            ];
        }

        return [
            'A' => 10,  // Tahun
            'B' => 10,  // Bulan
            'C' => 20,  // Jenis Produksi
            'D' => 20,  // Lokasi
            'E' => 20,  // Nama Kelompok
            'F' => 15,  // Jumlah Petani
            'G' => 15,  // Produksi
            'H' => 15,  // Harga
        ];
    }
}