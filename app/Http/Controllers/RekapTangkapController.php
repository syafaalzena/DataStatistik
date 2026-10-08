<?php

namespace App\Http\Controllers;

use App\Models\KabupatenIkan;
use App\Models\ProduksiTangkap;
use App\Models\TripTangkap;
use App\Models\TahunanTangkap;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapTangkapController extends Controller
{
    public function bulanan(Request $request)
    {
        $data = $this->dataBulanan($request);

        return view('tangkap.rekap-bulanan', $data);
    }

   public function exportBulanan(Request $request)
{
    $data = $this->dataBulanan($request);

    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\RekapTangkapProvinsiExport($data, 'exports.rekap_produksi_tangkap_provinsi'),
        'rekap-produksi-tangkap-bulanan.xlsx'
    );
}

    public function exportPdfBulanan(Request $request)
    {
        $data = $this->dataBulanan($request);

        $pdf = Pdf::loadView('exports.rekap_produksi_tangkap_provinsi', $data)->setPaper('a4', 'landscape');

        return $pdf->download('rekap-produksi-tangkap-bulanan.pdf');
    }

    public function tahunan(Request $request)
    {
        $data = $this->dataTahunan($request);

        return view('tangkap.rekap-tahunan', $data);
    }

    public function exportTahunan(Request $request)
{
    $data = $this->dataTahunan($request);

    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\RekapTangkapProvinsiExport($data, 'exports.rekap_tahunan_tangkap_provinsi'),
        'rekap-tahunan-tangkap.xlsx'
    );
}

    public function exportPdfTahunan(Request $request)
    {
        $data = $this->dataTahunan($request);

        $pdf = Pdf::loadView('exports.rekap_tahunan_tangkap_provinsi', $data)->setPaper('a4', 'portrait');

        return $pdf->download('rekap-tahunan-tangkap.pdf');
    }

    private function dataBulanan(Request $request): array
    {
        $bulanAwal = (int) $request->input('bulan_awal', 1);
        $tahunAwal = (int) $request->input('tahun_awal', now()->year);
        $bulanAkhir = (int) $request->input('bulan_akhir', now()->month);
        $tahunAkhir = (int) $request->input('tahun_akhir', now()->year);
        $kabupatenId = $request->input('kabupaten_id');
        $includeTrip = $request->boolean('include_trip');

        $awal = $tahunAwal * 12 + $bulanAwal;
        $akhir = $tahunAkhir * 12 + $bulanAkhir;
        [$lo, $hi] = [min($awal, $akhir), max($awal, $akhir)];

        $query = ProduksiTangkap::with(['kabupatenIkan', 'komoditasIkan']);
        if ($kabupatenId) {
            $query->where('kabupaten_ikan_id', $kabupatenId);
        }

        $produksi = $query->get()->filter(function ($r) use ($lo, $hi) {
            $k = $r->tahun * 12 + $r->bulan;
            return $k >= $lo && $k <= $hi;
        });

        $bulanNama = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $periodKeys = $produksi->map(fn ($r) => $r->tahun * 12 + $r->bulan)->unique()->sort()->values();
        $periodLabels = $periodKeys->map(function ($k) use ($bulanNama) {
            $tahun = intdiv($k - 1, 12);
            $bulan = ($k - 1) % 12 + 1;
            return $bulanNama[$bulan - 1] . " '" . substr($tahun, -2);
        });

        $rekap = $produksi->groupBy('kabupaten_ikan_id')->map(function ($rows) use ($periodKeys) {
            $perIkan = $rows->groupBy('komoditas_ikan_id')->map(function ($r2) use ($periodKeys) {
                $perPeriode = [];
                foreach ($periodKeys as $pk) {
                    $perPeriode[$pk] = $r2->filter(fn ($r) => ($r->tahun * 12 + $r->bulan) === $pk)
                        ->sum('volume_produksi_kg');
                }
                return [
                    'jenis_ikan' => $r2->first()->komoditasIkan->nama_ikan ?? '-',
                    'total_volume' => $r2->sum('volume_produksi_kg'),
                    'total_nilai' => $r2->sum('nilai_rp'),
                    'per_periode' => $perPeriode,
                ];
            })->sortByDesc('total_volume')->values();

            return [
                'kabupaten_id' => $rows->first()->kabupaten_ikan_id,
                'kabupaten' => $rows->first()->kabupatenIkan->nama_kabupaten ?? '-',
                'per_ikan' => $perIkan,
                'total_volume_kabupaten' => $rows->sum('volume_produksi_kg'),
                'total_nilai_kabupaten' => $rows->sum('nilai_rp'),
            ];
        })->sortBy('kabupaten')->values();

        $grandVolume = $produksi->sum('volume_produksi_kg');
        $grandNilai = $produksi->sum('nilai_rp');

        $rekapTrip = collect();
        $grandTrip = 0;
        if ($includeTrip) {
            $tripQuery = TripTangkap::with('kabupatenIkan');
            if ($kabupatenId) {
                $tripQuery->where('kabupaten_ikan_id', $kabupatenId);
            }
            $trip = $tripQuery->get()->filter(function ($t) use ($lo, $hi) {
                $k = $t->tahun * 12 + $t->bulan;
                return $k >= $lo && $k <= $hi;
            });

            $rekapTrip = $trip->groupBy('kabupaten_ikan_id')->map(function ($rows) {
                return [
                    'kabupaten' => $rows->first()->kabupatenIkan->nama_kabupaten ?? '-',
                    'total_trip' => $rows->sum('jumlah_trip'),
                ];
            })->sortBy('kabupaten')->values();

            $grandTrip = $trip->sum('jumlah_trip');
        }

        $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $periode = ($namaBulan[$bulanAwal] ?? $bulanAwal) . " $tahunAwal - " . ($namaBulan[$bulanAkhir] ?? $bulanAkhir) . " $tahunAkhir";

        $kabupatenTertinggi = $rekap->sortByDesc('total_volume_kabupaten')->first();

        return compact(
            'rekap', 'grandVolume', 'grandNilai', 'periode', 'periodKeys', 'periodLabels',
            'bulanAwal', 'tahunAwal', 'bulanAkhir', 'tahunAkhir', 'kabupatenId',
            'includeTrip', 'rekapTrip', 'grandTrip', 'kabupatenTertinggi'
        ) + ['kabupatens' => KabupatenIkan::orderBy('nama_kabupaten')->get()];
    }

    private function dataTahunan(Request $request): array
    {
       $tahun = (int) $request->input('tahun', now()->year);
$tahunAwal = $tahunAkhir = $tahun;
[$tLo, $tHi] = [$tahun, $tahun];
        $kabupatenId = $request->input('kabupaten_id');

        $query = TahunanTangkap::with(['kabupatenIkan', 'pelabuhan'])
            ->whereBetween('tahun', [$tLo, $tHi]);

        if ($kabupatenId) {
            $query->where('kabupaten_ikan_id', $kabupatenId);
        }

        $tahunan = $query->get();

        $rekap = $tahunan->groupBy('kabupaten_ikan_id')->map(function ($rows) {
            $perPelabuhan = $rows->groupBy('pelabuhan_id')->map(function ($r2) {
                return [
                    'pelabuhan' => $r2->first()->pelabuhan->nama ?? '-',
                    'rtp' => $r2->sum('jumlah_rtp'),
                    'kapal' => $r2->sum('jumlah_kapal'),
                    'api' => $r2->sum('jumlah_api'),
                    'nelayan_buruh' => $r2->sum('jumlah_nelayan_buruh'),
                    'nelayan' => $r2->sum('jumlah_nelayan'),
                ];
            })->values();

            return [
                'kabupaten_id' => $rows->first()->kabupaten_ikan_id,
                'kabupaten' => $rows->first()->kabupatenIkan->nama_kabupaten ?? '-',
                'per_pelabuhan' => $perPelabuhan,
                'total_rtp' => $rows->sum('jumlah_rtp'),
                'total_kapal' => $rows->sum('jumlah_kapal'),
                'total_api' => $rows->sum('jumlah_api'),
                'total_nelayan_buruh' => $rows->sum('jumlah_nelayan_buruh'),
                'total_nelayan' => $rows->sum('jumlah_nelayan'),
            ];
        })->sortBy('kabupaten')->values();

        $periode = $tahunAwal == $tahunAkhir ? "$tahunAwal" : "$tahunAwal - $tahunAkhir";

        $grandRtp = $tahunan->sum('jumlah_rtp');
        $grandKapal = $tahunan->sum('jumlah_kapal');
        $grandNelayan = $tahunan->sum('jumlah_nelayan');
        $kabupatenTertinggi = $rekap->sortByDesc('total_nelayan')->first();

        return compact('rekap', 'periode', 'tahunAwal', 'tahunAkhir', 'kabupatenId', 'grandRtp', 'grandKapal', 'grandNelayan', 'kabupatenTertinggi')
            + ['kabupatens' => KabupatenIkan::orderBy('nama_kabupaten')->get()];
    }
}