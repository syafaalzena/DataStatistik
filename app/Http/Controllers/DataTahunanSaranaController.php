<?php

namespace App\Http\Controllers;

use App\Models\DataBulananBudidaya;
use App\Models\DataTahunanSarana;
use App\Exports\RecapBudidayaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapBudidayaController extends Controller
{
    public function index(Request $request)
    {
        $bulanAwal = (int) $request->input('bulan_awal', 1);
        $tahunAwal = (int) $request->input('tahun_awal', now()->year);
        $bulanAkhir = (int) $request->input('bulan_akhir', now()->month);
        $tahunAkhir = (int) $request->input('tahun_akhir', now()->year);

        $produksi = $this->ambilProduksiRentang($bulanAwal, $tahunAwal, $bulanAkhir, $tahunAkhir);
        $sarana = DataTahunanSarana::with(['kabupaten', 'jenis'])
            ->whereBetween('tahun', [$tahunAwal, $tahunAkhir])
            ->get();

        $rekapProduksi = $this->rekapProduksiPerKabupaten($produksi);
        $rekapSarana = $this->rekapSaranaPerKabupaten($sarana);
        $trenBulanan = $this->trenProduksiPerBulan($produksi);

        return view('budidaya.rekap', compact(
            'rekapProduksi', 'rekapSarana', 'trenBulanan',
            'bulanAwal', 'tahunAwal', 'bulanAkhir', 'tahunAkhir'
        ));
    }

    public function exportExcel(Request $request)
    {
        $bulanAwal = (int) $request->input('bulan_awal', 1);
        $tahunAwal = (int) $request->input('tahun_awal', now()->year);
        $bulanAkhir = (int) $request->input('bulan_akhir', now()->month);
        $tahunAkhir = (int) $request->input('tahun_akhir', now()->year);

        $produksi = $this->ambilProduksiRentang($bulanAwal, $tahunAwal, $bulanAkhir, $tahunAkhir);
        $sarana = DataTahunanSarana::with(['kabupaten', 'jenis'])
            ->whereBetween('tahun', [$tahunAwal, $tahunAkhir])
            ->get();

        $namaFile = "Rekap-Budidaya-Aceh_{$tahunAwal}-{$bulanAwal}_sd_{$tahunAkhir}-{$bulanAkhir}.xlsx";

        return Excel::download(new RecapBudidayaExport($produksi, $sarana), $namaFile);
    }

    private function ambilProduksiRentang(int $bulanAwal, int $tahunAwal, int $bulanAkhir, int $tahunAkhir)
    {
        $awal = $tahunAwal * 12 + $bulanAwal;
        $akhir = $tahunAkhir * 12 + $bulanAkhir;
        [$lo, $hi] = [min($awal, $akhir), max($awal, $akhir)];

        return DataBulananBudidaya::with(['kabupaten', 'komoditas', 'jenis'])
            ->get()
            ->filter(function ($r) use ($lo, $hi) {
                $k = $r->tahun * 12 + $r->bulan;
                return $k >= $lo && $k <= $hi;
            })
            ->values();
    }

    private function rekapProduksiPerKabupaten($produksi)
    {
        return $produksi->groupBy('kabupaten_ikan_id')->map(function ($rows) {
            return [
                'kabupaten' => $rows->first()->kabupaten->nama_kabupaten,
                'total_produksi' => $rows->sum('hasil_produksi'),
                'jenis_komoditas' => $rows->pluck('komoditas_budidaya_id')->unique()->count(),
                'jenis_budidaya' => $rows->pluck('jenis_budidaya_id')->unique()->count(),
                'jumlah_entri' => $rows->count(),
            ];
        })->sortByDesc('total_produksi')->values();
    }

    private function rekapSaranaPerKabupaten($sarana)
    {
        return $sarana->groupBy('kabupaten_ikan_id')->map(function ($rows) {
            return [
                'kabupaten' => $rows->first()->kabupaten->nama_kabupaten,
                'total_rtp' => $rows->sum('jumlah_rtp'),
                'total_pembudidaya' => $rows->sum('jumlah_pembudidaya'),
                'total_luas_lahan' => $rows->sum('luas_lahan'),
            ];
        })->sortByDesc('total_rtp')->values();
    }

    private function trenProduksiPerBulan($produksi)
    {
        $bulanNama = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        return $produksi->groupBy(fn ($r) => $r->tahun * 12 + $r->bulan)
            ->sortKeys()
            ->map(function ($rows, $key) use ($bulanNama) {
                $tahun = intdiv($key, 12);
                $bulan = $key - $tahun * 12;
                return [
                    'label' => $bulanNama[$bulan - 1] . ' ' . $tahun,
                    'total' => $rows->sum('hasil_produksi'),
                ];
            })->values();
    }
}