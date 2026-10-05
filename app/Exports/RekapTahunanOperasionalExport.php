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
        $tambah(['Total Produksi (Kg)', $this->grandTotalProduksi]);
        $tambah(['Total Nilai Produksi (Rp)', $this->grandTotalNilai]);
        $tambah(['']);

        foreach ($this->laporans as $namaKabupaten => $group) {
            $this->kabupatenRows[] = $tambah([$namaKabupaten]);
            $this->tableHeaderRows[] = $tambah(['Pelabuhan', 'Bulan', 'Jumlah Kapal', 'Jumlah ABK', 'Produksi (Kg)', 'Nilai Produksi (Rp)', 'Total Logistik (Rp)']);

            foreach ($group as $l) {
                $tambah([
                    $l->pelabuhan->nama ?? '-',
                    $l->nama_bulan,
                    $l->total_kapal,
                    $l->total_abk,
                    $l->total_produksi_kg,
                    $l->total_nilai_produksi,
                    $l->total_logistik,
                ]);
            }
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
                    $sheet->mergeCells("A{$row}:G{$row}");
                    $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(13);
                    $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                foreach ($this->kabupatenRows as $row) {
                    $sheet->mergeCells("A{$row}:G{$row}");
                    $style = $sheet->getStyle("A{$row}");
                    $style->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
                    $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('0F172A');
                }

                foreach ($this->tableHeaderRows as $row) {
                    $style = $sheet->getStyle("A{$row}:G{$row}");
                    $style->getFont()->setBold(true);
                    $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F1F5F9');
                    $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                }

                $sheet->getStyle("A1:G{$this->lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}