<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Tahunan Laporan Operasional - SIDKP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --clr-bg: #F7F5F0; --clr-dark: #0f172a; --clr-blue-brand: #38bdf8; }
        body { background: var(--clr-bg); font-family: 'Inter', sans-serif; color: var(--clr-dark); }
        .navbar { background: var(--clr-dark); color: white; padding: 14px 0; margin-bottom: 1.5rem; }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-text { font-weight: bold; font-size: 26px; color: #fff; }
        .back-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
        .back-btn:hover { background: #0f172a; color: #fff; }
        .btn-logout-icon { background: transparent; border: 1.5px solid rgba(248,250,252,.25); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }

        .panel-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 24px; }
        .form-select { border-radius: 8px; border: 1px solid #e2e8f0; }

        .summary-box { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
        .summary-card { background: #f1f5f9; border-radius: 12px; padding: 16px 22px; flex: 1; min-width: 200px; }
        .summary-card .label { font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; }
        .summary-card .value { font-size: 22px; font-weight: 700; margin-top: 4px; }

        .kabupaten-heading { background: var(--clr-dark); color: #fff; font-weight: 700; padding: 8px 14px; border-radius: 8px; margin: 22px 0 10px 0; font-size: 14px; text-transform: uppercase; }
        table.recap { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.recap th, table.recap td { border: 1px solid #cbd5e1; padding: 6px 8px; font-size: 13px; }
        table.recap th { background: #f1f5f9; font-weight: 600; text-align: center; }
        table.recap td.num { text-align: right; }
        table.recap tbody tr:hover { background: #f8fafc; }
        table.recap a { text-decoration: none; font-weight: 600; }

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
            <a href="{{ route('laporan-operasional.pilih-kabupaten') }}" class="back-btn">&larr;</a>
            <div>
                <h2 class="fw-bold mb-1">Rekap Tahunan Laporan Operasional</h2>
                <p class="text-muted mb-0">Semua kabupaten & pelabuhan, dikelompokkan per tahun.</p>
            </div>
        </div>
        <button onclick="window.print()" class="btn btn-outline-secondary">Cetak / PDF</button>
    </div>

    <form method="GET" class="d-flex align-items-center gap-2 mb-4 no-print" style="max-width: 260px;">
        <label class="fw-semibold">Tahun:</label>
        <select name="tahun" class="form-select" onchange="this.form.submit()">
            @foreach ($tahunTersedia as $t)
                <option value="{{ $t }}" @selected($t == $tahun)>{{ $t }}</option>
            @endforeach
        </select>
    </form>

    <div class="panel-card">
        <div class="summary-box">
            <div class="summary-card">
                <div class="label">Tahun</div>
                <div class="value">{{ $tahun }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Produksi (Kg)</div>
                <div class="value">{{ number_format($grandTotalProduksi, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Nilai Produksi (Rp)</div>
                <div class="value">{{ number_format($grandTotalNilai, 0, ',', '.') }}</div>
            </div>
        </div>

        @forelse ($laporans as $namaKabupaten => $group)
            <div class="kabupaten-heading">{{ $namaKabupaten }}</div>
            <table class="recap">
                <thead>
                    <tr>
                        <th>Pelabuhan</th>
                        <th>Bulan</th>
                        <th>Jumlah Kapal</th>
                        <th>Jumlah ABK</th>
                        <th>Produksi (Kg)</th>
                        <th>Nilai Produksi (Rp)</th>
                        <th>Total Logistik (Rp)</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($group as $l)
                        <tr>
                            <td>{{ $l->pelabuhan->nama ?? '-' }}</td>
                            <td>{{ $l->nama_bulan }}</td>
                            <td class="num">{{ number_format($l->total_kapal, 0, ',', '.') }}</td>
                            <td class="num">{{ number_format($l->total_abk, 0, ',', '.') }}</td>
                            <td class="num">{{ number_format($l->total_produksi_kg, 0, ',', '.') }}</td>
                            <td class="num">{{ number_format($l->total_nilai_produksi, 0, ',', '.') }}</td>
                            <td class="num">{{ number_format($l->total_logistik, 0, ',', '.') }}</td>
                            <td class="no-print"><a href="{{ route('laporan-operasional.show', $l) }}">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @empty
            <div class="text-center text-muted py-4">Belum ada laporan untuk tahun {{ $tahun }}.</div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>