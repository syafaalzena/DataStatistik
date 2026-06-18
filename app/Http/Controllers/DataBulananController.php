<?php

namespace App\Http\Controllers;

use App\Models\DataBulanan;
use Illuminate\Http\Request;
use App\Models\Kabupaten;

class DataBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DataBulanan::with('kabupaten')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('garam.bulanan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($kabupaten_id)
{
    $kabupaten = Kabupaten::findOrFail($kabupaten_id);

    return view('kabupaten.data-bulanan.create', compact('kabupaten'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'jenis_produksi' => 'required|string|max:255',
            'produksi' => 'required|numeric',
            'lokasi' => 'required|string|max:255',
            'jumlah_petani' => 'required|integer|min:0',
            'nama_kelompok' => 'required|string|max:255',
            'harga' => 'required|numeric',
        ]);

        DataBulanan::create($request->all());

    return redirect()->route('kabupaten.show', $request->kabupaten_id)
    ->with('success', 'Data bulanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataBulanan $dataBulanan)
    {
        return view('garam.bulanan.show', compact('dataBulanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataBulanan $dataBulanan)
{
    return view('kabupaten.data-bulanan.edit', compact('dataBulanan'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataBulanan $dataBulanan)
    {
        $request->validate([
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'jenis_produksi' => 'required|string|max:255',
            'produksi' => 'required|numeric',
            'lokasi' => 'required|string|max:255',
            'jumlah_petani' => 'required|integer|min:0',
            'nama_kelompok' => 'required|string|max:255',
            'harga' => 'required|numeric',
        ]);

        $dataBulanan->update($request->all());

        return redirect()->route('kabupaten.show', $request->kabupaten_id)
            ->with('success', 'Data bulanan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataBulanan $dataBulanan)
{
    $dataBulanan->delete();

    return redirect()->route('kabupaten.show', $dataBulanan->kabupaten_id)
        ->with('success', 'Data bulanan berhasil dihapus.');
}



    public function rekapBulanan(Request $request)
{
    $tahunList = DataBulanan::select('tahun')
                    ->distinct()
                    ->orderBy('tahun', 'desc')
                    ->pluck('tahun');

    $bulanList = [
        1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
        5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
        9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
    ];

    $tahunDipilih = $request->tahun ?? $tahunList->first();
    $bulanDipilih = $request->bulan ?? now()->month;

    // Data grafik — total produksi per bulan dalam tahun dipilih
    $dataGrafik = DataBulanan::where('tahun', $tahunDipilih)
                ->selectRaw('bulan, SUM(produksi) as total_produksi')
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

    // Data tabel — semua kabupaten di bulan & tahun dipilih
    $data = DataBulanan::with('kabupaten')
                ->where('tahun', $tahunDipilih)
                ->where('bulan', $bulanDipilih)
                ->orderBy('kabupaten_id')
                ->get();

    return view('garam.rekap_bulanan', compact(
        'data', 'tahunList', 'bulanList',
        'tahunDipilih', 'bulanDipilih', 'dataGrafik'
    ));
}
}
