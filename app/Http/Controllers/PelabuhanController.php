// app/Http/Controllers/PelabuhanController.php
<?php

namespace App\Http\Controllers;

use App\Models\Pelabuhan;
use Illuminate\Http\Request;

class PelabuhanController extends Controller
{
    public function store(Request $request, $kabupatenId)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string'],
        ]);

        Pelabuhan::create([
            'kabupaten_ikan_id' => $kabupatenId,
            'nama' => $validated['nama'],
        ]);

        return redirect()->back()->with('success', 'Pelabuhan baru berhasil ditambahkan.');
    }

    public function update(Request $request, Pelabuhan $pelabuhan)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string'],
        ]);

        $pelabuhan->update($validated);

        return redirect()->back()->with('success', 'Data pelabuhan berhasil diperbarui.');
    }

    public function destroy(Pelabuhan $pelabuhan)
    {
        $pelabuhan->delete();

        return redirect()->back()->with('success', 'Pelabuhan berhasil dihapus.');
    }
}