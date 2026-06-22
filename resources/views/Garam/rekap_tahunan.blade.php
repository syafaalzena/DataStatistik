<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Tahunan</title>
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
        
        .page-header h2 { color: #fff; font-size: 1.75rem; font-weight: 700; margin: 0; }
        .page-header .subtitle { color: rgba(255,255,255,.65); font-size: .88rem; margin: 0; }
        
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

        .badge-bulan {
            display: inline-block; background: var(--clr-sea-lt); color: var(--clr-sea);
            border-radius: 6px; padding: .2rem .55rem;
            font-family: var(--font-base); font-size: .8rem; font-weight: 500;
        }
        .cell-harga { font-family: var(--font-base); font-weight: 500; color: var(--clr-gold); }

        .filter-card {
            background: var(--clr-white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            border: 1px solid var(--clr-border);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .filter-label { font-weight: 600; font-size: .85rem; color: var(--clr-mist); white-space: nowrap; }
        .filter-select {
            border: 1px solid var(--clr-border);
            border-radius: 8px;
            font-size: .88rem;
            padding: .45rem .85rem;
            font-family: var(--font-base);
            color: var(--clr-stone);
            background: var(--clr-salt);
        }
        .filter-select:focus { outline: none; border-color: var(--clr-sea); }

        .empty-state {
            text-align: center; padding: 2.5rem 1rem; color: var(--clr-mist);
        }
        .empty-state .empty-icon { font-size: 2rem; margin-bottom: .5rem; opacity: .5; }
        .empty-state p { font-size: .9rem; margin: 0; }

        .btn-back {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 30px;
            text-decoration: none;
            transition: all .2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
            flex-shrink: 0;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            background: #0f172a;
            border-color: #0f172a;
        }

        .btn-back:hover img {
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body>

<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('kabupaten.index') }}" class="btn-back">
                <img src="{{ asset('images/back.png') }}" alt="Kembali" width="20" height="20" style="transition: filter 0.2s;">
            </a>
            
            <div>
                <h2 class="m-0">Rekap Tahunan Provinsi</h2>
                <p class="subtitle mt-1">Total produksi garam seluruh kabupaten per tahun</p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">

    {{-- FILTER --}}
    <form method="GET">
        <div class="filter-card">
            <span class="filter-label">Filter:</span>

            <datalist id="tahun-list">
                @foreach($tahunList as $t)
                    <option value="{{ $t }}">
                @endforeach
            </datalist>
            <input type="text"
                name="tahun"
                list="tahun-list"
                value="{{ $tahunDipilih }}"
                class="filter-select"
                placeholder="Pilih/ketik tahun"
                onchange="this.form.submit()">

            <select name="kabupaten_id" class="filter-select" onchange="this.form.submit()">
                <option value="">-- Semua Kabupaten --</option>
                @foreach($kabupatenList as $kab)
                    <option value="{{ $kab->id }}" {{ $kab->id == $kabupatenDipilih ? 'selected' : '' }}>
                        {{ $kab->nama_kabupaten }}
                    </option>
                @endforeach
            </select>
        </div>
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
                    <h6 class="text-muted">Total Production</h6>
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
            <div class="card-icon">
                <img src="{{ asset('images/statistik.png') }}" alt="Statistik" width="20" height="20">
            </div>
            <h5>Grafik Total Produksi per Kabupaten — {{ $tahunDipilih }}</h5>
        </div>
        <div class="data-card-body">
            @if($dataGrafik->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <p>Belum ada data untuk ditampilkan.</p>
                </div>
            @else
                <canvas id="grafikTahunan"></canvas>
            @endif
        </div>
    </div>

    {{-- TABEL --}}
    <div class="data-card">
        <div class="data-card-header">
            <div class="card-icon">
                <img src="{{ asset('images/kalender.png') }}" alt="Kalender" width="20" height="20">
            </div>
            <h5>
                Detail Data Tahun {{ $tahunDipilih }}
                @if($kabupatenDipilih)
                    — {{ $kabupatenList->find($kabupatenDipilih)?->nama_kabupaten }}
                @else
                    — Semua Kabupaten
                @endif
            </h5>
        </div>
        <div class="data-card-body">
            @if($data->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <p>Belum ada data untuk filter ini.</p>
                </div>
            @else
            <div class="table-responsive">
                @php
                    $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                @endphp

                <a href="{{ route('export.tahunan', ['tahun' => $tahunDipilih]) }}" 
   class="btn btn-primary">
    Download Rekap Tahunan
</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kabupaten</th>
                            <th>Bulan</th>
                            <th>Jenis Produksi</th>
                            <th>Produksi (Ton)</th>
                            <th>Lokasi</th>
                            <th>Jumlah Petani</th>
                            <th>Nama Kelompok</th>
                            <th>Harga (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        <tr>
                            <td>{{ $d->kabupaten->nama_kabupaten }}</td>
                            <td><span class="badge-bulan">{{ $namaBulan[$d->bulan] }}</span></td>
                            <td>{{ $d->jenis_produksi }}</td>
                            <td>{{ $d->produksi }}</td>
                            <td>{{ $d->lokasi }}</td>
                            <td>{{ $d->jumlah_petani }}</td>
                            <td>{{ $d->nama_kelompok }}</td>
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

@if($dataGrafik->isNotEmpty())
<script>
    const dataGrafik = @json($dataGrafik);
    const labels     = dataGrafik.map(d => d.kabupaten.nama_kabupaten);
    const produksi   = dataGrafik.map(d => d.total_produksi);

    new Chart(document.getElementById('grafikTahunan'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Produksi (Ton)',
                data: produksi,
                backgroundColor: 'rgba(13, 27, 42, 0.7)',
                borderRadius: 6,
                maxBarThickness: 80,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} Ton`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#E2DED6' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>