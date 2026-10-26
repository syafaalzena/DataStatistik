<?php

namespace App\Http\Controllers;

use App\Models\JenisApi;
use App\Models\KabupatenIkan;
use App\Models\KomoditasIkan;
use App\Models\LaporanOperasional;
use App\Models\Pelabuhan;
use App\Models\Wppnri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanOperasionalController extends Controller
{
    public function pilihKabupaten()
    {
        $kabupatenIkans = KabupatenIkan::where('aktif_tangkap', true)->orderBy('nama_kabupaten')->get();
        return view('tangkap.laporan-operasional.pilih-kabupaten', compact('kabupatenIkans'));
    }

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
        [$jenisApiList, $ikanList, $wppnriList] = $this->opsiForm();
        return view('tangkap.laporan-operasional.form', compact(
            'pelabuhanList', 'laporan', 'kabupaten', 'jenisApiList', 'ikanList', 'wppnriList'
        ));   
        }

    public function store(Request $request, $kabupatenId)
    {
        $kabupaten = KabupatenIkan::findOrFail($kabupatenId);
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
        $laporanOperasional->load(['pelabuhan.kabupatenIkan', 'armadaTangkap.dokumens', 'armadaTangkap.foto', 'produksiIkan.armada', 'logistik.armada', 'pemasaran.armada']);

        return view('tangkap.laporan-operasional.show', ['laporan' => $laporanOperasional]);
    }

    //untuk dw pdf dan excel

    public function exportPdf(LaporanOperasional $laporanOperasional)
    {
        $laporanOperasional->load(['pelabuhan.kabupatenIkan', 'armadaTangkap.dokumens', 'armadaTangkap.foto', 'produksiIkan.armada', 'logistik.armada', 'pemasaran.armada']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tangkap.laporan-operasional.pdf', ['laporan' => $laporanOperasional])
        ->setPaper('a4', 'portrait');

        $namaFile = 'laporan-operasional-' . \Illuminate\Support\Str::slug($laporanOperasional->pelabuhan->nama) . '-' . \Illuminate\Support\Str::slug($laporanOperasional->nama_bulan) . '-' . $laporanOperasional->tahun . '.pdf';

        return $pdf->download($namaFile);
    }

    public function exportExcel(LaporanOperasional $laporanOperasional)
    {
        $laporanOperasional->load(['pelabuhan.kabupatenIkan', 'armadaTangkap.dokumens', 'produksiIkan.armada', 'logistik.armada', 'pemasaran.armada']);

        $namaFile = 'laporan-operasional-' . \Illuminate\Support\Str::slug($laporanOperasional->pelabuhan->nama) . '-' . \Illuminate\Support\Str::slug($laporanOperasional->nama_bulan) . '-' . $laporanOperasional->tahun . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanOperasionalExport($laporanOperasional), $namaFile);
    }

    public function edit(LaporanOperasional $laporanOperasional)
    {
        $laporanOperasional->load(['armadaTangkap.dokumens', 'armadaTangkap.foto', 'armadaTangkap.produksiIkan', 'armadaTangkap.logistik', 'armadaTangkap.pemasaran', 'produksiIkan', 'logistik', 'pemasaran', 'pelabuhan.kabupatenIkan']);

        $kabupaten = $laporanOperasional->pelabuhan->kabupatenIkan;
        $pelabuhanList = Pelabuhan::where('kabupaten_ikan_id', $kabupaten->id)->orderBy('nama')->get();
        $laporan = $laporanOperasional;
        [$jenisApiList, $ikanList, $wppnriList] = $this->opsiForm();

        return view('tangkap.laporan-operasional.form', compact(
            'pelabuhanList', 'laporan', 'kabupaten', 'jenisApiList', 'ikanList', 'wppnriList'
        ));
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

    public function rekapTahunan(Request $request)
    {
        $data = $this->dataRekapTahunan($request);

        return view('tangkap.laporan-operasional.rekap', $data);
    }

    public function rekapTahunanPdf(Request $request)
    {
        $data = $this->dataRekapTahunan($request);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tangkap.laporan-operasional.rekap-pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('rekap-tahunan-' . $data['tahun'] . '.pdf');
    }

    public function rekapTahunanExcel(Request $request)
    {
        $data = $this->dataRekapTahunan($request);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapTahunanOperasionalExport($data['laporans'], $data['tahun'], $data['grandTotalProduksi'], $data['grandTotalNilai'], $data['keterangan']),
            'rekap-tahunan-' . $data['tahun'] . '.xlsx'
        );
    }

    private function dataRekapTahunan(Request $request): array
    {
        $request->validate([
            'tahun' => ['nullable', 'integer'],
            'ukuran' => ['nullable', 'string', 'max:100'],
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date'],
            'asal' => ['nullable', 'in:laporan,produksi'],
        ]);

        $tahun = (int) $request->input('tahun', now()->year);
        $ukuran = trim((string) $request->input('ukuran', ''));
        $dari = $request->input('dari');
        $sampai = $request->input('sampai');

        
        $asal = $request->input('asal') === 'produksi' ? 'produksi' : 'laporan';
        $urlKembali = $asal === 'produksi'
            ? url('/tangkap/produksi')
            : url('/tangkap/laporan-operasional');

        $tahunTersedia = LaporanOperasional::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        if ($tahunTersedia->isEmpty()) {
            $tahunTersedia = collect([$tahun]);
        }

        $laporanTahun = LaporanOperasional::with([
            'pelabuhan.kabupatenIkan',
            'armadaTangkap.produksiIkan',
            'armadaTangkap.logistik',
        ])->where('tahun', $tahun)->get();

        // Daftar ukuran untuk dropdown (diambil sebelum difilter, supaya pilihannya lengkap)
        $ukuranTersedia = $laporanTahun
            ->flatMap(fn ($l) => $l->armadaTangkap)
            ->pluck('ukuran_kapal')
            ->map(fn ($u) => trim((string) $u))
            ->filter()
            ->unique()
            ->sort(SORT_NATURAL)
            ->values();

        // Satu baris = satu trip kapal
        $baris = collect();
        foreach ($laporanTahun as $l) {
            foreach ($l->armadaTangkap as $a) {
                $u = trim((string) $a->ukuran_kapal);
                if ($ukuran !== '' && $u !== $ukuran) {
                    continue;
                }

                $berangkat = $a->tanggal_berangkat?->format('Y-m-d');
                if ($dari && (! $berangkat || $berangkat < $dari)) {
                    continue;
                }
                if ($sampai && (! $berangkat || $berangkat > $sampai)) {
                    continue;
                }

                $baris->push((object) [
                    'laporan_id' => $l->id,
                    'kabupaten' => $l->pelabuhan->kabupatenIkan->nama_kabupaten ?? '-',
                    'pelabuhan' => $l->pelabuhan->nama ?? '-',
                    'bulan_no' => (int) $l->bulan,
                    'bulan' => $l->nama_bulan,
                    'nama_kapal' => $a->nama_armada ?: '-',
                    'ukuran' => $u !== '' ? $u : '-',
                    'berangkat' => $a->tanggal_berangkat?->format('d-m-Y') ?? '-',
                    'pulang' => $a->tanggal_pulang?->format('d-m-Y') ?? '-',
                    'urut_tanggal' => $berangkat ?? '',
                    'abk' => (float) $a->jumlah_abk,
                    'produksi_kg' => (float) $a->produksiIkan->sum('produksi_kg'),
                    'nilai_rp' => (float) $a->produksiIkan->sum('nilai_rp'),
                    'logistik_rp' => (float) $a->logistik->sum('total_rp'),
                ]);
            }
        }

        $laporans = $baris
            ->sortBy([
                ['kabupaten', 'asc'],
                ['pelabuhan', 'asc'],
                ['bulan_no', 'asc'],
                ['urut_tanggal', 'asc'],
            ])
            ->groupBy('kabupaten');

        $grandTotalProduksi = (float) $baris->sum('produksi_kg');
        $grandTotalNilai = (float) $baris->sum('nilai_rp');
        $totalTrip = $baris->count();
        $totalKapal = $baris->pluck('nama_kapal')->reject(fn ($n) => $n === '-')->unique()->count();

        $ket = [];
        if ($ukuran !== '') {
            $ket[] = "Ukuran kapal: $ukuran GT";
        }
        if ($dari || $sampai) {
            $ket[] = 'Berangkat: '
                . ($dari ? \Carbon\Carbon::parse($dari)->format('d-m-Y') : '...')
                . ' s/d '
                . ($sampai ? \Carbon\Carbon::parse($sampai)->format('d-m-Y') : '...');
        }
        $keterangan = implode(' | ', $ket);

        return compact(
            'laporans', 'tahun', 'tahunTersedia', 'ukuranTersedia', 'ukuran', 'dari', 'sampai',
            'grandTotalProduksi', 'grandTotalNilai', 'totalTrip', 'totalKapal', 'keterangan',
            'asal', 'urlKembali'
        );
    }
    // Daftar pilihan untuk form: Jenis API (sama dengan portal Produksi) & nama ikan (untuk saran + cek typo)
    private function opsiForm(): array
    {
        $jenisApiList = JenisApi::orderBy('nama')->pluck('nama');
        $ikanList = KomoditasIkan::query()->distinct()->orderBy('nama_ikan')->pluck('nama_ikan');
        $wppnriList = Wppnri::orderBy('kode')->get();

        return [$jenisApiList, $ikanList, $wppnriList];
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'pelabuhan_id' => ['required', 'exists:pelabuhans,id'],
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'digits:4'],
            'nama_pengelola' => ['nullable', 'string', 'max:255'],
            'nip_pengelola' => ['nullable', 'string', 'max:100'],

            'nama_armada' => ['array'],
            'nama_armada.*' => ['nullable', 'string', 'max:150'],
            'tanggal_berangkat' => ['array'],
            'tanggal_berangkat.*' => ['nullable', 'date'],
            'tanggal_pulang' => ['array'],
            'tanggal_pulang.*' => ['nullable', 'date'],
            'jenis_alat_tangkap' => ['array'],
            'jenis_alat_tangkap.*' => ['nullable', 'string', 'max:150'],
            'ukuran_kapal' => ['array'],
            'ukuran_kapal.*' => ['nullable', 'string', 'max:100'],
            'jumlah_abk' => ['array'],
            'jumlah_abk.*' => ['nullable', 'numeric', 'min:0'],
            'latitude' => ['array'],
            'latitude.*' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['array'],
            'longitude.*' => ['nullable', 'numeric', 'between:-180,180'],
            'dokumen_nama' => ['array'],
            'dokumen_nama.*' => ['array'],
            'dokumen_nama.*.*' => ['nullable', 'string', 'max:150'],
            'foto' => ['array'],
            'foto.*' => ['nullable', 'image', 'max:5120'], //5120 = 5mb perfoto
            'foto_lama' => ['array'],
            'foto_lama.*' => ['nullable', 'string'],
            'lokasi_foto' => ['array'], 
            'lokasi_foto.*' => ['nullable', 'string', 'max:150'],
            'wppnri_id' => ['array'],
            'wppnri_id.*' => ['nullable', 'exists:wppnris,id'],

            // Produksi, logistik, pemasaran: dikelompokkan per kapal -> field[indexKapal][]
            'jenis_ikan' => ['array'],
            'jenis_ikan.*' => ['array'],
            'jenis_ikan.*.*' => ['nullable', 'string', 'max:150'],
            'produksi_kg' => ['array'],
            'produksi_kg.*' => ['array'],
            'produksi_kg.*.*' => ['nullable', 'numeric', 'min:0'],
            'harga_rp' => ['array'],
            'harga_rp.*' => ['array'],
            'harga_rp.*.*' => ['nullable', 'numeric', 'min:0'],

            'nama_item' => ['array'],
            'nama_item.*' => ['array'],
            'nama_item.*.*' => ['nullable', 'string', 'max:150'],
            'jumlah_logistik' => ['array'],
            'jumlah_logistik.*' => ['array'],
            'jumlah_logistik.*.*' => ['nullable', 'numeric', 'min:0'],
            'satuan' => ['array'],
            'satuan.*' => ['array'],
            'satuan.*.*' => ['nullable', 'string', 'max:50'],
            'harga_logistik' => ['array'],
            'harga_logistik.*' => ['array'],
            'harga_logistik.*.*' => ['nullable', 'numeric', 'min:0'],
            'total_logistik' => ['array'],
            'total_logistik.*' => ['array'],
            'total_logistik.*.*' => ['nullable', 'numeric', 'min:0'],

            'kategori_pemasaran' => ['array'],
            'kategori_pemasaran.*' => ['array'],
            'kategori_pemasaran.*.*' => ['nullable', 'string', 'in:Lokal,Regional,Ekspor'],
            'jenis_ikan_pemasaran' => ['array'],
            'jenis_ikan_pemasaran.*' => ['array'],
            'jenis_ikan_pemasaran.*.*' => ['nullable', 'string', 'max:150'],
            'quantity_kg' => ['array'],
            'quantity_kg.*' => ['array'],
            'quantity_kg.*.*' => ['nullable', 'numeric', 'min:0'],
            'tujuan' => ['array'],
            'tujuan.*' => ['array'],
            'tujuan.*.*' => ['nullable', 'string', 'max:150'],
            'nama_pt' => ['array'],
            'nama_pt.*' => ['array'],
            'nama_pt.*.*' => ['nullable', 'string', 'max:150'],

        ]);

        // Tanggal pulang tidak boleh sebelum tanggal berangkat
        foreach ((array) $request->input('tanggal_pulang', []) as $i => $pulang) {
            $berangkat = $request->input("tanggal_berangkat.$i");
            if ($pulang && $berangkat && $pulang < $berangkat) {
                $nama = $request->input("nama_armada.$i") ?: 'trip ke-' . ((int) $i + 1);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "tanggal_pulang.$i" => "Tanggal pulang ($nama) tidak boleh lebih awal dari tanggal berangkat.",
                ]);
            }
        }

        // Pemasaran tidak boleh melebihi produksi (per kapal, per jenis ikan)
        foreach (array_keys((array) $request->input('jenis_ikan_pemasaran', [])) as $i) {
            $produksi = [];
            foreach ((array) $request->input("jenis_ikan.$i", []) as $j => $jenis) {
                if (blank($jenis)) {
                    continue;
                }
                $k = mb_strtolower(trim($jenis));
                $produksi[$k] = ($produksi[$k] ?? 0) + (float) $request->input("produksi_kg.$i.$j", 0);
            }

            $pemasaran = [];
            foreach ((array) $request->input("jenis_ikan_pemasaran.$i", []) as $j => $jenis) {
                if (blank($jenis)) {
                    continue;
                }
                $k = mb_strtolower(trim($jenis));
                $pemasaran[$k] = ($pemasaran[$k] ?? 0) + (float) $request->input("quantity_kg.$i.$j", 0);
            }

            foreach ($pemasaran as $k => $jumlah) {
                if ($jumlah <= 0) {
                    continue;
                }

                $tersedia = $produksi[$k] ?? 0;
                if (round($jumlah, 2) > round($tersedia, 2)) {
                    $nama = $request->input("nama_armada.$i") ?: 'kapal ke-' . ((int) $i + 1);
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "jenis_ikan_pemasaran.$i" => "Pemasaran $k di $nama (" . number_format($jumlah, 0, ',', '.') . " Kg) melebihi produksinya (" . number_format($tersedia, 0, ',', '.') . " Kg).",
                    ]);
                }
            }
    }
        return $validated;
    }

    private function syncDetails(LaporanOperasional $laporan, Request $request): void
    {
        // Semua kapal yang ada di form (kunci = nomor kapal di form)
        $indeksKapal = collect(['nama_armada', 'ukuran_kapal', 'jenis_ikan', 'nama_item', 'jenis_ikan_pemasaran'])
            ->flatMap(fn ($f) => array_keys((array) $request->input($f, [])))
            ->unique()
            ->sort()
            ->values();

        $urutan = 0;

        foreach ($indeksKapal as $i) {
            $ukuran = $request->input("ukuran_kapal.$i");
            $adaDetail = $this->adaIsi($request->input("jenis_ikan.$i"))
                || $this->adaIsi($request->input("nama_item.$i"))
                || $this->adaIsi($request->input("jenis_ikan_pemasaran.$i"));

            // Kapal benar-benar kosong (tidak ada ukuran, nama, maupun isian di bawahnya) dilewati
            if (blank($ukuran) && blank($request->input("nama_armada.$i")) && ! $adaDetail) {
                continue;
            }

            $kapal = $laporan->armadaTangkap()->create([
                'nama_armada' => $request->input("nama_armada.$i"),
                'tanggal_berangkat' => $request->input("tanggal_berangkat.$i") ?: null,
                'tanggal_pulang' => $request->input("tanggal_pulang.$i") ?: null,
                'jenis_alat_tangkap' => $request->input("jenis_alat_tangkap.$i"),
                'latitude' => $request->filled("latitude.$i") ? $request->input("latitude.$i") : null,
                'longitude' => $request->filled("longitude.$i") ? $request->input("longitude.$i") : null,
                'ukuran_kapal' => $ukuran ?? '',
                'jumlah_abk' => $request->input("jumlah_abk.$i", 0) ?: 0,
                'urutan' => $urutan++,
                'wppnri_id' => $request->input("wppnri_id.$i") ?: null,
            ]);

            foreach ((array) $request->input("dokumen_nama.$i", []) as $j => $namaDok) {
                if (blank($namaDok)) {
                    continue;
                }

                $kapal->dokumens()->create([
                    'nama_dokumen' => $namaDok,
                    'urutan' => $j,
                ]);
            }

            // Foto kapal (1 foto per kapal)
            $fotoPath = null;
            if ($request->hasFile("foto.$i")) {
                $fotoPath = $request->file("foto.$i")->store('kapal-photos', 'public');
            } elseif ($request->filled("foto_lama.$i")) {
                $fotoPath = $request->input("foto_lama.$i");
            }

            if ($fotoPath) {
                $kapal->foto()->create([
                    'foto' => $fotoPath,
                    'lokasi' => $request->input("lokasi_foto.$i"),
                ]);
            }

            // Produksi Ikan Dominan milik kapal ini
            foreach ((array) $request->input("jenis_ikan.$i", []) as $j => $jenis) {
                if (blank($jenis)) {
                    continue;
                }

                $produksi = (float) $request->input("produksi_kg.$i.$j", 0);
                $harga = (float) $request->input("harga_rp.$i.$j", 0);

                $kapal->produksiIkan()->create([
                    'laporan_operasional_id' => $laporan->id,
                    'jenis_ikan' => $jenis,
                    'produksi_kg' => $produksi,
                    'harga_rp' => $harga,
                    'nilai_rp' => $produksi * $harga,
                    'urutan' => $j,
                ]);
            }

            // Logistik milik kapal ini
            foreach ((array) $request->input("nama_item.$i", []) as $j => $nama) {
                if (blank($nama)) {
                    continue;
                }

                $jumlah = (float) $request->input("jumlah_logistik.$i.$j", 0);
                $harga = $request->input("harga_logistik.$i.$j");
                $total = $request->input("total_logistik.$i.$j");
                $total = $total !== null && $total !== '' ? (float) $total : ($jumlah * (float) $harga);

                $kapal->logistik()->create([
                    'laporan_operasional_id' => $laporan->id,
                    'nama_item' => $nama,
                    'jumlah' => $jumlah,
                    'satuan' => $request->input("satuan.$i.$j"),
                    'harga_rp' => $harga !== null && $harga !== '' ? (float) $harga : null,
                    'total_rp' => $total,
                    'urutan' => $j,
                ]);
            }

            // Pemasaran milik kapal ini
            foreach ((array) $request->input("jenis_ikan_pemasaran.$i", []) as $j => $jenis) {
                if (blank($jenis)) {
                    continue;
                }

                $kapal->pemasaran()->create([
                    'laporan_operasional_id' => $laporan->id,
                    'kategori' => $request->input("kategori_pemasaran.$i.$j", 'Lokal'),
                    'jenis_ikan' => $jenis,
                    'quantity_kg' => (float) $request->input("quantity_kg.$i.$j", 0),
                    'tujuan' => $request->input("tujuan.$i.$j"),
                    'nama_pt' => $request->input("nama_pt.$i.$j"),
                    'urutan' => $j,
                ]);
            }
        }
    }

    private function adaIsi($daftar): bool
    {
        foreach ((array) $daftar as $v) {
            if (! blank($v)) {
                return true;
            }
        }

        return false;
    }
}
