<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Tahunan - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/rekap.css') }}">
</head>
<body>

<nav class="navbar no-print">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <span class="brand-text">SIDKP</span>
        </a>
    </div>
</nav>

<div class="container pb-5">

    {{-- ── HEADER ── --}}
    <div class="page-header">
        <div class="page-title-wrap">
            <a href="{{ route('tangkap.tahunan.input', $kabupaten->id) }}" class="back-btn no-print">&larr;</a>
            <div>
                <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
                <h2 class="page-title">Rekap Tahunan</h2>
                <p class="page-desc">RTP, Kapal, API, dan Nelayan dijumlahkan per tahun/pelabuhan/kombinasi.</p>
            </div>
        </div>

        <div class="export-actions no-print">
            <a href="{{ route('tangkap.tahunan.exportPdf', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn-export btn-export-pdf">
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
                PDF
            </a>
            <a href="{{ route('tangkap.tahunan.export', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn-export btn-export-excel">
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
                <input type="number" name="tahun" class="form-control" placeholder="Kosongkan = semua" value="{{ request('tahun') }}">
            </div>
            <div class="col-12 col-md-auto d-flex gap-2">
                <button type="submit" class="btn-filter btn-filter-apply">Terapkan</button>
                <a href="{{ url()->current() }}" class="btn-filter btn-filter-reset">Reset</a>
            </div>
        </div>
    </form>

    {{-- ── TABEL ── --}}
    <div class="panel-card">
        @if($rekapTahunan->isEmpty())
            <div class="empty-state">Belum ada data tahunan untuk direkap.</div>
        @else
            <div class="table-responsive">
                <table class="table table-hover rekap-table">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Pelabuhan</th>
                            <th>WPPNRI</th>
                            <th>Jenis LK</th>
                            <th>Jenis API</th>
                            <th>Ukuran Kapal</th>
                            <th class="num">RTP</th>
                            <th class="num">Kapal</th>
                            <th class="num">API</th>
                            <th class="num">Nelayan Buruh</th>
                            <th class="num">Total Nelayan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapTahunan as $r)
                            <tr>
                                <td>{{ $r->tahun }}</td>
                                <td>{{ $r->nama_pelabuhan }}</td>
                                <td>{{ $r->kode_wppnri }}</td>
                                <td>{{ $r->jenis_lk }}</td>
                                <td>{{ $r->nama_jenis_api }}</td>
                                <td>{{ $r->label_kategori }}</td>
                                <td class="num">{{ $r->total_rtp }}</td>
                                <td class="num">{{ $r->total_kapal }}</td>
                                <td class="num">{{ $r->total_api }}</td>
                                <td class="num">{{ $r->total_nelayan_buruh }}</td>
                                <td class="num"><strong>{{ $r->total_nelayan }}</strong></td>
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