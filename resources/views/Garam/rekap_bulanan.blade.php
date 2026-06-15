<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --clr-sea:    #0d1b2a;
            --clr-sea-lt: #E8F5F6;
            --clr-salt:   #F7F5F0;
            --clr-stone:  #3D3D3A;
            --clr-mist:   #8A8A85;
            --clr-border: #E2DED6;
            --clr-white:  #FFFFFF;
            --clr-gold:   #C68B2F;
            --radius-card: 14px;
            --shadow-card: 0 2px 16px rgba(26,107,114,.08);
            --font-base:  'Plus Jakarta Sans', sans-serif;
            --font-mono:  'DM Mono', monospace;
        }
        body { background: var(--clr-salt); font-family: var(--font-base); color: var(--clr-stone); }

        .page-header {
            background: linear-gradient(135deg, var(--clr-sea) 0%, #0F4A50 100%);
            border-radius: 0 0 28px 28px;
            padding: 2rem 0 2.4rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(105deg, transparent, transparent 38px, rgba(255,255,255,.04) 38px, rgba(255,255,255,.04) 39px);
            pointer-events: none;
        }
        .page-header h2 { color: #fff; font-size: 1.75rem; font-weight: 700; margin: .75rem 0 .25rem; }
        .page-header .subtitle { color: rgba(255,255,255,.65); font-size: .88rem; margin: 0; }
        .btn-back {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            color: #fff; border-radius: 8px; font-size: .85rem;
            padding: .4rem .9rem; text-decoration: none;
            display: inline-flex; align-items: center; gap: .35rem;
        }
        .btn-back:hover { background: rgba(255,255,255,.22); color: #fff; }

        .data-card {
            background: var(--clr-white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            border: 1px solid var(--clr-border);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .data-card-header {
            padding: 1.25rem 1.5rem 1rem;
            border-bottom: 1px solid var(--clr-border);
            display: flex; align-items: center; gap: .6rem;
        }
        .card-icon {
            width: 36px; height: 36px; border-radius: 9px;
            background: var(--clr-sea-lt);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .data-card-header h5 { font-size: 1rem; font-weight: 700; margin: 0; }
        .data-card-body { padding: 1.25rem 1.5rem 1.5rem; }

        .table { font-size: .875rem; margin-bottom: 0; }
        .table thead th {
            background: var(--clr-sea); color: #fff;
            font-weight: 600; font-size: .78rem;
            text-transform: uppercase; letter-spacing: .6px;
            padding: .75rem 1rem; border: none; white-space: nowrap;
        }
        .table thead th:first-child { border-radius: 8px 0 0 0; }
        .table thead th:last-child  { border-radius: 0 8px 0 0; }
        .table tbody tr { border-bottom: 1px solid var(--clr-border); transition: background .15s; }
        .table tbody tr:last-child { border-bottom: none; }
        .table tbody tr:hover { background: var(--clr-sea-lt); }
        .table tbody td { padding: .7rem 1rem; vertical-align: middle; border: none; }

        .badge-tahun {
            display: inline-block; background: var(--clr-sea-lt); color: var(--clr-sea);
            border-radius: 6px; padding: .2rem .55rem;
            font-family: var(--font-mono); font-size: .8rem; font-weight: 500;
        }
        .cell-harga { font-weight: 500; color: var(--clr-gold); }

        .filter-form select {
            border: 1px solid var(--clr-border); border-radius: 8px;
            font-size: .88rem; padding: .45rem .85rem;
            font-family: var(--font-base); color: var(--clr-stone);
        }
        .filter-form select:focus { outline: none; border-color: var(--clr-sea); }
        .filter-form button {
            background: var(--clr-sea); color: #fff; border: none;
            border-radius: 8px; font-size: .85rem; font-weight: 600;
            padding: .45rem 1rem; cursor: pointer;
        }
    </style>
</head>
<body>

<div class="page-header">
    <div class="container">
        <a href="{{ route('kabupaten.index') }}" class="btn-back">← Kembali</a>
        <h2>Rekap Bulanan Provinsi</h2>
        <p class="subtitle">Total produksi garam seluruh kabupaten per bulan</p>
    </div>
</div>

<div class="container pb-5">

    {{-- FILTER TAHUN --}}
    <form method="GET" class="filter-form d-flex align-items-center gap-2 mb-4">
        <label style="font-weight:600; font-size:.88rem;">Pilih Tahun:</label>
        <select name="tahun">
            @foreach($tahunList as $t)
                <option value="{{ $t }}" {{ $t == $tahunDipilih ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
        <button type="submit">Tampilkan</button>
    </form>

    <div class="row mb-4">
    <div class="col-md-4">
        <div class="data-card">
            <div class="data-card-body text-center">
                <h6 class="text-muted">Total Data</h6>
                <h3 class="fw-bold">{{ $data->count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="data-card">
            <div class="data-card-body text-center">
                <h6 class="text-muted">Total Produksi</h6>
                <h3 class="fw-bold">{{ $data->sum('produksi') }} Ton</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="data-card">
            <div class="data-card-body text-center">
                <h6 class="text-muted">Total Harga</h6>
                <h3 class="fw-bold">
                    Rp {{ number_format($data->sum('harga'), 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
</div>

    {{-- GRAFIK --}}
    <div class="data-card">
        <div class="data-card-header">
            <div class="card-icon">📈</div>
            <h5>Grafik Produksi Bulanan {{ $tahunDipilih }}</h5>
        </div>
        <div class="data-card-body">
            <canvas id="grafikBulanan" height="100"></canvas>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="data-card">
        <div class="data-card-header">
            <div class="card-icon">📅</div>
            <h5>Data Bulanan Tahun {{ $tahunDipilih }}</h5>
        </div>
        <div class="data-card-body">
            @if($data->isEmpty())
                <p class="text-muted text-center py-4">Belum ada data untuk tahun ini.</p>
            @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kabupaten</th>
                            <th>Bulan</th>
                            <th>Jenis Produksi</th>
                            <th>Produksi (Ton)</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        @endphp
                        @foreach($data as $d)
                        <tr>
                            <td>{{ $d->kabupaten->nama_kabupaten }}</td>
                            <td><span class="badge-tahun">{{ $namaBulan[$d->bulan] }}</span></td>
                            <td>{{ $d->jenis_produksi }}</td>
                            <td>{{ $d->produksi }}</td>
                            <td class="cell-harga">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

</div>

<script>
    const labels = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const dataGrafik = @json($dataGrafik);

    const produksiPerBulan = Array(12).fill(0);
    dataGrafik.forEach(d => { produksiPerBulan[d.bulan - 1] = d.total_produksi; });

    new Chart(document.getElementById('grafikBulanan'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Produksi (Ton)',
                data: produksiPerBulan,
                backgroundColor: 'rgba(13, 27, 42, 0.75)',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#E2DED6' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>