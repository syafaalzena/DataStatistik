<?php

namespace App\Http\Controllers;

use App\Models\KabupatenIkan;
use Illuminate\Http\Request;
use App\Models\KomoditasBudidaya;
use App\Models\JenisBudidaya;
use App\Models\DataBulananBudidaya;
use App\Models\DataTahunanSarana;

class KabupatenIkanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $kabupatenIkans = KabupatenIkan::orderBy('nama_kabupaten')->get();

    return view('budidaya.index', compact('kabupatenIkans'));

    }

    public function input($kabupatenId)
{
    $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

    $komoditasList = KomoditasBudidaya::where('kabupaten_ikan_id', $kabupatenId)
        ->orderBy('nama_komoditas')
        ->get();

    $jenisList = JenisBudidaya::where('kabupaten_ikan_id', $kabupatenId)
        ->orderBy('nama_jenis')
        ->get();

    $dataProduksi = DataBulananBudidaya::with(['komoditas', 'jenis'])
        ->where('kabupaten_ikan_id', $kabupatenId)
        ->orderByDesc('tahun')
        ->orderByDesc('bulan')
        ->get();

    $dataSarana = DataTahunanSarana::with('jenis')
        ->where('kabupaten_ikan_id', $kabupatenId)
        ->orderByDesc('tahun')
        ->get();

    return view('budidaya.input', compact(
        'kabupaten',
        'komoditasList',
        'jenisList',
        'dataProduksi',
        'dataSarana'
    ));
}

    public function create()
    {
        return view('kabupaten_ikans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
        ]);

        KabupatenIkan::create($request->all());

        return redirect()->route('kabupaten_ikans.index')
            ->with('success', 'Kabupaten Ikan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KabupatenIkan $kabupatenIkan)
    {
        return view('kabupaten_ikans.show', compact('kabupatenIkan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KabupatenIkan $kabupatenIkan)
    {
        return view('kabupaten_ikans.edit', compact('kabupatenIkan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KabupatenIkan $kabupatenIkan)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
        ]);

        $kabupatenIkan->update($request->all());

        return redirect()->route('kabupaten_ikans.index')
            ->with('success', 'Kabupaten Ikan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KabupatenIkan $kabupatenIkan)
    {
        $kabupatenIkan->delete();

        return redirect()->route('kabupaten_ikans.index')
            ->with('success', 'Kabupaten Ikan deleted successfully.');
    }
}
