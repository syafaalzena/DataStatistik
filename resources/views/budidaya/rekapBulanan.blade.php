<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan Budidaya Provinsi Aceh</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Croissant+One&family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --clr-bg: #F7F5F0;
            --clr-dark: #0f172a;
            --clr-blue-brand: #38bdf8;
        }

        body {
            background: var(--clr-bg);
            font-family: 'Inter', sans-serif;
            color: var(--clr-dark);
        }

        .navbar {
            background: var(--clr-dark);
            color: white;
            padding: 14px 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            margin-bottom: 1.5rem;
        }

        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-text { font-weight: bold; font-size: 26px; color: #ffffff; }
        .brand-logo-svg { width: 32px; height: 32px; fill: var(--clr-blue-brand); }

        .back-btn {
            width: 48px; height: 48px;
            display: flex; align-items: center; justify-content: center;
            background: #ffffff; border: 1px solid #e2e8f0; border-radius: 30px;
            text-decoration: none; transition: all .2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
        }
        .back-btn:hover { transform: translateY(-2px); background: #0f172a; border-color: #0f172a; }
        .back-btn:hover img { filter: brightness(0) invert(1); }

        .btn-logout-icon {
            background: transparent;
            border: 1.5px solid rgba(248, 250, 252, 0.25);
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.25s ease;
        }
        .btn-logout-icon img { width: 20px; height: 20px; filter: brightness(0) invert(1); transition: transform 0.25s ease; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }
        .btn-logout-icon:hover img { transform: translateX(2px); filter: none; }

        .filter-card {
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
            padding: 20px;
        }

        .filter-card label { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 4px; }
        .filter-card .form-select, .filter-card .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .btn-dark-custom {
            background: var(--clr-dark);
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            padding: 10px 24px;
        }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }

        .btn-excel {
            background: #15803d;
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            padding: 10px 24px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-excel:hover { background: #166534; color: #fff; }

        .rekap-table {
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .rekap-table table { margin-bottom: 0; }
        .rekap-table thead th {
            background: var(--clr-dark);
            color: #fff;
            font-weight: 600;
            border: none;
            font-size: 13px;
        }
        .rekap-table td { vertical-align: middle; font-size: 14px; }
        .rekap-table .row-kabupaten td {
            background: #f1f5f9;
            font-weight: 700;
        }
        .rekap-table .row-total td {
            font-weight: 700;
            background: #f8fafc;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="brand-wrapper">
            <span class="brand-text">SIDKP</span>
            <svg class="brand-logo-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2,12C2,12 5,7 12,7C15.5,7 18.5,8.5 20.5,10.5L22,9V15L20.5,13.5C18.5,15.5 15.5,17 12,17C5,17 2,12 2,12M12,9A3,3 0 1,0 12,15A3,3 0 1,0 12,9Z"/>
            </svg>
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

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('kabupaten_ikans.index') }}" class="back-btn">
            <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
        </a>
        <div>
            <h2 class="fw-bold mb-1">Rekap Bulanan Budidaya Provinsi Aceh</h2>
            <p class="text-muted mb-0">Pilih rentang bulan dan kabupaten untuk melihat rekap produksi.</p>
        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('budidaya.rekapBulanan') }}" class="filter-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-6 col-md-2">
                <label>Bulan Awal</label>
                <select name="bulan_awal" class="form-select">
                    @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ $bulanAwal == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label>Tahun Awal</label>
                <select name="tahun_awal" class="form-select">
                    @foreach(range(now()->year - 5, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ $tahunAwal == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label>Bulan Akhir</label>
                <select name="bulan_akhir" class="form-select">
                    @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ $bulanAkhir == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label>Tahun Akhir</label>
                <select name="tahun_akhir" class="form-select">
                    @foreach(range(now()->year - 5, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ $tahunAkhir == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <label>Kabupaten</label>
                <select name="kabupaten_id" class="form-select">
                    <option value="">Semua Kabupaten</option>
                    @foreach($kabupatens as $kab)
                        <option value="{{ $kab->id }}" {{ (string) $kabupatenId === (string) $kab->id ? 'selected' : '' }}>
                            {{ $kab->nama_kabupaten }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-1 d-grid">
                <button type="submit" class="btn-dark-custom">Tampilkan</button>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('budidaya.rekapBulanan.export', request()->query()) }}" class="btn-excel">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>
                Download Excel
            </a>
        </div>
    </form>

    {{-- HASIL REKAP --}}
    <div class="rekap-table">
        @if($rekap->isEmpty())
            <div class="empty-state">Tidak ada data produksi untuk periode dan kabupaten yang dipilih.</div>
        @else
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 25%">Kabupaten / Komoditas / Jenis Budidaya</th>
                        <th class="text-end" style="width: 20%">Total Produksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekap as $kab)
                        <tr class="row-kabupaten">
                            <td>{{ $kab['kabupaten']->nama_kabupaten ?? '-' }}</td>
                            <td class="text-end">{{ number_format($kab['total'], 2) }}</td>
                        </tr>
                        @foreach($kab['komoditas_list'] as $kom)
                            @foreach($kom['jenis_list'] as $jenis)
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-muted">{{ $kom['komoditas']->nama_komoditas ?? '-' }}</span>
                                        &rarr; {{ $jenis['jenis']->nama_jenis ?? '-' }}
                                    </td>
                                    <td class="text-end">{{ number_format($jenis['total_produksi'], 2) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>