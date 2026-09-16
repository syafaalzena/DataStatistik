<?php

namespace App\Http\Controllers;

use App\Models\ProduksiTangkap;
use App\Models\Pelabuhan;
use App\Models\Wppnri;
use App\Models\JenisApi;
use App\Models\KategoriUkuranKapal;
use App\Models\KomoditasIkan;
use Illuminate\Http\Request;

class ProduksiTangkapController extends Controller
{
    public function index()
    {
        $pelabuhanList = Pelabuhan::with('kabupatenIkan')->orderBy('nama')->get();
        $wppnriList = Wppnri::orderBy('kode')->get();
        $jenisApiList = JenisApi::orderBy('nama')->get();
        $kategoriKapalList = KategoriUkuranKapal::orderBy('label')->get();
        $komoditasList = KomoditasIkan::orderBy('nama_ikan')->get();

        $dataProduksi = ProduksiTangkap::with([
            'pelabuhan.kabupatenIkan', 'wppnri', 'jenisApi', 'kategoriUkuranKapal', 'komoditasIkan',
        ])->latest()->get();

        return view('tangkap.produksi.index', compact(
            'pelabuhanList', 'wppnriList', 'jenisApiList', 'kategoriKapalList', 'komoditasList', 'dataProduksi'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'digits:4'],
            'pelabuhan_id' => ['required', 'array', 'min:1'],
            'pelabuhan_id.*' => ['required', 'exists:pelabuhans,id'],
            'wppnri_id.*' => ['required', 'exists:wppnris,id'],
            'jenis_api_id.*' => ['required', 'exists:jenis_apis,id'],
            'kategori_ukuran_kapal_id.*' => ['required', 'exists:kategori_ukuran_kapals,id'],
            'komoditas_ikan_id.*' => ['required', 'exists:komoditas_ikans,id'],
            'volume_produksi_kg.*' => ['required', 'numeric', 'min:0'],
            'harga_rp.*' => ['required', 'numeric', 'min:0'],
        ]);

        foreach ($request->pelabuhan_id as $i => $pelabuhanId) {
            $pelabuhan = Pelabuhan::findOrFail($pelabuhanId);
            $volume = $request->volume_produksi_kg[$i];
            $harga = $request->harga_rp[$i];

            ProduksiTangkap::create([
                'kabupaten_ikan_id' => $pelabuhan->kabupaten_ikan_id,
                'pelabuhan_id' => $pelabuhanId,
                'wppnri_id' => $request->wppnri_id[$i],
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

        return redirect()->route('tangkap.index')->with('success', 'Data produksi berhasil disimpan.');
    }

    public function update(Request $request, ProduksiTangkap $produksi)
    {
        $validated = $request->validate([
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'digits:4'],
            'volume_produksi_kg' => ['required', 'numeric', 'min:0'],
            'harga_rp' => ['required', 'numeric', 'min:0'],
            'jenis_lk.*' => ['required', 'in:Pelabuhan,Non Pelabuhan'],
        ]);

        $validated['nilai_rp'] = $validated['volume_produksi_kg'] * $validated['harga_rp'];
        $produksi->update($validated);

        return redirect()->route('tangkap.index')->with('success', 'Data produksi berhasil diperbarui.');
    }

    public function destroy(ProduksiTangkap $produksi)
    {
        $produksi->delete();

        return redirect()->route('tangkap.index')->with('success', 'Data produksi berhasil dihapus.');
    }
}