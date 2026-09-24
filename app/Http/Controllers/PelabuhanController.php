<?php

namespace App\Http\Controllers;

use App\Models\KabupatenIkan;
use App\Models\Pelabuhan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelabuhanController extends Controller
{
    public function index($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
        $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupatenId)
            ->orderBy('nama')
            ->get();

        return view('tangkap.pelabuhan-index', compact('kabupaten', 'pelabuhanList'));
    }

    public function store(Request $request, $kabupatenId)
    {
        $validated = $request->validate([
            'nama' => [
                'required', 'string',
                Rule::unique('pelabuhans')->where(fn ($q) => $q->where('kabupaten_ikan_id', $kabupatenId)),
            ],
            'jenis_lk' => ['required', 'in:Pelabuhan,Non Pelabuhan'],
        ]);

        Pelabuhan::create([
            'kabupaten_ikan_id' => $kabupatenId,
            'nama' => $validated['nama'],
            'jenis_lk' => $validated['jenis_lk'],
        ]);

        return redirect()->back()->with('success', 'Pelabuhan baru berhasil ditambahkan.');
    }

    public function update(Request $request, Pelabuhan $pelabuhan)
    {
        $validated = $request->validate([
            'nama' => [
                'required', 'string',
                Rule::unique('pelabuhans')
                    ->where(fn ($q) => $q->where('kabupaten_ikan_id', $pelabuhan->kabupaten_ikan_id))
                    ->ignore($pelabuhan->id),
            ],
            'jenis_lk' => ['required', 'in:Pelabuhan,Non Pelabuhan'],
        ]);

        $pelabuhan->update($validated);

        return redirect()->back()->with('success', 'Data pelabuhan berhasil diperbarui.');
    }

    public function destroy(Pelabuhan $pelabuhan)
    {
        if ($pelabuhan->produksiTangkap()->exists()) {
            return redirect()->back()->with('error', 'Pelabuhan ini tidak bisa dihapus karena masih dipakai di data produksi. Hapus/ubah dulu data produksinya.');
        }

        $pelabuhan->delete();

        return redirect()->back()->with('success', 'Pelabuhan berhasil dihapus.');
    }
}