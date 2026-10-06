<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Trip Bulanan - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
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
        .rekap-table thead th { background: var(--clr-dark); color: #fff; font-weight: 600; border: none; font-size: 13px; }
        .rekap-table td { vertical-align: middle; font-size: 13px; }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }
        .kab-badge { display: inline-block; background: #e0f2fe; color: #0369a1; font-weight: 600; font-size: 12px; padding: 4px 12px; border-radius: 20px; margin-bottom: 6px; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <span class="brand-text">SIDKP</span>
        </a>
       
    </div>
</nav>

<div class="container pb-5">
    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('tangkap.trip.input', $kabupaten->id) }}" class="back-btn">&larr;</a>
        <div>
            <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
            <h2 class="fw-bold mb-1">Rekap Trip Bulanan</h2>
            <p class="text-muted mb-0">Total trip otomatis dijumlahkan dari semua tanggal dalam bulan yang sama.</p>
        </div>
    </div>

    <form method="GET" class="d-flex gap-2 mb-3 flex-wrap" style="max-width:520px;">
        <input type="number" name="tahun" class="form-control" placeholder="Tahun (kosongkan = semua)" value="{{ request('tahun') }}" style="max-width:200px;">
        <select name="semester" class="form-select" style="max-width:200px;">
            <option value="">Semua Semester</option>
            <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1 (Jan-Jun)</option>
            <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2 (Jul-Des)</option>
        </select>
        <button type="submit" class="btn btn-dark">Terapkan</button>
    </form>

    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('tangkap.trip.exportPdf', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn btn-danger">⬇ PDF</a>
        <a href="{{ route('tangkap.trip.export', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn btn-success">⬇ Excel</a>
    </div>

    <div class="panel-card">
        @if($rekapBulanan->isEmpty())
            <div class="empty-state">Belum ada data trip untuk direkap.</div>
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
                            <th>Total Trip</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapBulanan as $r)
                            <tr>
                                <td>{{ $r->tahun }}</td>
                                <td>{{ \Carbon\Carbon::create()->month($r->bulan)->translatedFormat('F') }}</td>
                                <td>{{ $r->nama_pelabuhan }}</td>
                                <td>{{ $r->kode_wppnri }}</td>
                                <td>{{ $r->jenis_lk }}</td>
                                <td>{{ $r->nama_jenis_api }}</td>
                                <td>{{ $r->label_kategori }}</td>
                                <td><strong>{{ $r->total_trip }}</strong></td>
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