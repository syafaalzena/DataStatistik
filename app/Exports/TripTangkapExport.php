<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TripTangkapExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
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

        $query = DB::table('trip_tangkaps')
            ->join('pelabuhans', 'pelabuhans.id', '=', 'trip_tangkaps.pelabuhan_id')
            ->join('wppnris', 'wppnris.id', '=', 'trip_tangkaps.wppnri_id')
            ->join('jenis_apis', 'jenis_apis.id', '=', 'trip_tangkaps.jenis_api_id')
            ->join('kategori_ukuran_kapals', 'kategori_ukuran_kapals.id', '=', 'trip_tangkaps.kategori_ukuran_kapal_id')
            ->where('trip_tangkaps.kabupaten_ikan_id', $this->kabupatenId);

        if (!empty($this->filters['tahun'])) {
            $query->whereYear('trip_tangkaps.tanggal', $this->filters['tahun']);
        }
        if (!empty($this->filters['semester'])) {
            $range = $this->filters['semester'] == 1 ? [1, 6] : [7, 12];
            $query->whereMonth('trip_tangkaps.tanggal', '>=', $range[0])
                  ->whereMonth('trip_tangkaps.tanggal', '<=', $range[1]);
        }

        $rows = $query->selectRaw('
                YEAR(trip_tangkaps.tanggal) as tahun,
                MONTH(trip_tangkaps.tanggal) as bulan,
                pelabuhans.nama as nama_pelabuhan,
                wppnris.kode as kode_wppnri,
                trip_tangkaps.jenis_lk as jenis_lk,
                jenis_apis.nama as nama_jenis_api,
                kategori_ukuran_kapals.label as label_kategori,
                SUM(trip_tangkaps.jumlah_trip) as total_trip
            ')
            ->groupBy('tahun', 'bulan', 'pelabuhans.nama', 'wppnris.kode', 'trip_tangkaps.jenis_lk', 'jenis_apis.nama', 'kategori_ukuran_kapals.label')
            ->orderBy('tahun')->orderBy('bulan')->orderBy('pelabuhans.nama')
            ->get();

        return $rows->map(function ($r) use ($namaBulan) {
            return [
                $r->tahun, $namaBulan[$r->bulan] ?? $r->bulan, $r->nama_pelabuhan, $r->kode_wppnri,
                $r->jenis_lk, $r->nama_jenis_api, $r->label_kategori, $r->total_trip,
            ];
        });
    }

    public function headings(): array
    {
        return ['Tahun', 'Bulan', 'Pelabuhan', 'WPPNRI', 'Jenis LK', 'Jenis API', 'Ukuran Kapal', 'Total Trip'];
    }

    public function title(): string
    {
        return mb_substr('Trip - ' . $this->namaKabupaten, 0, 31);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0F172A']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 8, 'B' => 12, 'C' => 20, 'D' => 10, 'E' => 14, 'F' => 16, 'G' => 16, 'H' => 12];
    }
}