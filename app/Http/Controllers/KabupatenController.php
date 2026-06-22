<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use Illuminate\Http\Request;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kabupaten = Kabupaten::all();
        return view('kabupaten.index', compact('kabupaten'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kabupaten.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
        ]);

        Kabupaten::create($request->all());

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kabupaten $kabupaten)
    {
        $dataTahunan = $kabupaten->dataTahunan()->orderBy('tahun', 'desc')->get();
        $dataBulanan = $kabupaten->dataBulanan()->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $dataTahunan = $kabupaten->dataTahunan()->orderBy('tahun', 'desc')->get();

    $tahunList = $kabupaten->dataBulanan()
                    ->select('tahun')
                    ->distinct()
                    ->orderBy('tahun', 'desc')
                    ->pluck('tahun');

    $query = $kabupaten->dataBulanan()
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc');

    if (request('bulan')) {
        $query->where('bulan', request('bulan'));
    }

    if (request('tahun')) {
        $query->where('tahun', request('tahun'));
    }

    $dataBulanan = $query->get();

    return view('kabupaten.show', compact('kabupaten', 'dataTahunan', 'dataBulanan', 'tahunList'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kabupaten $kabupaten)
    {
        return view('kabupaten.edit', compact('kabupaten'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kabupaten $kabupaten)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
        ]);

        $kabupaten->update($request->all());

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kabupaten $kabupaten)
    {
        $kabupaten->delete();

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten deleted successfully.');
    }

    
} 
