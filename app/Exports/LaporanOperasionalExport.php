<?php

namespace App\Exports;

use App\Models\LaporanOperasional;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanOperasionalExport implements FromArray, ShouldAutoSize, WithEvents
{
    protected array $judulRows = [];
    protected array $sectionRows = [];
    protected array $tableHeaderRows = [];
    protected int $lastRow = 0;

    public function __construct(protected LaporanOperasional $laporan)
    {
    }

    public function array(): array
    {
        $rows = [];

        // --- Helper kecil: tambah baris, lalu balikin nomor baris Excel-nya (1-indexed) ---
        $tambah = function (array $baris) use (&$rows): int {
            $rows[] = $baris;
            return count($rows); // nomor baris = posisi terakhir di array, selalu akurat
        };

        $this->judulRows[] = $tambah(['DAFTAR REKAPITULASI AKTIVITAS BULANAN PELABUHAN PERIKANAN']);

        $tambah(['Pelabuhan', ':', $this->laporan->pelabuhan->nama ?? '-']);
        $tambah(['Kabupaten/Kota', ':', $this->laporan->pelabuhan->kabupatenIkan->nama_kabupaten ?? '-']);
        $tambah(['Bulan', ':', $this->laporan->nama_bulan . ' ' . $this->laporan->tahun]);
        $tambah(['']); // baris jarak -- diisi 1 sel kosong, BUKAN array kosong, biar tetap kehitung 1 baris

        $this->sectionRows[] = $tambah(['DATA ARMADA TANGKAP (PER TRIP)']);
        $this->tableHeaderRows[] = $tambah(['No', 'Nama Kapal', 'Tanggal Berangkat', 'Jenis Alat Tangkap', 'Ukuran (GT)', 'ABK', 'Dokumen']);
        foreach ($this->laporan->armadaTangkap as $i => $a) {
            $tambah([
                $i + 1,
                $a->nama_armada ?? '-',
                optional($a->tanggal_berangkat)->format('d-m-Y') ?? '-',
                $a->jenis_alat_tangkap ?? '-',
                $a->ukuran_kapal,
                $a->jumlah_abk,
                $a->dokumens->pluck('nama_dokumen')->join(', ') ?: '-',
            ]);
        }
        $tambah(['']);

        $this->sectionRows[] = $tambah(['PRODUKSI IKAN DOMINAN & NILAI PRODUKSI']);
        $this->tableHeaderRows[] = $tambah(['No', 'Jenis Ikan', 'Produksi (Kg)', 'Harga (Rp)', 'Nilai (Rp)']);
        foreach ($this->laporan->produksiIkan as $i => $p) {
            $tambah([$i + 1, $p->jenis_ikan, $p->produksi_kg, $p->harga_rp, $p->nilai_rp]);
        }
        $tambah(['']);

        $this->sectionRows[] = $tambah(['LOGISTIK']);
        $this->tableHeaderRows[] = $tambah(['No', 'Kebutuhan', 'Jumlah', 'Satuan', 'Harga (Rp)', 'Total (Rp)']);
        foreach ($this->laporan->logistik as $i => $lg) {
            $tambah([$i + 1, $lg->nama_item, $lg->jumlah, $lg->satuan, $lg->harga_rp, $lg->total_rp]);
        }
        $tambah(['']);

        $this->sectionRows[] = $tambah(['DATA PEMASARAN']);
        $this->tableHeaderRows[] = $tambah(['No', 'Kategori', 'Jenis Ikan', 'Quantity (Kg)', 'Tujuan', 'Nama PT']);
        foreach ($this->laporan->pemasaran as $i => $pm) {
            $tambah([$i + 1, $pm->kategori, $pm->jenis_ikan, $pm->quantity_kg, $pm->tujuan, $pm->nama_pt]);
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

                foreach ($this->sectionRows as $row) {
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