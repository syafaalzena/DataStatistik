<?php

namespace App\Http\Controllers;

use App\Models\LaporanOperasional;
use App\Models\KabupatenIkan;
use App\Models\Pelabuhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanOperasionalController extends Controller
{
    public function index($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);

        $laporans = LaporanOperasional::with('pelabuhan')
            ->whereHas('pelabuhan', fn ($q) => $q->where('kabupaten_ikan_id', $kabupatenId))
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return view('tangkap.laporan-operasional.index', compact('laporans', 'kabupaten'));
    }

    public function create($kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
        $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupatenId)->orderBy('nama')->get();
        $laporan = null;

        return view('tangkap.laporan-operasional.form', compact('pelabuhanList', 'laporan', 'kabupaten'));
    }

    public function store(Request $request, $kabupatenId)
    {
        $validated = $this->validateData($request);

        $exists = LaporanOperasional::where('pelabuhan_id', $validated['pelabuhan_id'])
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Laporan untuk pelabuhan, bulan, dan tahun ini sudah ada. Silakan edit laporan yang sudah ada.');
        }

        $laporan = DB::transaction(function () use ($validated, $request) {
            $laporan = LaporanOperasional::create([
                'pelabuhan_id' => $validated['pelabuhan_id'],
                'bulan' => $validated['bulan'],
                'tahun' => $validated['tahun'],
                'nama_pengelola' => $validated['nama_pengelola'] ?? null,
                'nip_pengelola' => $validated['nip_pengelola'] ?? null,
            ]);

            $this->syncDetails($laporan, $request);

            return $laporan;
        });

        return redirect()->route('laporan-operasional.show', $laporan)->with('success', 'Laporan operasional berhasil disimpan.');
    }

    public function show(LaporanOperasional $laporanOperasional)
    {
        $laporanOperasional->load(['pelabuhan.kabupatenIkan', 'armadaTangkap', 'produksiIkan', 'logistik', 'pemasaran']);
        $kabupaten = $laporanOperasional->pelabuhan->kabupatenIkan;

        return view('tangkap.laporan-operasional.show', ['laporan' => $laporanOperasional, 'kabupaten' => $kabupaten]);
    }

    public function edit(LaporanOperasional $laporanOperasional)
    {
        $laporanOperasional->load(['armadaTangkap', 'produksiIkan', 'logistik', 'pemasaran']);
        $kabupaten = $laporanOperasional->pelabuhan->kabupatenIkan;
        $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupaten->id)->orderBy('nama')->get();
        $laporan = $laporanOperasional;

        return view('tangkap.laporan-operasional.form', compact('pelabuhanList', 'laporan', 'kabupaten'));
    }

    public function update(Request $request, LaporanOperasional $laporanOperasional)
    {
        $validated = $this->validateData($request);

        $exists = LaporanOperasional::where('pelabuhan_id', $validated['pelabuhan_id'])
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->where('id', '!=', $laporanOperasional->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Laporan untuk pelabuhan, bulan, dan tahun ini sudah ada.');
        }

        DB::transaction(function () use ($validated, $request, $laporanOperasional) {
            $laporanOperasional->update([
                'pelabuhan_id' => $validated['pelabuhan_id'],
                'bulan' => $validated['bulan'],
                'tahun' => $validated['tahun'],
                'nama_pengelola' => $validated['nama_pengelola'] ?? null,
                'nip_pengelola' => $validated['nip_pengelola'] ?? null,
            ]);

            $laporanOperasional->armadaTangkap()->delete();
            $laporanOperasional->produksiIkan()->delete();
            $laporanOperasional->logistik()->delete();
            $laporanOperasional->pemasaran()->delete();

            $this->syncDetails($laporanOperasional, $request);
        });

        return redirect()->route('laporan-operasional.show', $laporanOperasional)->with('success', 'Laporan operasional berhasil diperbarui.');
    }

    public function destroy(LaporanOperasional $laporanOperasional)
    {
        $kabupatenId = $laporanOperasional->pelabuhan->kabupaten_ikan_id;
        $laporanOperasional->delete();

        return redirect()->route('laporan-operasional.index', $kabupatenId)->with('success', 'Laporan operasional berhasil dihapus.');
    }

    public function pilihKabupaten()
    {
        $kabupatenIkans = KabupatenIkan::orderBy('nama_kabupaten')->get();

        return view('tangkap.laporan-operasional.pilih-kabupaten', compact('kabupatenIkans'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'pelabuhan_id' => ['required', 'exists:pelabuhans,id'],
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'digits:4'],
            'nama_pengelola' => ['nullable', 'string', 'max:255'],
            'nip_pengelola' => ['nullable', 'string', 'max:100'],

            'ukuran_kapal' => ['array'],
            'ukuran_kapal.*' => ['nullable', 'string', 'max:100'],
            'jumlah_kapal' => ['array'],
            'jumlah_kapal.*' => ['nullable', 'numeric', 'min:0'],
            'jumlah_abk' => ['array'],
            'jumlah_abk.*' => ['nullable', 'numeric', 'min:0'],
            'status_dokumen' => ['array'],
            'status_dokumen.*' => ['nullable', 'string', 'max:100'],

            'jenis_ikan' => ['array'],
            'jenis_ikan.*' => ['nullable', 'string', 'max:150'],
            'produksi_kg' => ['array'],
            'produksi_kg.*' => ['nullable', 'numeric', 'min:0'],
            'harga_rp' => ['array'],
            'harga_rp.*' => ['nullable', 'numeric', 'min:0'],

            'nama_item' => ['array'],
            'nama_item.*' => ['nullable', 'string', 'max:150'],
            'jumlah_logistik' => ['array'],
            'jumlah_logistik.*' => ['nullable', 'numeric', 'min:0'],
            'satuan' => ['array'],
            'satuan.*' => ['nullable', 'string', 'max:50'],
            'harga_logistik' => ['array'],
            'harga_logistik.*' => ['nullable', 'numeric', 'min:0'],
            'total_logistik' => ['array'],
            'total_logistik.*' => ['nullable', 'numeric', 'min:0'],

            'kategori_pemasaran' => ['array'],
            'kategori_pemasaran.*' => ['nullable', 'string', 'in:Lokal,Regional,Ekspor'],
            'jenis_ikan_pemasaran' => ['array'],
            'jenis_ikan_pemasaran.*' => ['nullable', 'string', 'max:150'],
            'quantity_kg' => ['array'],
            'quantity_kg.*' => ['nullable', 'numeric', 'min:0'],
            'tujuan' => ['array'],
            'tujuan.*' => ['nullable', 'string', 'max:150'],
        ]);
    }

    private function syncDetails(LaporanOperasional $laporan, Request $request): void
    {
        foreach ((array) $request->input('ukuran_kapal', []) as $i => $ukuran) {
            if (blank($ukuran)) continue;

            $laporan->armadaTangkap()->create([
                'ukuran_kapal' => $ukuran,
                'jumlah_kapal' => $request->input("jumlah_kapal.$i", 0) ?: 0,
                'jumlah_abk' => $request->input("jumlah_abk.$i", 0) ?: 0,
                'status_dokumen' => $request->input("status_dokumen.$i"),
                'urutan' => $i,
            ]);
        }

        foreach ((array) $request->input('jenis_ikan', []) as $i => $jenis) {
            if (blank($jenis)) continue;

            $produksi = (float) $request->input("produksi_kg.$i", 0);
            $harga = (float) $request->input("harga_rp.$i", 0);

            $laporan->produksiIkan()->create([
                'jenis_ikan' => $jenis,
                'produksi_kg' => $produksi,
                'harga_rp' => $harga,
                'nilai_rp' => $produksi * $harga,
                'urutan' => $i,
            ]);
        }

        foreach ((array) $request->input('nama_item', []) as $i => $nama) {
            if (blank($nama)) continue;

            $jumlah = (float) $request->input("jumlah_logistik.$i", 0);
            $harga = $request->input("harga_logistik.$i");
            $total = $request->input("total_logistik.$i");
            $total = $total !== null && $total !== '' ? (float) $total : ($jumlah * (float) $harga);

            $laporan->logistik()->create([
                'nama_item' => $nama,
                'jumlah' => $jumlah,
                'satuan' => $request->input("satuan.$i"),
                'harga_rp' => $harga !== null && $harga !== '' ? (float) $harga : null,
                'total_rp' => $total,
                'urutan' => $i,
            ]);
        }

        foreach ((array) $request->input('jenis_ikan_pemasaran', []) as $i => $jenis) {
            if (blank($jenis)) continue;

            $laporan->pemasaran()->create([
                'kategori' => $request->input("kategori_pemasaran.$i", 'Lokal'),
                'jenis_ikan' => $jenis,
                'quantity_kg' => (float) $request->input("quantity_kg.$i", 0),
                'tujuan' => $request->input("tujuan.$i"),
                'urutan' => $i,
            ]);
        }
    }
}