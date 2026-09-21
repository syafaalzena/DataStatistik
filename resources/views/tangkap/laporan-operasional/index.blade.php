<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Operasional Pelabuhan - SIDKP</title>

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
        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 600; border: none; padding: 10px 22px; text-decoration: none; display: inline-block; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }

        .laporan-table thead th { background: var(--clr-dark); color: #fff; font-weight: 600; border: none; font-size: 13px; white-space: nowrap; }
        .laporan-table td { vertical-align: middle; font-size: 14px; }
        .btn-icon-sm { border: none; background: none; font-size: 13px; font-weight: 600; }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }
    </style>
</head>
<body>

<nav class="navbar">
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
            <div class="d-flex align-items-center gap-3">
            <a href="{{ route('tangkap.index') }}" class="back-btn">&larr;</a>
            <div>
                <span class="badge" style="background:#e0f2fe; color:#0369a1; font-weight:600;">{{ $kabupaten->nama_kabupaten }}</span>
                <h2 class="fw-bold mb-1">Laporan Operasional Pelabuhan Perikanan</h2>
                <p class="text-muted mb-0">Rekapitulasi aktivitas harian pelabuhan perikanan per bulan.</p>
            </div>
        </div>
        <a href="{{ route('laporan-operasional.create', $kabupaten->id) }}" class="btn-dark-custom">+ Buat Laporan Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="panel-card">
        @if ($laporans->isEmpty())
            <div class="empty-state">
                Belum ada laporan operasional yang tersimpan.<br>
                Klik "Buat Laporan Baru" untuk mulai input data.
            </div>
        @else
            <div class="table-responsive">
                <table class="table laporan-table">
                    <thead>
                        <tr>
                            <th>Pelabuhan</th>
                            <th>Kabupaten/Kota</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Total Produksi (Kg)</th>
                            <th>Nilai Produksi (Rp)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporans as $l)
                            <tr>
                                <td>{{ $l->pelabuhan->nama ?? '-' }}</td>
                                <td>{{ $l->pelabuhan->kabupatenIkan->nama_kabupaten ?? '-' }}</td>
                                <td>{{ $l->nama_bulan }}</td>
                                <td>{{ $l->tahun }}</td>
                                <td>{{ number_format($l->total_produksi_kg, 0, ',', '.') }}</td>
                                <td>{{ number_format($l->total_nilai_produksi, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('laporan-operasional.show', $l) }}" class="btn-icon-sm text-primary">Lihat</a>
                                    <a href="{{ route('laporan-operasional.edit', $l) }}" class="btn-icon-sm text-warning">Edit</a>
                                    <form method="POST" action="{{ route('laporan-operasional.destroy', $l) }}" class="d-inline"
                                          onsubmit="return confirm('Hapus laporan ini beserta seluruh datanya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-sm text-danger">Hapus</button>
                                    </form>
                                </td>
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