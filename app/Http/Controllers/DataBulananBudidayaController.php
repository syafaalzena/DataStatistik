<?php

namespace App\Http\Controllers;

use App\Models\data_bulanan_budidaya;
use Illuminate\Http\Request;

class DataBulananBudidayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataBulananBudidayas = data_bulanan_budidaya::all();
        return view('data_bulanan_budidayas.index', compact('dataBulananBudidayas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data_bulanan_budidayas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten_ikan_id' => 'required|integer|exists:kabupaten_ikans,id',
            'komoditas_budidaya_id' => 'required|integer|exists:komoditas_budidayas,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'hasil_produksi' => 'required|numeric|min:0',
            'jumlah_pembudidaya' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        data_bulanan_budidaya::create($request->all());

        return redirect()->route('data_bulanan_budidayas.index')
            ->with('success', 'Data Bulanan Budidaya created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(data_bulanan_budidaya $data_bulanan_budidaya)
    {
        return view('data_bulanan_budidayas.show', compact('data_bulanan_budidaya'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(data_bulanan_budidaya $data_bulanan_budidaya)
    {
        return view('data_bulanan_budidayas.edit', compact('data_bulanan_budidaya'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, data_bulanan_budidaya $data_bulanan_budidaya)
    {
        $request->validate([
            'kabupaten_ikan_id' => 'required|integer|exists:kabupaten_ikans,id',
            'komoditas_budidaya_id' => 'required|integer|exists:komoditas_budidayas,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'hasil_produksi' => 'required|numeric|min:0',
            'jumlah_pembudidaya' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $data_bulanan_budidaya->update($request->all());

        return redirect()->route('data_bulanan_budidayas.index')
            ->with('success', 'Data Bulanan Budidaya updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(data_bulanan_budidaya $data_bulanan_budidaya)
    {
        $data_bulanan_budidaya->delete();

        return redirect()->route('data_bulanan_budidayas.index')
            ->with('success', 'Data Bulanan Budidaya deleted successfully.');
    }
}
