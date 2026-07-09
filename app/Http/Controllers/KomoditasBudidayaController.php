<?php

namespace App\Http\Controllers;

use App\Models\KabupatenIkan;
use App\Models\KomoditasBudidaya;
use Illuminate\Http\Request;

class KomoditasBudidayaController extends Controller
{
    /**
     * Daftar semua komoditas, dikelompokkan per kabupaten biar gampang dibaca.
     */
    public function index()
    {
        $kabupatens = KabupatenIkan::with('komoditas')
            ->orderBy('nama_kabupaten')
            ->get();

        return view('komoditas_budidaya.index', compact('kabupatens'));
    }

    /**
     * Form tambah komoditas baru.
     */
    public function create()
    {
        $kabupatens = KabupatenIkan::orderBy('nama_kabupaten')->get();

        return view('komoditas_budidaya.create', compact('kabupatens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kabupaten_ikan_id' => 'required|exists:kabupaten_ikans,id',
            'nama_komoditas'    => [
                'required',
                'string',
                'max:255',
                // cegah duplikat nama komoditas dalam satu kabupaten yang sama
                function ($attribute, $value, $fail) use ($request) {
                    $exists = KomoditasBudidaya::where('kabupaten_ikan_id', $request->kabupaten_ikan_id)
                        ->where('nama_komoditas', $value)
                        ->exists();
                    if ($exists) {
                        $fail('Komoditas ini sudah terdaftar untuk kabupaten tersebut.');
                    }
                },
            ],
        ]);

        KomoditasBudidaya::create($validated);

        return redirect()
            ->route('komoditas-budidaya.index')
            ->with('success', 'Komoditas berhasil ditambahkan.');
    }

    public function show(KomoditasBudidaya $komoditas_budidaya)
    {
        return redirect()->route('komoditas-budidaya.index');
    }

    public function edit(KomoditasBudidaya $komoditas_budidaya)
    {
        $kabupatens = KabupatenIkan::orderBy('nama_kabupaten')->get();

        return view('komoditas_budidaya.edit', [
            'komoditas'  => $komoditas_budidaya,
            'kabupatens' => $kabupatens,
        ]);
    }

    public function update(Request $request, KomoditasBudidaya $komoditas_budidaya)
    {
        $validated = $request->validate([
            'kabupaten_ikan_id' => 'required|exists:kabupaten_ikans,id',
            'nama_komoditas'    => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $komoditas_budidaya) {
                    $exists = KomoditasBudidaya::where('kabupaten_ikan_id', $request->kabupaten_ikan_id)
                        ->where('nama_komoditas', $value)
                        ->where('id', '!=', $komoditas_budidaya->id)
                        ->exists();
                    if ($exists) {
                        $fail('Komoditas ini sudah terdaftar untuk kabupaten tersebut.');
                    }
                },
            ],
        ]);

        $komoditas_budidaya->update($validated);

        return redirect()
            ->route('komoditas-budidaya.index')
            ->with('success', 'Komoditas berhasil diperbarui.');
    }

    public function destroy(KomoditasBudidaya $komoditas_budidaya)
    {
        // Catatan: kalau sudah dipakai di data_bulanan_budidayas, hapus akan
        // ikut menghapus data terkait (onDelete cascade). Boleh diganti jadi
        // pengecekan manual dulu kalau mau lebih aman.
        $komoditas_budidaya->delete();

        return redirect()
            ->route('komoditas-budidaya.index')
            ->with('success', 'Komoditas berhasil dihapus.');
    }
}