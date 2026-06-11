<?php

namespace App\Http\Controllers;

use App\Models\DataTahunan;
use Illuminate\Http\Request;

class DataTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DataTahunan::with('kabupaten')->orderBy('tahun', 'desc')->get();
        return view('garam.tahunan.index', compact('data'));
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

    public function rekapTahunan()
    {
        $data = DataTahunan::with('kabupaten')->orderBy('tahun', 'desc')->get();
        return view('garam.rekap-tahunan', compact('data'));
    }
}
