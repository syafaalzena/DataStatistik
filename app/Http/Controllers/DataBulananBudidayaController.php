<?php

namespace App\Http\Controllers;

use App\Models\KabupatenIkan;
use App\Models\KomoditasBudidaya;
use App\Models\JenisBudidaya;
use App\Models\DataBulananBudidaya;
use App\Models\DataTahunanSarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataBulananBudidayaController extends Controller
{
    // halaman "Pilih Kabupaten"
    public function index()
    {
        $kabupatens = KabupatenIkan::withCount('dataBulananBudidaya')
            ->orderBy('id')
            ->get();

        return view('budidaya.index', compact('kabupatens'));
    }

    // halaman form input untuk satu kabupaten (produksi + sarana ditampilkan bareng)
    public function input($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

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

    public function store(Request $request, $kabupatenId)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'keterangan' => 'nullable|string|max:255',

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
                    continue;
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

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        DataBulananBudidaya::findOrFail($id)->delete();
        return back()->with('success', 'Data produksi dihapus.');
    }
    
}