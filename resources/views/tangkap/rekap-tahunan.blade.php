<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Data Tahunan - Tangkap Provinsi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --clr-bg: #F7F5F0; --clr-dark: #0f172a; --clr-blue-brand: #38bdf8; --clr-teal: #0d9488; --clr-teal-light: #ecfdf5; }
        body { background: var(--clr-bg); font-family: 'Inter', sans-serif; color: var(--clr-dark); font-size: 16px; }
        .navbar { background: var(--clr-dark); color: white; padding: 14px 0; box-shadow: 0 4px 12px rgba(15,23,42,.05); margin-bottom: 1.5rem; }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-text { font-weight: bold; font-size: 26px; color: #fff; }
        .back-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
        .back-btn:hover { background: #0f172a; color: #fff; }
        .btn-logout-icon { background: transparent; border: 1.5px solid rgba(248,250,252,.25); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }
        .page-title { font-size: 30px; font-weight: 800; margin-bottom: 4px; }
        .page-sub { color: #64748b; font-size: 15px; }
        .filter-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 22px; margin-bottom: 1.75rem; }
        .filter-card label { font-size: 14px; font-weight: 600; color: #475569; margin-bottom: 5px; }
        .filter-card .form-control, .filter-card .form-select { border-radius: 8px; border: 1px solid #e2e8f0; font-size: 15px; padding: 9px 12px; }
        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 700; font-size: 15px; border: none; padding: 10px 22px; text-decoration: none; display: inline-block; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }

        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 1.75rem; }
        @media (max-width: 992px) { .stats-row { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .stats-row { grid-template-columns: 1fr; } }
        .grand-total-card { background: linear-gradient(145deg, #1e293b, #0f172a); border-radius: 16px; padding: 24px; text-align: center; color: #fff; }
        .grand-total-card .label { font-size: 13px; font-weight: 600; letter-spacing: .03em; text-transform: uppercase; color: rgba(248,250,252,.65); margin-bottom: 8px; }
        .grand-total-card .value { font-size: 30px; font-weight: 800; }
        .stat-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,.04); }
        .stat-card .label { font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .03em; margin-bottom: 8px; }
        .stat-card .value { font-size: 22px; font-weight: 800; color: var(--clr-dark); }
        .stat-card .sub { font-size: 13px; color: #94a3b8; margin-top: 4px; }

        .kab-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,.05); padding: 24px 26px; margin-bottom: 20px; }
        .kab-card-head { display: flex; align-items: center; justify-content: space-between; padding-bottom: 14px; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; }
        .kab-card-head h5 { font-weight: 800; font-size: 19px; margin: 0; color: var(--clr-dark); }
        .kab-total-pill { background: var(--clr-teal-light); color: var(--clr-teal); font-weight: 700; font-size: 14px; padding: 6px 14px; border-radius: 999px; }

        .rekap-table { border-radius: 12px; overflow: hidden; border: 1px solid #eef0e8; }
        .rekap-table table { margin-bottom: 0; }
        .rekap-table thead th { background: var(--clr-dark); color: #f8fafc; font-weight: 700; font-size: 13.5px; text-transform: uppercase; letter-spacing: .04em; padding: 12px 16px; border-bottom: none; white-space: nowrap; }
        .rekap-table tbody td { padding: 12px 16px; font-size: 15px; }
        .rekap-table tbody tr:nth-child(odd) { background: #fafbfc; }
        .rekap-table tbody tr:not(:last-child) td { border-bottom: 1px solid #f1f5f9; }
        .rekap-table .row-total td { background: #f1f5f9; font-weight: 800; }

        .empty-state { text-align: center; padding: 48px 20px; color: #94a3b8; font-size: 16px; background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); }
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('tangkap.produksi.index') }}" class="back-btn">&larr;</a>
            <div>
                <div class="page-title">Rekap Data Tahunan</div>
                <div class="page-sub">RTP, kapal, API, dan nelayan seluruh kabupaten per tahun.</div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('tangkap.rekap.tahunan') }}" class="filter-card">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-5">
                <label>Kabupaten/Kota</label>
                <select name="kabupaten_id" class="form-select">
                    <option value="">Semua Kabupaten/Kota</option>
                    @foreach ($kabupatens as $kab)
                        <option value="{{ $kab->id }}" {{ (string)$kabupatenId === (string)$kab->id ? 'selected' : '' }}>
                            {{ $kab->nama_kabupaten }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-4">
                <label>Tahun</label>
                <input type="number" name="tahun" value="{{ $tahunAwal }}" class="form-control">
            </div>
            <div class="col-6 col-md-3">
                <button type="submit" class="btn-dark-custom w-100">Tampilkan</button>
            </div>
        </div>
    </form>

    {{-- Statistik ini hanya tampil di web, TIDAK ikut ke Excel/PDF --}}
    <div class="stats-row">
        <div class="grand-total-card">
            <div class="label">Total Nelayan</div>
            <div class="value">{{ number_format($grandNelayan, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Total RTP</div>
            <div class="value">{{ number_format($grandRtp, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Total Kapal</div>
            <div class="value">{{ number_format($grandKapal, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Nelayan Terbanyak</div>
            <div class="value">{{ $kabupatenTertinggi['kabupaten'] ?? '-' }}</div>
            <div class="sub">{{ isset($kabupatenTertinggi) ? number_format($kabupatenTertinggi['total_nelayan'], 0, ',', '.') . ' nelayan' : '' }}</div>
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ route('tangkap.rekap.tahunan.export', request()->query()) }}" class="btn-dark-custom" style="margin-right: 10px;">Unduh Excel</a>
        <a href="{{ route('tangkap.rekap.tahunan.exportPdf', request()->query()) }}" class="btn btn-danger" style="font-weight: 600;">Unduh PDF</a>
    </div>

    @forelse ($rekap as $kab)
    <div class="kab-card">
        <div class="kab-card-head">
            <h5>{{ $kab['kabupaten'] }}</h5>
            <span class="kab-total-pill">{{ number_format($kab['total_nelayan'], 0, ',', '.') }} nelayan</span>
        </div>
        <div class="rekap-table" style="overflow-x:auto;">
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th>Pelabuhan</th>
                        <th class="text-end">RTP</th>
                        <th class="text-end">Kapal</th>
                        <th class="text-end">API</th>
                        <th class="text-end">Nelayan Buruh</th>
                        <th class="text-end">Nelayan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kab['per_pelabuhan'] as $p)
                        <tr>
                            <td>{{ $p['pelabuhan'] }}</td>
                            <td class="text-end">{{ number_format($p['rtp'], 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($p['kapal'], 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($p['api'], 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($p['nelayan_buruh'], 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($p['nelayan'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="row-total">
                        <td>Total {{ $kab['kabupaten'] }}</td>
                        <td class="text-end">{{ number_format($kab['total_rtp'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($kab['total_kapal'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($kab['total_api'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($kab['total_nelayan_buruh'], 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($kab['total_nelayan'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @empty
        <div class="empty-state">Tidak ada data tahunan untuk tahun yang dipilih.</div>
    @endforelse

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>