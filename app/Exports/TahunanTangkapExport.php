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

class TahunanTangkapExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
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
        $query = DB::table('tahunan_tangkaps')
            ->join('pelabuhans', 'pelabuhans.id', '=', 'tahunan_tangkaps.pelabuhan_id')
            ->join('wppnris', 'wppnris.id', '=', 'tahunan_tangkaps.wppnri_id')
            ->join('jenis_apis', 'jenis_apis.id', '=', 'tahunan_tangkaps.jenis_api_id')
            ->join('kategori_ukuran_kapals', 'kategori_ukuran_kapals.id', '=', 'tahunan_tangkaps.kategori_ukuran_kapal_id')
            ->where('tahunan_tangkaps.kabupaten_ikan_id', $this->kabupatenId);

        if (!empty($this->filters['tahun'])) {
            $query->where('tahunan_tangkaps.tahun', $this->filters['tahun']);
        }

        $rows = $query->selectRaw('
                tahunan_tangkaps.tahun as tahun,
                pelabuhans.nama as nama_pelabuhan,
                wppnris.kode as kode_wppnri,
                tahunan_tangkaps.jenis_lk as jenis_lk,
                jenis_apis.nama as nama_jenis_api,
                kategori_ukuran_kapals.label as label_kategori,
                SUM(tahunan_tangkaps.jumlah_rtp) as total_rtp,
                SUM(tahunan_tangkaps.jumlah_kapal) as total_kapal,
                SUM(tahunan_tangkaps.jumlah_api) as total_api,
                SUM(tahunan_tangkaps.jumlah_nelayan_buruh) as total_nelayan_buruh,
                SUM(tahunan_tangkaps.jumlah_nelayan) as total_nelayan
            ')
            ->groupBy(
                'tahunan_tangkaps.tahun', 'pelabuhans.nama', 'wppnris.kode',
                'tahunan_tangkaps.jenis_lk', 'jenis_apis.nama', 'kategori_ukuran_kapals.label'
            )
            ->orderBy('tahunan_tangkaps.tahun')->orderBy('pelabuhans.nama')
            ->get();

        return $rows->map(function ($r) {
            return [
                $r->tahun, $r->nama_pelabuhan, $r->kode_wppnri,
                $r->jenis_lk, $r->nama_jenis_api, $r->label_kategori,
                $r->total_rtp, $r->total_kapal, $r->total_api, $r->total_nelayan_buruh, $r->total_nelayan,
            ];
        });
    }

    public function headings(): array
    {
        return ['Tahun', 'Pelabuhan', 'WPPNRI', 'Jenis LK', 'Jenis API', 'Ukuran Kapal', 'Jumlah RTP', 'Jumlah Kapal', 'Jumlah API', 'Nelayan Buruh', 'Total Nelayan'];
    }

    public function title(): string
    {
        return mb_substr('Tahunan - ' . $this->namaKabupaten, 0, 31);
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
        return ['A' => 8, 'B' => 20, 'C' => 10, 'D' => 14, 'E' => 16, 'F' => 16, 'G' => 12, 'H' => 12, 'I' => 12, 'J' => 14, 'K' => 14];
    }
}
