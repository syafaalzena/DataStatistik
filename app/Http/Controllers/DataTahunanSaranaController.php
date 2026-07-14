<?php

namespace App\Http\Controllers;

use App\Models\DataTahunanSarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTahunanSaranaController extends Controller
{
    public function store(Request $request, $kabupatenId)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',

            'jenis_id'   => 'array',
            'jenis_id.*' => 'exists:jenis_budidayas,id',
            'rtp'        => 'array',
            'rtp.*'      => 'nullable|integer|min:0',
            'pembudidaya'   => 'array',
            'pembudidaya.*' => 'nullable|integer|min:0',
            'luas_lahan'    => 'array',
            'luas_lahan.*'  => 'nullable|integer|min:0',
        ]);

        $tahun = $validated['tahun'];
        $tersimpan = 0;

        DB::transaction(function () use ($request, $kabupatenId, $tahun, &$tersimpan) {
            $jenisIds = $request->input('jenis_id', []);
            $rtpVals = $request->input('rtp', []);
            $pembudidayaVals = $request->input('pembudidaya', []);
            $luasLahanVals = $request->input('luas_lahan', []);

            foreach ($jenisIds as $i => $jenisId) {
                if (!isset($rtpVals[$i]) || $rtpVals[$i] === '' || $rtpVals[$i] === null) {
                    continue;
                }
                DataTahunanSarana::updateOrCreate(
                    [
                        'kabupaten_ikan_id' => $kabupatenId,
                        'jenis_budidaya_id' => $jenisId,
                        'tahun' => $tahun,
                    ],
                    [
                        'jumlah_rtp' => $rtpVals[$i],
                        'jumlah_pembudidaya' => $pembudidayaVals[$i] ?? null,
                        'luas_lahan' => $luasLahanVals[$i] ?? null,
                    ]
                );
                $tersimpan++;
            }
        });

        if ($tersimpan === 0) {
            return back()->with('error', 'Isi minimal satu jenis budidaya untuk data tahunan ini.');
        }

        return back()->with('success', "Tersimpan {$tersimpan} data sarana tahunan.");
    }

    public function update(Request $request, $id)
    {
        $data = DataTahunanSarana::findOrFail($id);
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah_rtp' => 'required|integer|min:0',
            'jumlah_pembudidaya' => 'nullable|integer|min:0',
            'luas_lahan' => 'nullable|integer|min:0',
        ]);
        $data->update($validated);

        return back()->with('success', 'Data sarana diperbarui.');
    }

    public function destroy($id)
    {
        DataTahunanSarana::findOrFail($id)->delete();
        return back()->with('success', 'Data sarana dihapus.');
    }
}