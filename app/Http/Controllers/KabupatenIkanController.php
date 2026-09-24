<?php

namespace App\Http\Controllers;

use App\Models\KomoditasIkan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KomoditasIkanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ikan' => [
                'required', 'string',
                Rule::unique('komoditas_ikans')->where(fn ($q) => $q->where('nama_latin', $request->input('nama_latin'))),
            ],
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
            'nama_ikan' => [
                'required', 'string',
                Rule::unique('komoditas_ikans')
                    ->where(fn ($q) => $q->where('nama_latin', $request->input('nama_latin')))
                    ->ignore($komoditasIkan->id),
            ],
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