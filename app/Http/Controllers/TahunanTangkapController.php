<?php

namespace App\Http\Controllers;

use App\Models\TahunanTangkap;
use App\Models\KabupatenIkan;
use App\Models\Pelabuhan;
use App\Models\Wppnri;
use App\Models\JenisApi;
use App\Models\KategoriUkuranKapal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahunanTangkapController extends Controller
{
    public function input($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

        $dataTahunan = TahunanTangkap::with(['pelabuhan', 'wppnri', 'jenisApi', 'kategoriUkuranKapal'])
            ->where('kabupaten_ikan_id', $kabupatenId)
            ->orderByDesc('tahun')
            ->get();

        return view('tangkap.tahunan', compact('kabupaten', 'dataTahunan'));
    }

    public function create($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
        $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupatenId)->orderBy('nama')->get();
        $wppnriList = Wppnri::orderBy('kode')->get();
        $jenisApiList = JenisApi::orderBy('nama')->get();
        $kategoriKapalList = KategoriUkuranKapal::orderBy('label')->get();

        return view('tangkap.tahunan-create', compact(
            'kabupaten', 'pelabuhanList', 'wppnriList', 'jenisApiList', 'kategoriKapalList'
        ));
    }

    public function store(Request $request, $kabupatenId)
    {
        $request->validate([
            'tahun' => ['required', 'integer', 'digits:4'],
            'pelabuhan_id' => ['required', 'array', 'min:1'],
            'pelabuhan_id.*' => ['required', 'exists:pelabuhans,id'],
            'wppnri_id.*' => ['required', 'exists:wppnris,id'],
            'jenis_lk.*' => ['required', 'in:Pelabuhan,Non Pelabuhan'],
            'jenis_api_id.*' => ['required', 'exists:jenis_apis,id'],
            'kategori_ukuran_kapal_id.*' => ['required', 'exists:kategori_ukuran_kapals,id'],
            'jumlah_rtp.*' => ['required', 'integer', 'min:0'],
            'jumlah_kapal.*' => ['required', 'integer', 'min:0'],
            'jumlah_api.*' => ['required', 'integer', 'min:0'],
            'jumlah_nelayan_buruh.*' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->pelabuhan_id as $i => $pelabuhanId) {
            $rtp = (int) $request->jumlah_rtp[$i];
            $buruh = (int) $request->jumlah_nelayan_buruh[$i];

            TahunanTangkap::create([
                'kabupaten_ikan_id' => $kabupatenId,
                'pelabuhan_id' => $pelabuhanId,
                'wppnri_id' => $request->wppnri_id[$i],
                'jenis_lk' => $request->jenis_lk[$i],
                'jenis_api_id' => $request->jenis_api_id[$i],
                'kategori_ukuran_kapal_id' => $request->kategori_ukuran_kapal_id[$i],
                'tahun' => $request->tahun,
                'jumlah_rtp' => $rtp,
                'jumlah_kapal' => $request->jumlah_kapal[$i],
                'jumlah_api' => $request->jumlah_api[$i],
                'jumlah_nelayan_buruh' => $buruh,
                'jumlah_nelayan' => $rtp + $buruh,
            ]);
        }

        return redirect()->route('tangkap.tahunan.input', $kabupatenId)->with('success', 'Data tahunan berhasil disimpan.');
    }

    public function edit(TahunanTangkap $tahunan)
    {
        $kabupaten = $tahunan->kabupatenIkan;
        $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupaten->id)->orderBy('nama')->get();
        $wppnriList = Wppnri::orderBy('kode')->get();
        $jenisApiList = JenisApi::orderBy('nama')->get();
        $kategoriKapalList = KategoriUkuranKapal::orderBy('label')->get();

        return view('tangkap.tahunan-edit', compact(
            'tahunan', 'kabupaten', 'pelabuhanList', 'wppnriList', 'jenisApiList', 'kategoriKapalList'
        ));
    }

    public function update(Request $request, TahunanTangkap $tahunan)
    {
        $validated = $request->validate([
            'pelabuhan_id' => ['required', 'exists:pelabuhans,id'],
            'wppnri_id' => ['required', 'exists:wppnris,id'],
            'jenis_lk' => ['required', 'in:Pelabuhan,Non Pelabuhan'],
            'jenis_api_id' => ['required', 'exists:jenis_apis,id'],
            'kategori_ukuran_kapal_id' => ['required', 'exists:kategori_ukuran_kapals,id'],
            'tahun' => ['required', 'integer', 'digits:4'],
            'jumlah_rtp' => ['required', 'integer', 'min:0'],
            'jumlah_kapal' => ['required', 'integer', 'min:0'],
            'jumlah_api' => ['required', 'integer', 'min:0'],
            'jumlah_nelayan_buruh' => ['required', 'integer', 'min:0'],
        ]);

        $validated['jumlah_nelayan'] = $validated['jumlah_rtp'] + $validated['jumlah_nelayan_buruh'];

        $tahunan->update($validated);

        return redirect()->route('tangkap.tahunan.input', $tahunan->kabupaten_ikan_id)->with('success', 'Data tahunan berhasil diperbarui.');
    }

    public function destroy(TahunanTangkap $tahunan)
    {
        $tahunan->delete();

        return redirect()->back()->with('success', 'Data tahunan berhasil dihapus.');
    }

    public function rekap($kabupatenId, Request $request)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
        $rekapTahunan = $this->rekapQuery($kabupatenId, $request)->get();

        return view('tangkap.tahunan-rekap', compact('kabupaten', 'rekapTahunan'));
    }

    public function export($kabupatenId, Request $request)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\TahunanTangkapExport($kabupatenId, $kabupaten->nama_kabupaten, $request->query()),
            'tahunan-tangkap-' . \Illuminate\Support\Str::slug($kabupaten->nama_kabupaten) . '.xlsx'
        );
    }

    public function exportPdf($kabupatenId, Request $request)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
        $rekapTahunan = $this->rekapQuery($kabupatenId, $request)->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.rekap_tahunan_tangkap', compact('kabupaten', 'rekapTahunan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('tahunan-tangkap-' . \Illuminate\Support\Str::slug($kabupaten->nama_kabupaten) . '.pdf');
    }

    private function rekapQuery($kabupatenId, Request $request)
    {
        $query = DB::table('tahunan_tangkaps')
            ->join('pelabuhans', 'pelabuhans.id', '=', 'tahunan_tangkaps.pelabuhan_id')
            ->join('wppnris', 'wppnris.id', '=', 'tahunan_tangkaps.wppnri_id')
            ->join('jenis_apis', 'jenis_apis.id', '=', 'tahunan_tangkaps.jenis_api_id')
            ->join('kategori_ukuran_kapals', 'kategori_ukuran_kapals.id', '=', 'tahunan_tangkaps.kategori_ukuran_kapal_id')
            ->where('tahunan_tangkaps.kabupaten_ikan_id', $kabupatenId);

        if ($request->filled('tahun')) {
            $query->where('tahunan_tangkaps.tahun', $request->tahun);
        }

        return $query->selectRaw('
                tahunan_tangkaps.tahun as tahun,
                pelabuhans.nama as nama_pelabuhan,
                wppnris.kode as kode_wppnri,
                tahunan_tangkaps.jenis_lk as jenis_lk,
                jenis_apis.nama as nama_jenis_api,
                kategori_ukuran_kapals.label as label_kategori,
                COUNT(*) as jumlah_entri,
                SUM(tahunan_tangkaps.jumlah_rtp) as total_rtp,
                SUM(tahunan_tangkaps.jumlah_kapal) as total_kapal,
                SUM(tahunan_tangkaps.jumlah_api) as total_api,
                SUM(tahunan_tangkaps.jumlah_nelayan_buruh) as total_nelayan_buruh,
                SUM(tahunan_tangkaps.jumlah_nelayan) as total_nelayan
            ')
            ->groupBy(
                'tahunan_tangkaps.tahun', 'pelabuhans.nama', 'wppnris.kode',
                'tahunan_tangkaps.jenis_lk', 'jenis_apis.nama', 'kategori_ukuran_kapals.label'
            )
            ->orderBy('tahunan_tangkaps.tahun')->orderBy('pelabuhans.nama');
    }
}
