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
    public function menu()
{
    $totalProduksiKabupaten = KabupatenIkan::where('aktif_tangkap', true)->count();
    $totalLaporanOperasional = LaporanOperasional::count();

    return view('tangkap.menu', compact('totalProduksiKabupaten', 'totalLaporanOperasional'));
}


    public function index()
    {
        $kabupatenIkans = KabupatenIkan::where('aktif_tangkap', true)->orderBy('nama_kabupaten')->get();
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
            'jenis_ikan.*' => ['required', 'string', 'max:150'],
            'nama_latin.*' => ['nullable', 'string', 'max:150'],
        ]);

        foreach ($request->pelabuhan_id as $i => $pelabuhanId) {
    $namaIkan = trim($request->jenis_ikan[$i]);
    $namaLatin = trim($request->nama_latin[$i] ?? '');

    $komoditas = \App\Models\KomoditasIkan::firstOrCreate(
        ['nama_ikan' => $namaIkan],
        ['nama_latin' => $namaLatin ?: null]
    );

    // kalau ikan sudah ada tapi belum ada nama latinnya, isi sekarang
    if ($namaLatin && !$komoditas->nama_latin) {
        $komoditas->update(['nama_latin' => $namaLatin]);
    }

    $volume = $request->volume_produksi_kg[$i];
    $harga = $request->harga_rp[$i];

    ProduksiTangkap::create([
        'kabupaten_ikan_id' => $kabupatenId,
        'pelabuhan_id' => $pelabuhanId,
        'wppnri_id' => $request->wppnri_id[$i],
        'jenis_lk' => $request->jenis_lk[$i],
        'jenis_api_id' => $request->jenis_api_id[$i],
        'kategori_ukuran_kapal_id' => $request->kategori_ukuran_kapal_id[$i],
        'komoditas_ikan_id' => $komoditas->id,
        'nama_latin_input' => $namaLatin ?: null,
        'bulan' => $request->bulan,
        'tahun' => $request->tahun,
        'volume_produksi_kg' => $volume,
        'harga_rp' => $harga,
        'nilai_rp' => $volume * $harga,
    ]);

    }
        return redirect()->route('tangkap.input', $kabupatenId)->with('success', 'Data produksi berhasil disimpan.');
    }

    public function edit(ProduksiTangkap $produksi)
{
    $produksi->load('komoditasIkan');
    $kabupaten = $produksi->kabupatenIkan;
    $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupaten->id)->orderBy('nama')->get();
    $wppnriList = Wppnri::orderBy('kode')->get();
    $jenisApiList = JenisApi::orderBy('nama')->get();
    $kategoriKapalList = KategoriUkuranKapal::orderBy('label')->get();

    return view('tangkap.produksi-edit', compact('produksi', 'kabupaten', 'pelabuhanList', 'wppnriList', 'jenisApiList', 'kategoriKapalList'));
}

   public function update(Request $request, ProduksiTangkap $produksi)
{
    $request->validate([
        'bulan' => ['required', 'integer', 'between:1,12'],
        'tahun' => ['required', 'integer', 'digits:4'],
        'pelabuhan_id' => ['required', 'exists:pelabuhans,id'],
        'wppnri_id' => ['required', 'exists:wppnris,id'],
        'jenis_lk' => ['required', 'in:Pelabuhan,Non Pelabuhan'],
        'jenis_api_id' => ['required', 'exists:jenis_apis,id'],
        'kategori_ukuran_kapal_id' => ['required', 'exists:kategori_ukuran_kapals,id'],
        'jenis_ikan' => ['required', 'string', 'max:150'],
        'nama_latin' => ['nullable', 'string', 'max:150'],
        'volume_produksi_kg' => ['required', 'numeric', 'min:0'],
        'harga_rp' => ['required', 'numeric', 'min:0'],
    ]);

    $namaIkan = trim($request->jenis_ikan);
    $namaLatin = trim($request->nama_latin ?? '');

    $komoditas = \App\Models\KomoditasIkan::firstOrCreate(
        ['nama_ikan' => $namaIkan],
        ['nama_latin' => $namaLatin ?: null]
    );
    if ($namaLatin && !$komoditas->nama_latin) {
        $komoditas->update(['nama_latin' => $namaLatin]);
    }

    $volume = $request->volume_produksi_kg;
    $harga = $request->harga_rp;

    $produksi->update([
        'pelabuhan_id' => $request->pelabuhan_id,
        'wppnri_id' => $request->wppnri_id,
        'jenis_lk' => $request->jenis_lk,
        'jenis_api_id' => $request->jenis_api_id,
        'kategori_ukuran_kapal_id' => $request->kategori_ukuran_kapal_id,
        'komoditas_ikan_id' => $komoditas->id,
        'nama_latin_input' => $namaLatin ?: null,
        'bulan' => $request->bulan,
        'tahun' => $request->tahun,
        'volume_produksi_kg' => $volume,
        'harga_rp' => $harga,
        'nilai_rp' => $volume * $harga,
    ]);

    return redirect()->route('tangkap.input', $produksi->kabupaten_ikan_id)->with('success', 'Data produksi berhasil diperbarui.');
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