<?php

namespace App\Http\Controllers;

use App\Models\KomoditasIkan;
use Illuminate\Http\Request;

class KomoditasIkanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ikan' => ['required', 'string', 'unique:komoditas_ikans,nama_ikan'],
            'nama_latin' => ['nullable', 'string'],
            'kode_fao' => ['nullable', 'string'],
            'kelompok_sdi' => ['nullable', 'string'],
        ]);

        KomoditasIkan::create($validated);

        return redirect()->back()->with('success', 'Jenis ikan baru berhasil ditambahkan.');
    }

    public function update(Request $request, KomoditasIkan $komoditasIkan)
    {
        $validated = $request->validate([
            'nama_ikan' => ['required', 'string', 'unique:komoditas_ikans,nama_ikan,' . $komoditasIkan->id],
            'nama_latin' => ['nullable', 'string'],
            'kode_fao' => ['nullable', 'string'],
            'kelompok_sdi' => ['nullable', 'string'],
        ]);

        $komoditasIkan->update($validated);

        return redirect()->back()->with('success', 'Data jenis ikan berhasil diperbarui.');
    }

    public function destroy(KomoditasIkan $komoditasIkan)
    {
        $komoditasIkan->delete();

        return redirect()->back()->with('success', 'Jenis ikan berhasil dihapus.');
    }
}