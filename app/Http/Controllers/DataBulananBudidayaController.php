<?php

namespace App\Http\Controllers;

use App\Models\KabupatenIkan;
use App\Models\KomoditasBudidaya;
use App\Models\JenisBudidaya;
use App\Models\DataBulananBudidaya;
use App\Models\DataTahunanSarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudidayaController extends Controller
{
    // Halaman "Pilih Kabupaten"
    public function index()
    {
        $kabupatens = KabupatenIkan::withCount('dataBulananBudidaya')
            ->orderBy('id')
            ->get();

        return view('budidaya.index', compact('kabupatens'));
    }

    // Halaman form input untuk satu kabupaten
    public function input($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

        // komoditas & jenis budidaya keduanya spesifik per kabupaten
        $komoditasList = KomoditasBudidaya::where('kabupaten_ikan_id', $kabupatenId)
            ->orderBy('nama_komoditas')->get();

        $jenisList = JenisBudidaya::where('kabupaten_ikan_id', $kabupatenId)
            ->orderBy('nama_jenis')->get();

        $dataProduksi = DataBulananBudidaya::with(['komoditas', 'jenis'])
            ->where('kabupaten_ikan_id', $kabupatenId)
            ->orderByDesc('tahun')->orderByDesc('bulan')
            ->get();

        $dataSarana = DataTahunanSarana::with('jenis')
            ->where('kabupaten_ikan_id', $kabupatenId)
            ->orderByDesc('tahun')
            ->get();

        return view('budidaya.input', compact(
            'kabupaten', 'komoditasList', 'jenisList', 'dataProduksi', 'dataSarana'
        ));
    }

    // Simpan data produksi bulanan — tiap baris = kombinasi komoditas + jenis budidaya
    public function storeProduksi(Request $request, $kabupatenId)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'keterangan' => 'nullable|string|max:255',

            // tiga array ini sejajar per index: baris ke-0 komoditas_id[0] + jenis_id[0] + produksi[0]
            'komoditas_id'   => 'array',
            'komoditas_id.*' => 'exists:komoditas_budidayas,id',
            'jenis_id'       => 'array',
            'jenis_id.*'     => 'exists:jenis_budidayas,id',
            'produksi'       => 'array',
            'produksi.*'     => 'nullable|numeric|min:0',
        ]);

        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        $keterangan = $validated['keterangan'] ?? null;
        $tersimpan = 0;

        DB::transaction(function () use ($request, $kabupatenId, $bulan, $tahun, $keterangan, &$tersimpan) {
            $komoditasIds = $request->input('komoditas_id', []);
            $jenisIds = $request->input('jenis_id', []);
            $produksiVals = $request->input('produksi', []);

            foreach ($komoditasIds as $i => $komId) {
                $jenisId = $jenisIds[$i] ?? null;
                $produksi = $produksiVals[$i] ?? null;

                if (!$jenisId || $produksi === '' || $produksi === null) {
                    continue; // sel matrix ini tidak diisi, lewati
                }

                DataBulananBudidaya::updateOrCreate(
                    [
                        'kabupaten_ikan_id' => $kabupatenId,
                        'komoditas_budidaya_id' => $komId,
                        'jenis_budidaya_id' => $jenisId,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ],
                    [
                        'hasil_produksi' => $produksi,
                        'keterangan' => $keterangan,
                    ]
                );
                $tersimpan++;
            }
        });

        if ($tersimpan === 0) {
            return back()->with('error', 'Isi minimal satu sel produksi (komoditas × jenis budidaya).');
        }

        return back()->with('success', "Tersimpan {$tersimpan} data produksi.");
    }

    public function updateProduksi(Request $request, $id)
    {
        $data = DataBulananBudidaya::findOrFail($id);
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'hasil_produksi' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);
        $data->update($validated);

        return back()->with('success', 'Data produksi diperbarui.');
    }

    public function destroyProduksi($id)
    {
        DataBulananBudidaya::findOrFail($id)->delete();
        return back()->with('success', 'Data produksi dihapus.');
    }

    // Simpan data tahunan (RTP, pembudidaya, luas lahan) — per jenis budidaya, per tahun
    public function storeSarana(Request $request, $kabupatenId)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',

            'jenis_id'   => 'array',
            'jenis_id.*' => 'exists:jenis_budidayas,id',
            'rtp'        => 'array',
            'rtp.*'      => 'nullable|integer|min:0',
            'pembudidaya'   => 'array',
            'pembudidaya.*' => 'nullable|integer|min:0',
            'luas_lahan'    => 'array',
            'luas_lahan.*'  => 'nullable|integer|min:0',
        ]);

        $tahun = $validated['tahun'];
        $tersimpan = 0;

        DB::transaction(function () use ($request, $kabupatenId, $tahun, &$tersimpan) {
            $jenisIds = $request->input('jenis_id', []);
            $rtpVals = $request->input('rtp', []);
            $pembudidayaVals = $request->input('pembudidaya', []);
            $luasLahanVals = $request->input('luas_lahan', []);

            foreach ($jenisIds as $i => $jenisId) {
                if (!isset($rtpVals[$i]) || $rtpVals[$i] === '' || $rtpVals[$i] === null) {
                    continue;
                }
                DataTahunanSarana::updateOrCreate(
                    [
                        'kabupaten_ikan_id' => $kabupatenId,
                        'jenis_budidaya_id' => $jenisId,
                        'tahun' => $tahun,
                    ],
                    [
                        'jumlah_rtp' => $rtpVals[$i],
                        'jumlah_pembudidaya' => $pembudidayaVals[$i] ?? null,
                        'luas_lahan' => $luasLahanVals[$i] ?? null,
                    ]
                );
                $tersimpan++;
            }
        });

        if ($tersimpan === 0) {
            return back()->with('error', 'Isi minimal satu jenis budidaya untuk data tahunan ini.');
        }

        return back()->with('success', "Tersimpan {$tersimpan} data sarana tahunan.");
    }

    public function updateSarana(Request $request, $id)
    {
        $data = DataTahunanSarana::findOrFail($id);
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah_rtp' => 'required|integer|min:0',
            'jumlah_pembudidaya' => 'nullable|integer|min:0',
            'luas_lahan' => 'nullable|integer|min:0',
        ]);
        $data->update($validated);

        return back()->with('success', 'Data sarana diperbarui.');
    }

    public function destroySarana($id)
    {
        DataTahunanSarana::findOrFail($id)->delete();
        return back()->with('success', 'Data sarana dihapus.');
    }
}