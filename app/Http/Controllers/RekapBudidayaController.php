<?php

namespace App\Http\Controllers;

use App\Models\KabupatenIkan;
use App\Models\DataBulananBudidaya;
use App\Models\DataTahunanSarana;
use Illuminate\Http\Request;

class RekapBudidayaController extends Controller
{
    private $bulanNama = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    // ============ REKAP BULANAN ============
    // per kabupaten -> per komoditas -> total kg (dalam rentang bulan-tahun yang dipilih) + total per kabupaten
    public function bulanan(Request $request)
    {
        $bulanAwal = (int) $request->input('bulan_awal', 1);
        $tahunAwal = (int) $request->input('tahun_awal', now()->year);
        $bulanAkhir = (int) $request->input('bulan_akhir', now()->month);
        $tahunAkhir = (int) $request->input('tahun_akhir', now()->year);

        $awal = $tahunAwal * 12 + $bulanAwal;
        $akhir = $tahunAkhir * 12 + $bulanAkhir;
        [$lo, $hi] = [min($awal, $akhir), max($awal, $akhir)];

        $data = DataBulananBudidaya::with(['kabupaten', 'komoditas'])
            ->get()
            ->filter(function ($r) use ($lo, $hi) {
                $k = $r->tahun * 12 + $r->bulan;
                return $k >= $lo && $k <= $hi;
            });

        $rekap = $this->kelompokkanProduksiPerKabupaten($data);
        $grandTotal = $data->sum('hasil_produksi');

        return view('budidaya.rekapBulanan', compact(
            'rekap', 'grandTotal', 'bulanAwal', 'tahunAwal', 'bulanAkhir', 'tahunAkhir'
        ));
    }

    // ============ REKAP TAHUNAN ============
    // per kabupaten -> per komoditas -> total kg setahun/beberapa tahun
    // + per kabupaten -> per jenis budidaya -> jumlah pembudidaya & luas lahan
    public function tahunan(Request $request)
    {
        $tahunAwal = (int) $request->input('tahun_awal', now()->year);
        $tahunAkhir = (int) $request->input('tahun_akhir', now()->year);
        [$tLo, $tHi] = [min($tahunAwal, $tahunAkhir), max($tahunAwal, $tahunAkhir)];

        $produksi = DataBulananBudidaya::with(['kabupaten', 'komoditas'])
            ->whereBetween('tahun', [$tLo, $tHi])
            ->get();

        $sarana = DataTahunanSarana::with(['kabupaten', 'jenis'])
            ->whereBetween('tahun', [$tLo, $tHi])
            ->get();

        $rekapProduksi = $this->kelompokkanProduksiPerKabupaten($produksi);
        $rekapSarana = $this->kelompokkanSaranaPerKabupaten($sarana);

        // gabungkan jadi satu per kabupaten, biar di blade tinggal 1x loop
        $kabupatens = KabupatenIkan::orderBy('nama_kabupaten')->get();
        $gabungan = $kabupatens->map(function ($kab) use ($rekapProduksi, $rekapSarana) {
            return [
                'kabupaten' => $kab->nama_kabupaten,
                'produksi' => $rekapProduksi->firstWhere('kabupaten_id', $kab->id),
                'sarana' => $rekapSarana->firstWhere('kabupaten_id', $kab->id),
            ];
        })->filter(fn ($k) => $k['produksi'] || $k['sarana'])->values();

        return view('budidaya.rekapTahunan', compact('gabungan', 'tahunAwal', 'tahunAkhir'));
    }

    // ============ helper ============

    private function kelompokkanProduksiPerKabupaten($data)
    {
        return $data->groupBy('kabupaten_ikan_id')->map(function ($rows) {
            $perKomoditas = $rows->groupBy('komoditas_budidaya_id')->map(function ($r2) {
                return [
                    'komoditas' => $r2->first()->komoditas->nama_komoditas,
                    'total' => $r2->sum('hasil_produksi'),
                ];
            })->sortByDesc('total')->values();

            return [
                'kabupaten_id' => $rows->first()->kabupaten_ikan_id,
                'kabupaten' => $rows->first()->kabupaten->nama_kabupaten,
                'per_komoditas' => $perKomoditas,
                'total_kabupaten' => $rows->sum('hasil_produksi'),
            ];
        })->sortBy('kabupaten')->values();
    }

    private function kelompokkanSaranaPerKabupaten($data)
    {
        return $data->groupBy('kabupaten_ikan_id')->map(function ($rows) {
            $perJenis = $rows->groupBy('jenis_budidaya_id')->map(function ($r2) {
                return [
                    'jenis' => $r2->first()->jenis->nama_jenis,
                    'rtp' => $r2->sum('jumlah_rtp'),
                    'pembudidaya' => $r2->sum('jumlah_pembudidaya'),
                    'luas_lahan' => $r2->sum('luas_lahan'),
                ];
            })->values();

            return [
                'kabupaten_id' => $rows->first()->kabupaten_ikan_id,
                'kabupaten' => $rows->first()->kabupaten->nama_kabupaten,
                'per_jenis' => $perJenis,
                'total_pembudidaya' => $rows->sum('jumlah_pembudidaya'),
                'total_luas_lahan' => $rows->sum('luas_lahan'),
            ];
        })->sortBy('kabupaten')->values();
    }
}