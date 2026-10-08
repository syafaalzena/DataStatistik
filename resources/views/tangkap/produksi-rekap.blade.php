<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Produksi Tangkap - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/rekap.css') }}">
</head>
<body>

<style>
    .brand-logo-img { height: 40px; width: auto; }
    .back-btn img { transition: filter .18s ease; }
    .back-btn:hover img { filter: brightness(0) invert(1); }
</style>

<nav class="navbar no-print">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <img src="{{ asset('images/pancacita.png') }}" alt="Logo Pancacita" class="brand-logo-img">
            <span class="brand-text">SAMUDRA ACEH</span>
        </a>
    </div>
</nav>

<div class="container pb-5">

    {{-- ── HEADER ── --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <a href="{{ route('tangkap.input', $kabupaten->id) }}" class="back-btn no-print">
                <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
            </a>
            <div>
                <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
                <h2 class="page-title">Rekap Produksi Tangkap</h2>
                <p class="page-desc">Data volume, harga, dan nilai produksi tangkap per jenis ikan.</p>
            </div>
        </div>

        <div class="export-actions no-print">
            <a href="{{ route('tangkap.produksi.exportPdf', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn-export btn-export-pdf">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
                PDF
            </a>
            <a href="{{ route('tangkap.produksi.export', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn-export btn-export-excel">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
                Excel
            </a>
        </div>
    </div>

    {{-- ── FILTER ── --}}
    <form method="GET" class="panel-card filter-card no-print">
        <div class="row g-3 align-items-end">
            <div class="col-6 col-md-3">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($dataProduksi->pluck('tahun')->unique()->sort()->values() as $th)
                        <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label">Semester</label>
                <select name="semester" class="form-select">
                    <option value="">Semua Semester</option>
                    <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1 (Jan-Jun)</option>
                    <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2 (Jul-Des)</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label">Bulan (opsional)</label>
                <select name="bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-auto d-flex gap-2">
                <button type="submit" class="btn-filter btn-filter-apply">Terapkan</button>
                <a href="{{ url()->current() }}" class="btn-filter btn-filter-reset">Reset</a>
            </div>
        </div>
    </form>

    {{-- ── TABEL ── --}}
    <div class="panel-card">
        @if ($dataProduksi->isEmpty())
            <div class="empty-state">Belum ada data produksi untuk kabupaten ini.</div>
        @else
            <div class="table-responsive">
                <table class="table table-hover rekap-table">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Pelabuhan</th>
                            <th>WPPNRI</th>
                            <th>Jenis LK</th>
                            <th>Jenis API</th>
                            <th>Ukuran Kapal</th>
                            <th>Jenis Ikan</th>
                            <th>Nama Latin</th>
                            <th class="num">Volume (Kg)</th>
                            <th class="num">Harga (Rp)</th>
                            <th class="num">Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataProduksi as $d)
                            <tr>
                                <td>{{ $d->tahun }}</td>
                                <td>{{ \Carbon\Carbon::create()->month($d->bulan)->translatedFormat('F') }}</td>
                                <td>{{ $d->pelabuhan->nama ?? '-' }}</td>
                                <td>{{ $d->wppnri->kode ?? '-' }}</td>
                                <td>{{ $d->jenis_lk }}</td>
                                <td>{{ $d->jenisApi->nama ?? '-' }}</td>
                                <td>{{ $d->kategoriUkuranKapal->label ?? '-' }}</td>
                                <td>{{ $d->komoditasIkan->nama_ikan ?? '-' }}</td>
                                <td><em>{{ $d->komoditasIkan->nama_latin ?? '-' }}</em></td>
                                <td class="num">{{ number_format($d->volume_produksi_kg, 2, ',', '.') }}</td>
                                <td class="num">{{ number_format($d->harga_rp, 0, ',', '.') }}</td>
                                <td class="num">{{ number_format($d->nilai_rp, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>