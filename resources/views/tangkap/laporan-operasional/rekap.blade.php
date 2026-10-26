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
        body { 
            background: var(--clr-bg); 
            font-family: 'Inter', sans-serif; 
            color: var(--clr-dark); 
        }
        .navbar { 
            background: var(--clr-dark); 
            color: white; padding: 14px 0; margin-bottom: 1.5rem; }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-logo-img { height: 40px; width: auto; }
        .brand-text { font-weight: bold; font-size: 26px; color: #fff; }
        .back-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
        .back-btn:hover { background: #0f172a; color: #fff; }
        .back-btn img { transition: filter .18s ease; }
        .back-btn:hover img { filter: brightness(0) invert(1); }
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

        .btn-dark-custom {
            background: var(--clr-dark);
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            padding: 10px 22px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>

<nav class="navbar no-print">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <img src="{{ asset('images/pancacita.png') }}" alt="Logo Pancacita" class="brand-logo-img">
            <span class="brand-text">SAMUDRA ACEH</span>
        </a>
        
    </div>
</nav>

<div class="container pb-5">
    <div class="d-flex align-items-center justify-content-between gap-3 mb-4 flex-wrap no-print">
        <div class="d-flex align-items-center gap-3">
            {{-- Tombol kembali: tujuan ditentukan dari parameter ?asal= (laporan / produksi) --}}
            <a href="{{ $urlKembali }}" class="back-btn">
                <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
            </a>
            <div>
                <h2 class="fw-bold mb-1">Rekap Tahunan Laporan Operasional</h2>
                <p class="text-muted mb-0">Semua kabupaten & pelabuhan, dikelompokkan per tahun.</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary">Cetak</button>
            <a href="{{ route('laporan-operasional.rekap.pdf', ['tahun' => $tahun, 'ukuran' => $ukuran, 'dari' => $dari, 'sampai' => $sampai]) }}" class="btn-dark-custom">PDF</a>
            <a href="{{ route('laporan-operasional.rekap.excel', ['tahun' => $tahun, 'ukuran' => $ukuran, 'dari' => $dari, 'sampai' => $sampai]) }}" class="btn-dark-custom">Excel</a>
        </div>
    </div>

    <form method="GET" class="row g-2 align-items-end mb-4 no-print">
        {{-- Bawa asal supaya tombol back tetap benar setelah filter diterapkan --}}
        <input type="hidden" name="asal" value="{{ $asal }}">

        <div class="col-auto">
            <label class="small fw-semibold">Tahun</label>
            <select name="tahun" class="form-select">
                @foreach ($tahunTersedia as $t)
                    <option value="{{ $t }}" @selected($t == $tahun)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label class="small fw-semibold">Ukuran Kapal (GT)</label>
            <select name="ukuran" class="form-select">
                <option value="">Semua ukuran</option>
                @foreach ($ukuranTersedia as $u)
                    <option value="{{ $u }}" @selected($u === $ukuran)>{{ $u }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label class="small fw-semibold">Berangkat dari</label>
            <input type="date" name="dari" value="{{ $dari }}" class="form-control">
        </div>
        <div class="col-auto">
            <label class="small fw-semibold">sampai</label>
            <input type="date" name="sampai" value="{{ $sampai }}" class="form-control">
        </div>
        <div class="col-auto d-flex gap-2">
            <button type="submit" class="btn btn-dark">Terapkan</button>
            <a href="{{ route('laporan-operasional.rekap', ['tahun' => $tahun, 'asal' => $asal]) }}" class="btn btn-outline-secondary">Reset</a>
        </div>
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
            <div class="summary-card">
                <div class="label">Jumlah Trip</div>
                <div class="value">{{ $totalTrip }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Kapal Berbeda</div>
                <div class="value">{{ $totalKapal }}</div>
            </div>
        </div>

        @if ($keterangan)
            <div class="small text-muted mb-3">Filter aktif: {{ $keterangan }}</div>
        @endif

        @forelse ($laporans as $namaKabupaten => $group)
            <div class="kabupaten-heading">{{ $namaKabupaten }}</div>
            <div class="table-responsive">
                <table class="recap">
                    <thead>
                        <tr>
                            <th>Pelabuhan</th>
                            <th>Bulan</th>
                            <th>Nama Kapal</th>
                            <th>Ukuran (GT)</th>
                            <th>Berangkat</th>
                            <th>Pulang</th>
                            <th>ABK</th>
                            <th>Produksi (Kg)</th>
                            <th>Nilai Produksi (Rp)</th>
                            <th>Logistik (Rp)</th>
                            <th class="no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group as $r)
                            <tr>
                                <td>{{ $r->pelabuhan }}</td>
                                <td>{{ $r->bulan }}</td>
                                <td>{{ $r->nama_kapal }}</td>
                                <td class="text-center">{{ $r->ukuran }}</td>
                                <td class="text-center">{{ $r->berangkat }}</td>
                                <td class="text-center">{{ $r->pulang }}</td>
                                <td class="num">{{ number_format($r->abk, 0, ',', '.') }}</td>
                                <td class="num">{{ number_format($r->produksi_kg, 0, ',', '.') }}</td>
                                <td class="num">{{ number_format($r->nilai_rp, 0, ',', '.') }}</td>
                                <td class="num">{{ number_format($r->logistik_rp, 0, ',', '.') }}</td>
                                <td class="no-print"><a href="{{ route('laporan-operasional.show', $r->laporan_id) }}">Lihat</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-center">Subtotal {{ $namaKabupaten }}</td>
                            <td class="num">{{ number_format($group->sum('abk'), 0, ',', '.') }}</td>
                            <td class="num">{{ number_format($group->sum('produksi_kg'), 0, ',', '.') }}</td>
                            <td class="num">{{ number_format($group->sum('nilai_rp'), 0, ',', '.') }}</td>
                            <td class="num">{{ number_format($group->sum('logistik_rp'), 0, ',', '.') }}</td>
                            <td class="no-print"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                @if ($keterangan)
                    Tidak ada trip yang cocok dengan filter ini di tahun {{ $tahun }}.
                @else
                    Belum ada laporan untuk tahun {{ $tahun }}.
                @endif
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>