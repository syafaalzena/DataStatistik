<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Tahunan - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --clr-bg: #F7F5F0; --clr-dark: #0f172a; --clr-blue-brand: #38bdf8; }
        body { background: var(--clr-bg); font-family: 'Inter', sans-serif; color: var(--clr-dark); }
        .navbar { background: var(--clr-dark); color: white; padding: 14px 0; box-shadow: 0 4px 12px rgba(15,23,42,.05); margin-bottom: 1.5rem; }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-logo-img { height: 40px; width: auto; }
        .brand-text { font-weight: bold; font-size: 26px; color: #fff; }
        .back-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
        .back-btn:hover { background: #0f172a; color: #fff; }
        .back-btn img { transition: filter .18s ease; }
        .back-btn:hover img { filter: brightness(0) invert(1); }
        .btn-logout-icon { background: transparent; border: 1.5px solid rgba(248,250,252,.25); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }
        .btn-logout-icon img { filter: brightness(0) invert(1); transition: filter .18s ease; }
        .btn-logout-icon:hover img { filter: none; }
        .kab-badge { display: inline-block; background: #e0f2fe; color: #0369a1; font-weight: 600; font-size: 12px; padding: 4px 12px; border-radius: 20px; margin-bottom: 6px; }
        .panel-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 16px; }
        .rekap-table thead th { background: var(--clr-dark); color: #fff; font-size: 13px; white-space: nowrap; }
        .rekap-table td { font-size: 13px; white-space: nowrap; text-align: center; vertical-align: middle; }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <img src="{{ asset('images/pancacita.png') }}" alt="Logo Pancacita" class="brand-logo-img">
            <span class="brand-text">SIDKP</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn-logout-icon" title="Logout">
                <img src="{{ asset('images/logout.png') }}" alt="Logout" width="20" height="20">
            </button>
        </form>
    </div>
</nav>

<div class="container pb-5">

    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('tangkap.tahunan.input', $kabupaten->id) }}" class="back-btn">
            <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
        </a>
        <div>
            <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
            <h2 class="fw-bold mb-1">Rekap Tahunan</h2>
            <p class="text-muted mb-0">RTP, Kapal, API, dan Nelayan dijumlahkan per tahun/pelabuhan/kombinasi.</p>
        </div>
    </div>

    <form method="GET" class="d-flex gap-2 mb-3 flex-wrap" style="max-width:320px;">
        <input type="number" name="tahun" class="form-control" placeholder="Tahun (kosongkan = semua)" value="{{ request('tahun') }}">
        <button type="submit" class="btn btn-dark">Terapkan</button>
    </form>

    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('tangkap.tahunan.exportPdf', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn btn-danger">⬇ PDF</a>
        <a href="{{ route('tangkap.tahunan.export', array_merge(['kabupaten' => $kabupaten->id], request()->query())) }}" class="btn btn-success">⬇ Excel</a>
    </div>

    <div class="panel-card">
        @if($rekapTahunan->isEmpty())
            <div class="empty-state">Belum ada data tahunan untuk direkap.</div>
        @else
            <div class="table-responsive">
                <table class="table rekap-table">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Pelabuhan</th>
                            <th>WPPNRI</th>
                            <th>Jenis LK</th>
                            <th>Jenis API</th>
                            <th>Ukuran Kapal</th>
                            <th>RTP</th>
                            <th>Kapal</th>
                            <th>API</th>
                            <th>Nelayan Buruh</th>
                            <th>Total Nelayan</th>
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
                                <td>{{ $r->total_rtp }}</td>
                                <td>{{ $r->total_kapal }}</td>
                                <td>{{ $r->total_api }}</td>
                                <td>{{ $r->total_nelayan_buruh }}</td>
                                <td><strong>{{ $r->total_nelayan }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

</body>
</html>
