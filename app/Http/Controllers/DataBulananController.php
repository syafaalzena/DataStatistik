<?php

namespace App\Http\Controllers;

use App\Models\DataBulanan;
use Illuminate\Http\Request;

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
    public function create()
    {
        return view('garam.bulanan.create');
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
            'harga' => 'required|numeric',
        ]);

        DataBulanan::create($request->all());

        return redirect()->route('data-bulanan.index')
            ->with('success', 'Data bulanan created successfully.');
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
        return view('garam.bulanan.edit', compact('dataBulanan'));
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
            'harga' => 'required|numeric',
        ]);

        $dataBulanan->update($request->all());

        return redirect()->route('data-bulanan.index')
            ->with('success', 'Data bulanan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataBulanan $dataBulanan)
    {
        $dataBulanan->delete();
        return redirect()->route('data-bulanan.index')
            ->with('success', 'Data bulanan deleted successfully.');
    }

    public function rekapBulanan()
    {
        $data = DataBulanan::with('kabupaten')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('garam.rekap_bulanan', compact('data'));
    }
}
