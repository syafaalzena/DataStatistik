<?php

namespace App\Http\Controllers;

use App\Models\DataTahunan;
use App\Models\DataBulanan;
use Illuminate\Http\Request;

class DataTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kabupaten = \App\Models\Kabupaten::all();
    return view('Garam.index', compact('kabupaten'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('garam.tahunan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'statistik_id' => 'required|integer',
            'jumlah_petani' => 'required|integer',
            'luas_lahan_rebus' => 'required|numeric',
            'luas_lahan_jemur' => 'required|numeric',
            'jumlah_lahan_unit' => 'required|integer',
            'tahun' => 'required|integer',
            'lokasi' => 'nullable|string|max:255',
        ]);

        DataTahunan::create($request->all());

        return redirect()->route('data-tahunan.index')
            ->with('success', 'Data tahunan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataTahunan $dataTahunan)
    {
        return view('garam.tahunan.show', compact('dataTahunan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataTahunan $dataTahunan)
    {
        return view('garam.tahunan.edit', compact('dataTahunan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataTahunan $dataTahunan)
    {
        $request->validate([
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'statistik_id' => 'required|integer',
            'jumlah_petani' => 'required|integer',
            'luas_lahan_rebus' => 'required|numeric',
            'luas_lahan_jemur' => 'required|numeric',
            'jumlah_lahan_unit' => 'required|integer',
            'tahun' => 'required|integer',
            'lokasi' => 'nullable|string|max:255',
        ]);

        $dataTahunan->update($request->all());

        return redirect()->route('data-tahunan.index')
            ->with('success', 'Data tahunan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataTahunan $dataTahunan)
    {
        $dataTahunan->delete();

        return redirect()->route('data-tahunan.index')
            ->with('success', 'Data tahunan deleted successfully.');
    }

<?php

namespace App\Http\Controllers;

use App\Models\DataTahunan;
use App\Models\DataBulanan;
use Illuminate\Http\Request;

class DataTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kabupaten = \App\Models\Kabupaten::all();
    return view('Garam.index', compact('kabupaten'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('garam.tahunan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'statistik_id' => 'required|integer',
            'jumlah_petani' => 'required|integer',
            'luas_lahan_rebus' => 'required|numeric',
            'luas_lahan_jemur' => 'required|numeric',
            'jumlah_lahan_unit' => 'required|integer',
            'tahun' => 'required|integer',
            'lokasi' => 'nullable|string|max:255',
        ]);

        DataTahunan::create($request->all());

        return redirect()->route('data-tahunan.index')
            ->with('success', 'Data tahunan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataTahunan $dataTahunan)
    {
        return view('garam.tahunan.show', compact('dataTahunan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataTahunan $dataTahunan)
    {
        return view('garam.tahunan.edit', compact('dataTahunan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataTahunan $dataTahunan)
    {
        $request->validate([
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'statistik_id' => 'required|integer',
            'jumlah_petani' => 'required|integer',
            'luas_lahan_rebus' => 'required|numeric',
            'luas_lahan_jemur' => 'required|numeric',
            'jumlah_lahan_unit' => 'required|integer',
            'tahun' => 'required|integer',
            'lokasi' => 'nullable|string|max:255',
        ]);

        $dataTahunan->update($request->all());

        return redirect()->route('data-tahunan.index')
            ->with('success', 'Data tahunan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataTahunan $dataTahunan)
    {
        $dataTahunan->delete();

        return redirect()->route('data-tahunan.index')
            ->with('success', 'Data tahunan deleted successfully.');
    }

    public function rekapTahunan(Request $request)
{
    $tahunList = DataTahunan::select('tahun')
                    ->distinct()
                    ->orderBy('tahun', 'desc')
                    ->pluck('tahun');

    $kabupatenList = \App\Models\Kabupaten::all();

    $tahunDipilih     = $request->tahun ?? $tahunList->first();
    $kabupatenDipilih = $request->kabupaten_id ?? null;

    // Query dasar
    $query = DataTahunan::with('kabupaten')
                ->where('tahun', $tahunDipilih);

    // Filter kabupaten kalau dipilih
    if ($kabupatenDipilih) {
        $query->where('kabupaten_id', $kabupatenDipilih);
    }

    $data = $query->orderBy('kabupaten_id')->get();

    // Data grafik — jumlah petani per kabupaten di tahun dipilih
    $grafikQuery = DataTahunan::with('kabupaten')
                    ->where('tahun', $tahunDipilih);
    if ($kabupatenDipilih) {
        $grafikQuery->where('kabupaten_id', $kabupatenDipilih);
    }
    $dataGrafik = $grafikQuery->get();

    return view('garam.rekap_tahunan', compact(
        'data', 'tahunList', 'kabupatenList',
        'tahunDipilih', 'kabupatenDipilih', 'dataGrafik'
    ));
}

}
