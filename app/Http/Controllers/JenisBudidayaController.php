<?php

namespace App\Http\Controllers;

use App\Models\JenisBudidaya;
use Illuminate\Http\Request;

class JenisBudidayaController extends Controller
{
    // dipakai di halaman "Kelola Jenis Budidaya" per kabupaten
    public function index($kabupatenId)
    {
        $jenis = JenisBudidaya::where('kabupaten_ikan_id', $kabupatenId)
            ->orderBy('nama_jenis')->get();

        return view('budidaya.kelola-jenis', compact('jenis', 'kabupatenId'));
    }

    public function store(Request $request, $kabupatenId)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_budidayas,nama_jenis,NULL,id,kabupaten_ikan_id,' . $kabupatenId,
        ]);

        JenisBudidaya::create([
            'kabupaten_ikan_id' => $kabupatenId,
            'nama_jenis' => $validated['nama_jenis'],
        ]);

        return back()->with('success', 'Jenis budidaya ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisBudidaya::findOrFail($id);
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_budidayas,nama_jenis,' . $id . ',id,kabupaten_ikan_id,' . $jenis->kabupaten_ikan_id,
        ]);
        $jenis->update($validated);

        return back()->with('success', 'Jenis budidaya diperbarui.');
    }

    public function destroy($id)
    {
        JenisBudidaya::findOrFail($id)->delete();
        return back()->with('success', 'Jenis budidaya dihapus.');
    }
}