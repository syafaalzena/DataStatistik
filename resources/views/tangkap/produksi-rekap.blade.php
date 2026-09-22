<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Produksi Tangkap - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --clr-bg: #F7F5F0; --clr-dark: #0f172a; --clr-blue-brand: #38bdf8; }
        body { background: var(--clr-bg); font-family: 'Inter', sans-serif; color: var(--clr-dark); }
        .navbar { background: var(--clr-dark); color: white; padding: 14px 0; margin-bottom: 1.25rem; }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-text { font-weight: bold; font-size: 26px; color: #fff; }
        .back-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
        .back-btn:hover { background: #0f172a; color: #fff; }
        .btn-logout-icon { background: transparent; border: 1.5px solid rgba(248,250,252,.25); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }

        .panel-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 22px; }
        .rekap-table thead th { background: var(--clr-dark); color: #fff; font-weight: 600; border: none; font-size: 12px; white-space: nowrap; }
        .rekap-table td { vertical-align: middle; font-size: 12px; white-space: nowrap; }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }

        .btn-action { border-radius: 8px; font-weight: 600; padding: 10px 20px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-print { background: #fff; border: 1px solid #e2e8f0; color: var(--clr-dark); }
        .btn-print:hover { background: #f1f5f9; }
        .btn-pdf { background: #dc2626; color: #fff; border: none; }
        .btn-pdf:hover { background: #b91c1c; color: #fff; }
        .btn-excel { background: #16a34a; color: #fff; border: none; }
        .btn-excel:hover { background: #15803d; color: #fff; }

        @media print {
            .navbar, .no-print { display: none !important; }
            body { background: #fff; }
            .panel-card { box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body>

<nav class="navbar no-print">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <span class="brand-text">SIDKP</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn-logout-icon" title="Logout"></button>
        </form>
    </div>
</nav>

<div class="container pb-5">
    <div class="d-flex align-items-center justify-content-between gap-3 mb-4 flex-wrap no-print">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('tangkap.input', $kabupaten->id) }}" class="back-btn">&larr;</a>
            <div>
                <h2 class="fw-bold mb-1">Rekap Produksi Tangkap</h2>
                <p class="text-muted mb-0">{{ $kabupaten->nama_kabupaten }}</p>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
        
           <a href="{{ route('tangkap.produksi.exportPdf', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn-action btn-pdf">⬇ PDF</a>
        <a href="{{ route('tangkap.produksi.export', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn-action btn-excel">⬇ Excel</a>

        </div>
    </div>

    <div class="mb-3">
        <h4 class="fw-bold">Data Produksi Tangkap &mdash; {{ $kabupaten->nama_kabupaten }}</h4>
    </div>

    <form method="GET" class="panel-card mb-3 no-print">
    <div class="row g-2 align-items-end">
        <div class="col-6 col-md-3">
            <label class="form-label small fw-semibold">Tahun</label>
            <select name="tahun" class="form-select">
                <option value="">Semua Tahun</option>
                @foreach($dataProduksi->pluck('tahun')->unique()->sort()->values() as $th)
                    <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label small fw-semibold">Semester</label>
            <select name="semester" class="form-select">
                <option value="">Semua Semester</option>
                <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1 (Jan-Jun)</option>
                <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2 (Jul-Des)</option>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label small fw-semibold">Bulan (opsional)</label>
            <select name="bulan" class="form-select">
                <option value="">Semua Bulan</option>
                @foreach(range(1,12) as $b)
                    <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3">
            <button type="submit" class="btn-action btn-print w-100">Terapkan Filter</button>
        </div>
    </div>
</form>

    <div class="panel-card">
        @if ($dataProduksi->isEmpty())
            <div class="empty-state">Belum ada data produksi untuk kabupaten ini.</div>
        @else
            <div class="table-responsive">
                <table class="table rekap-table">
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
                            <th>Volume (Kg)</th>
                            <th>Harga (Rp)</th>
                            <th>Nilai (Rp)</th>
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
                                <td>{{ number_format($d->volume_produksi_kg, 2, ',', '.') }}</td>
                                <td>{{ number_format($d->harga_rp, 0, ',', '.') }}</td>
                                <td>{{ number_format($d->nilai_rp, 0, ',', '.') }}</td>
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