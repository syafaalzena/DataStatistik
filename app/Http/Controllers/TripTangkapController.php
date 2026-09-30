<?php

namespace App\Http\Controllers;

use App\Models\TripTangkap;
use App\Models\KabupatenIkan;
use App\Models\Pelabuhan;
use App\Models\Wppnri;
use App\Models\JenisApi;
use App\Models\KategoriUkuranKapal;
use Illuminate\Http\Request;

class TripTangkapController extends Controller
{
    public function input($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

        $dataTrip = TripTangkap::with(['pelabuhan', 'wppnri', 'jenisApi', 'kategoriUkuranKapal'])
            ->where('kabupaten_ikan_id', $kabupatenId)
            ->orderByDesc('tanggal')
            ->get();

        return view('tangkap.trip', compact('kabupaten', 'dataTrip'));
    }

    public function create($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
        $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupatenId)->orderBy('nama')->get();
        $wppnriList = Wppnri::orderBy('kode')->get();
        $jenisApiList = JenisApi::orderBy('nama')->get();
        $kategoriKapalList = KategoriUkuranKapal::orderBy('label')->get();

        return view('tangkap.trip-create', compact('kabupaten', 'pelabuhanList', 'wppnriList', 'jenisApiList', 'kategoriKapalList'));
    }

    public function store(Request $request, $kabupatenId)
    {
        $request->validate([
            'pelabuhan_id' => ['required', 'array', 'min:1'],
            'pelabuhan_id.*' => ['required', 'exists:pelabuhans,id'],
            'wppnri_id.*' => ['required', 'exists:wppnris,id'],
            'jenis_lk.*' => ['required', 'in:Pelabuhan,Non Pelabuhan'],
            'jenis_api_id.*' => ['required', 'exists:jenis_apis,id'],
            'kategori_ukuran_kapal_id.*' => ['required', 'exists:kategori_ukuran_kapals,id'],
            'tanggal.*' => ['required', 'date'],
            'jumlah_trip.*' => ['required', 'integer', 'min:1'],
        ]);

        foreach ($request->pelabuhan_id as $i => $pelabuhanId) {
            TripTangkap::create([
                'kabupaten_ikan_id' => $kabupatenId,
                'pelabuhan_id' => $pelabuhanId,
                'wppnri_id' => $request->wppnri_id[$i],
                'jenis_lk' => $request->jenis_lk[$i],
                'jenis_api_id' => $request->jenis_api_id[$i],
                'kategori_ukuran_kapal_id' => $request->kategori_ukuran_kapal_id[$i],
                'tanggal' => $request->tanggal[$i],
                'jumlah_trip' => $request->jumlah_trip[$i],
            ]);
        }

        return redirect()->route('tangkap.trip.input', $kabupatenId)->with('success', 'Data trip berhasil disimpan.');
    }

    public function update(Request $request, TripTangkap $trip)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'jumlah_trip' => ['required', 'integer', 'min:1'],
        ]);

        $trip->update($validated);

        return redirect()->back()->with('success', 'Data trip berhasil diperbarui.');
    }

    public function destroy(TripTangkap $trip)
    {
        $trip->delete();

        return redirect()->back()->with('success', 'Data trip berhasil dihapus.');
    }

  public function rekap($kabupatenId, Request $request)
{
    $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

    $query = \Illuminate\Support\Facades\DB::table('trip_tangkaps')
        ->join('pelabuhans', 'pelabuhans.id', '=', 'trip_tangkaps.pelabuhan_id')
        ->join('wppnris', 'wppnris.id', '=', 'trip_tangkaps.wppnri_id')
        ->join('jenis_apis', 'jenis_apis.id', '=', 'trip_tangkaps.jenis_api_id')
        ->join('kategori_ukuran_kapals', 'kategori_ukuran_kapals.id', '=', 'trip_tangkaps.kategori_ukuran_kapal_id')
        ->where('trip_tangkaps.kabupaten_ikan_id', $kabupatenId);

    if ($request->filled('tahun')) {
        $query->whereYear('trip_tangkaps.tanggal', $request->tahun);
    }

    $rekapBulanan = $query->selectRaw('
            YEAR(trip_tangkaps.tanggal) as tahun,
            MONTH(trip_tangkaps.tanggal) as bulan,
            pelabuhans.nama as nama_pelabuhan,
            wppnris.kode as kode_wppnri,
            trip_tangkaps.jenis_lk as jenis_lk,
            jenis_apis.nama as nama_jenis_api,
            kategori_ukuran_kapals.label as label_kategori,
            SUM(trip_tangkaps.jumlah_trip) as total_trip,
            COUNT(*) as jumlah_entri
        ')
        ->groupBy(
            'tahun', 'bulan', 'pelabuhans.nama', 'wppnris.kode',
            'trip_tangkaps.jenis_lk', 'jenis_apis.nama', 'kategori_ukuran_kapals.label'
        )
        ->orderBy('tahun')->orderBy('bulan')->orderBy('pelabuhans.nama')
        ->get();

    return view('tangkap.trip-rekap', compact('kabupaten', 'rekapBulanan'));
}
}