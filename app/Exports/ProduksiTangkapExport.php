<?php

namespace App\Exports;

use App\Models\ProduksiTangkap;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProduksiTangkapExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $kabupatenId;
    protected $namaKabupaten;
    protected $filters;

    public function __construct($kabupatenId, $namaKabupaten, $filters = [])
    {
        $this->kabupatenId = $kabupatenId;
        $this->namaKabupaten = $namaKabupaten;
        $this->filters = $filters;
    }

    public function collection()
    {
        $namaBulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];

        $query = ProduksiTangkap::with([
            'pelabuhan', 'wppnri', 'jenisApi', 'kategoriUkuranKapal', 'komoditasIkan', 'kabupatenIkan',
        ])->where('kabupaten_ikan_id', $this->kabupatenId);

        if (!empty($this->filters['tahun'])) {
            $query->where('tahun', $this->filters['tahun']);
        }
        if (!empty($this->filters['bulan'])) {
            $query->where('bulan', $this->filters['bulan']);
        } elseif (!empty($this->filters['semester'])) {
            $range = $this->filters['semester'] == 1 ? [1, 6] : [7, 12];
            $query->whereBetween('bulan', $range);
        }

        return $query->orderBy('tahun')->orderBy('bulan')->get()->map(function ($d) use ($namaBulan) {
            return [
                $d->tahun,
                $namaBulan[$d->bulan] ?? $d->bulan,
                'TW ' . $d->triwulan,
                'Semester ' . $d->semester,
                $d->kabupatenIkan->nama_kabupaten ?? '-',
                $d->pelabuhan->nama ?? '-',
                $d->wppnri->kode ?? '-',
                $d->jenis_lk,
                $d->kategoriUkuranKapal->label ?? '-',
                $d->jenisApi->nama ?? '-',
                $d->komoditasIkan->nama_ikan ?? '-',
                $d->komoditasIkan->nama_latin ?? '-',
                $d->komoditasIkan->kode_fao ?? '-',
                $d->komoditasIkan->kelompok_sdi ?? '-',
                $d->volume_produksi_kg,
                $d->harga_rp,
                $d->nilai_rp,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tahun', 'Bulan', 'Triwulan', 'Semester', 'Kabupaten_Kota', 'Pelabuhan',
            'WPPNRI', 'Jenis_LK', 'Kategori_Ukuran_Kapal', 'Jenis_API',
            'Jenis_Ikan', 'Nama_Latin', 'Kode_FAO', 'Kelompok_SDI',
            'Volume_Produksi_Kg', 'Harga_Rp', 'Nilai_Rp',
        ];
    }

    public function title(): string
    {
        return '2. Input Produksi';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF0F172A'],
                ],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8, 'B' => 12, 'C' => 10, 'D' => 12, 'E' => 18, 'F' => 20,
            'G' => 10, 'H' => 14, 'I' => 18, 'J' => 16,
            'K' => 18, 'L' => 18, 'M' => 12, 'N' => 16,
            'O' => 16, 'P' => 14, 'Q' => 16,
        ];
    }
}