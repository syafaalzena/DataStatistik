<?php

namespace App\Http\Controllers;

use App\Models\ProduksiTangkap;
use App\Models\KabupatenIkan;
use App\Models\Pelabuhan;
use App\Models\Wppnri;
use App\Models\JenisApi;
use App\Models\KategoriUkuranKapal;
use App\Models\KomoditasIkan;
use App\Models\LaporanOperasional;
use Illuminate\Http\Request;

class ProduksiTangkapController extends Controller
{
    
    public function index()
    {
        $kabupatenIkans = KabupatenIkan::orderBy('nama_kabupaten')->get();

        return view('tangkap.produksi.index', compact('kabupatenIkans'));
    }

    public function input($kabupatenId)
{
    $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

    $dataProduksi = ProduksiTangkap::with([
        'pelabuhan', 'wppnri', 'jenisApi', 'kategoriUkuranKapal', 'komoditasIkan',
    ])
        ->where('kabupaten_ikan_id', $kabupatenId)
        ->latest()
        ->get();

    return view('tangkap.input', compact('kabupaten', 'dataProduksi'));
}

public function create($kabupatenId)
{
    $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
    $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupatenId)->orderBy('nama')->get();
    $wppnriList = Wppnri::orderBy('kode')->get();
    $jenisApiList = JenisApi::orderBy('nama')->get();
    $kategoriKapalList = KategoriUkuranKapal::orderBy('label')->get();
    $komoditasList = KomoditasIkan::orderBy('nama_ikan')->get();

    return view('tangkap.produksi-create', compact(
        'kabupaten', 'pelabuhanList', 'wppnriList', 'jenisApiList', 'kategoriKapalList', 'komoditasList'
    ));
}

    public function store(Request $request, $kabupatenId)
    {
        $request->validate([
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'digits:4'],
            'pelabuhan_id' => ['required', 'array', 'min:1'],
            'pelabuhan_id.*' => ['required', 'exists:pelabuhans,id'],
            'wppnri_id.*' => ['required', 'exists:wppnris,id'],
            'jenis_lk.*' => ['required', 'in:Pelabuhan,Non Pelabuhan'],
            'jenis_api_id.*' => ['required', 'exists:jenis_apis,id'],
            'kategori_ukuran_kapal_id.*' => ['required', 'exists:kategori_ukuran_kapals,id'],
            'komoditas_ikan_id.*' => ['required', 'exists:komoditas_ikans,id'],
            'volume_produksi_kg.*' => ['required', 'numeric', 'min:0'],
            'harga_rp.*' => ['required', 'numeric', 'min:0'],
        ]);

        foreach ($request->pelabuhan_id as $i => $pelabuhanId) {
            $volume = $request->volume_produksi_kg[$i];
            $harga = $request->harga_rp[$i];

            ProduksiTangkap::create([
                'kabupaten_ikan_id' => $kabupatenId,
                'pelabuhan_id' => $pelabuhanId,
                'wppnri_id' => $request->wppnri_id[$i],
                'jenis_lk' => $request->jenis_lk[$i],
                'jenis_api_id' => $request->jenis_api_id[$i],
                'kategori_ukuran_kapal_id' => $request->kategori_ukuran_kapal_id[$i],
                'komoditas_ikan_id' => $request->komoditas_ikan_id[$i],
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'volume_produksi_kg' => $volume,
                'harga_rp' => $harga,
                'nilai_rp' => $volume * $harga,
            ]);
        }

        return redirect()->route('tangkap.input', $kabupatenId)->with('success', 'Data produksi berhasil disimpan.');
    }

    public function update(Request $request, ProduksiTangkap $produksi)
    {
        $validated = $request->validate([
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'digits:4'],
            'volume_produksi_kg' => ['required', 'numeric', 'min:0'],
            'harga_rp' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['nilai_rp'] = $validated['volume_produksi_kg'] * $validated['harga_rp'];
        $produksi->update($validated);

        return redirect()->back()->with('success', 'Data produksi berhasil diperbarui.');
    }

    public function destroy(ProduksiTangkap $produksi)
    {
        $produksi->delete();

        return redirect()->back()->with('success', 'Data produksi berhasil dihapus.');
    }

    public function rekap($kabupatenId, Request $request)
{
    $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
    $dataProduksi = $this->filteredProduksi($kabupatenId, $request);

    return view('tangkap.produksi-rekap', compact('kabupaten', 'dataProduksi'));
}

public function export($kabupatenId, Request $request)
{
    $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\ProduksiTangkapExport($kabupatenId, $kabupaten->nama_kabupaten, $request->query()),
        'produksi-tangkap-' . \Illuminate\Support\Str::slug($kabupaten->nama_kabupaten) . '.xlsx'
    );
}

public function exportPdf($kabupatenId, Request $request)
{
    $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
    $dataProduksi = $this->filteredProduksi($kabupatenId, $request);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.rekap_produksi_tangkap', compact('kabupaten', 'dataProduksi'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('produksi-tangkap-' . \Illuminate\Support\Str::slug($kabupaten->nama_kabupaten) . '.pdf');
}

private function filteredProduksi($kabupatenId, Request $request)
{
    $query = ProduksiTangkap::with([
        'pelabuhan', 'wppnri', 'jenisApi', 'kategoriUkuranKapal', 'komoditasIkan',
    ])->where('kabupaten_ikan_id', $kabupatenId);

    if ($request->filled('tahun')) {
        $query->where('tahun', $request->tahun);
    }

    if ($request->filled('bulan')) {
        $query->where('bulan', $request->bulan);
    } elseif ($request->filled('semester')) {
        $bulanRange = $request->semester == 1 ? [1, 6] : [7, 12];
        $query->whereBetween('bulan', $bulanRange);
    }

    return $query->orderBy('tahun')->orderBy('bulan')->get();
}
}