<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RekapTahunanOperasionalExport implements FromArray, ShouldAutoSize, WithEvents
{
    protected array $judulRows = [];
    protected array $kabupatenRows = [];
    protected array $tableHeaderRows = [];
    protected int $lastRow = 0;

    public function __construct(
        protected Collection $laporans,
        protected int $tahun,
        protected float $grandTotalProduksi,
        protected float $grandTotalNilai,
        protected string $keterangan = '',
    ) {
    }

    public function array(): array
    {
        $rows = [];

        $tambah = function (array $baris) use (&$rows): int {
            $rows[] = $baris;
            return count($rows);
        };

        $this->judulRows[] = $tambah(['REKAP TAHUNAN LAPORAN OPERASIONAL PELABUHAN PERIKANAN - TAHUN ' . $this->tahun]);
        if ($this->keterangan !== '') {
            $tambah(['Filter: ' . $this->keterangan]);
        }
        $tambah(['Total Produksi (Kg)', $this->grandTotalProduksi]);
        $tambah(['Total Nilai Produksi (Rp)', $this->grandTotalNilai]);
        $tambah(['']);

        foreach ($this->laporans as $namaKabupaten => $group) {
            $this->kabupatenRows[] = $tambah([$namaKabupaten]);
            $this->tableHeaderRows[] = $tambah([
                'Pelabuhan', 'Bulan', 'Nama Kapal', 'Ukuran (GT)', 'Berangkat', 'Pulang',
                'ABK', 'Produksi (Kg)', 'Nilai Produksi (Rp)', 'Logistik (Rp)',
            ]);

            foreach ($group as $r) {
                $tambah([
                    $r->pelabuhan, $r->bulan, $r->nama_kapal, $r->ukuran, $r->berangkat, $r->pulang,
                    $r->abk, $r->produksi_kg, $r->nilai_rp, $r->logistik_rp,
                ]);
            }

            $tambah([
                'Subtotal ' . $namaKabupaten, '', '', '', '', '',
                $group->sum('abk'), $group->sum('produksi_kg'), $group->sum('nilai_rp'), $group->sum('logistik_rp'),
            ]);
            $tambah(['']);
        }

        $this->lastRow = count($rows);

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                foreach ($this->judulRows as $row) {
                    $sheet->mergeCells("A{$row}:J{$row}");
                    $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(13);
                    $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                foreach ($this->kabupatenRows as $row) {
                    $sheet->mergeCells("A{$row}:J{$row}");
                    $style = $sheet->getStyle("A{$row}");
                    $style->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
                    $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('0F172A');
                }

                foreach ($this->tableHeaderRows as $row) {
                    $style = $sheet->getStyle("A{$row}:J{$row}");
                    $style->getFont()->setBold(true);
                    $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F1F5F9');
                }

                $sheet->getStyle("A1:J{$this->lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}