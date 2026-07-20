<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Produksi Bulanan - Budidaya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --clr-bg: #F7F5F0;
            --clr-dark: #0f172a;
            --clr-blue-brand: #38bdf8;
            --clr-teal: #0d9488;
            --clr-teal-light: #ecfdf5;
        }

        body {
            background: var(--clr-bg);
            font-family: 'Inter', sans-serif;
            color: var(--clr-dark);
            font-size: 16px;
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
        .brand-logo-img { height: 30px; width: auto; object-fit: contain; }

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

        .page-title { font-size: 30px; font-weight: 800; margin-bottom: 4px; }
        .page-sub { color: #64748b; font-size: 15px; }

        .filter-card {
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
            padding: 22px;
            margin-bottom: 1.75rem;
        }

        .filter-card label { font-size: 14px; font-weight: 600; color: #475569; margin-bottom: 5px; }
        .filter-card .form-control, .filter-card .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 15px;
            padding: 9px 12px;
        }

        .btn-dark-custom {
            background: var(--clr-dark);
            color: #fff;
            border-radius: 8px;
            font-weight: 700;
            font-size: 15px;
            border: none;
            padding: 10px 22px;
            text-decoration: none;
        }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }

        .grand-total-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 16px;
            padding: 28px;
            text-align: center;
            color: #ffffff;
            margin-bottom: 1.75rem;
        }
        .grand-total-card .label {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: .03em;
            text-transform: uppercase;
            color: rgba(248, 250, 252, 0.65);
            margin-bottom: 8px;
        }
        .grand-total-card .value {
            font-size: 38px;
            font-weight: 800;
        }

        .kab-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            padding: 24px 26px;
            margin-bottom: 20px;
        }

        .kab-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 14px;
            margin-bottom: 16px;
            border-bottom: 2px solid #f1f5f9;
        }

        .kab-card-head h5 {
            font-weight: 800;
            font-size: 19px;
            margin: 0;
            color: var(--clr-dark);
        }

        .kab-total-pill {
            background: var(--clr-teal-light);
            color: var(--clr-teal);
            font-weight: 700;
            font-size: 14px;
            padding: 6px 14px;
            border-radius: 999px;
        }

        .rekap-table {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eef0e8;
        }
        .rekap-table table { margin-bottom: 0; }
        .rekap-table thead th {
            background: var(--clr-dark);
            color: #f8fafc;
            font-weight: 700;
            font-size: 13.5px;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 12px 16px;
            border-bottom: none;
        }
        .rekap-table tbody td {
            padding: 12px 16px;
            font-size: 15.5px;
        }
        .rekap-table tbody tr:nth-child(odd) { background: #fafbfc; }
        .rekap-table tbody tr:hover { background: #f0fdfa; }
        .rekap-table tbody tr:not(:last-child) td { border-bottom: 1px solid #f1f5f9; }

        .produksi-badge {
            display: inline-block;
            background: #ecfeff;
            color: #0e7490;
            font-weight: 700;
            font-size: 14.5px;
            padding: 4px 12px;
            border-radius: 8px;
        }

        .rekap-table .row-total td {
            background: #f1f5f9;
            font-weight: 800;
            font-size: 15.5px;
        }
        .rekap-table .row-total .produksi-badge {
            background: var(--clr-dark);
            color: #fff;
        }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #94a3b8;
            font-size: 16px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="brand-wrapper">
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('budidaya.index') }}" class="back-btn">
                <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
            </a>
            <div>
                <div class="page-title">Rekap Produksi Bulanan</div>
                <div class="page-sub">Rentang bulan bebas.</div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('budidaya.rekapBulanan') }}" class="filter-card">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-3">
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
            <div class="col-6 col-md-2">
                <label>Dari bulan</label>
                <select name="bulan_awal" class="form-select">
                    @foreach (['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $label)
                        <option value="{{ $val }}" {{ (string)$bulanAwal === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label>Dari tahun</label>
                <input type="number" name="tahun_awal" value="{{ $tahunAwal }}" class="form-control">
            </div>
            <div class="col-6 col-md-2">
                <label>Sampai bulan</label>
                <select name="bulan_akhir" class="form-select">
                    @foreach (['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $label)
                        <option value="{{ $val }}" {{ (string)$bulanAkhir === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label>Sampai tahun</label>
                <input type="number" name="tahun_akhir" value="{{ $tahunAkhir }}" class="form-control">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn-dark-custom w-100">Tampilkan</button>
            </div>
        </div>
    </form>

    <div class="grand-total-card">
        <div class="label">Total Produksi Provinsi (kg)</div>
        <div class="value">{{ number_format($grandTotal) }}</div>
    </div>

        <a href="{{ route('budidaya.rekapBulanan.export', request()->query()) }}" class="btn-dark-custom">
            Unduh Excel
        </a>
        <a href="{{ route('budidaya.rekapBulanan.exportPdf', request()->query()) }}" class="btn btn-danger">
            Unduh PDF
        </a>


    @forelse ($rekap as $kab)
        <div class="kab-card">
            <div class="kab-card-head">
                <h5>{{ $kab['kabupaten'] }}</h5>
                <span class="kab-total-pill">{{ number_format($kab['total_kabupaten']) }} kg</span>
            </div>
            <div class="rekap-table">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Jenis Ikan</th>
                            <th class="text-end">Produksi (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kab['per_komoditas'] as $k)
                            <tr>
                                <td>{{ $k['komoditas'] }}</td>
                                <td class="text-end"><span class="produksi-badge">{{ number_format($k['total']) }}</span></td>
                            </tr>
                        @endforeach
                        <tr class="row-total">
                            <td>Total {{ $kab['kabupaten'] }}</td>
                            <td class="text-end"><span class="produksi-badge">{{ number_format($kab['total_kabupaten']) }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="empty-state">Tidak ada data produksi pada rentang yang dipilih.</div>
    @endforelse

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>