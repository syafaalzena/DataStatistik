<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Operasional - {{ $laporan->pelabuhan->nama ?? '-' }} - SIDKP</title>

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

        .laporan-sheet { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 28px; }
        .laporan-title { text-align: center; font-weight: 700; font-size: 18px; text-transform: uppercase; margin-bottom: 18px; }
        .meta-table td { padding: 3px 8px; font-size: 14px; }
        .section-heading { background: var(--clr-dark); color: #fff; font-weight: 700; padding: 6px 10px; font-size: 13px; text-transform: uppercase; }
        table.recap { width: 100%; border-collapse: collapse; margin-bottom: 22px; }
        table.recap th, table.recap td { border: 1px solid #cbd5e1; padding: 6px 8px; font-size: 13px; }
        table.recap th { background: #f1f5f9; font-weight: 600; text-align: center; }
        table.recap td.num { text-align: right; }
        table.recap tfoot td { font-weight: 700; background: #f8fafc; }

        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 600; border: none; padding: 10px 22px; text-decoration: none; display: inline-block; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }
        .btn-outline-secondary { border-radius: 8px; }

        @media print {
            .navbar, .no-print { display: none !important; }
            body { background: #fff; }
            .laporan-sheet { box-shadow: none; padding: 0; }
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
    <div class="d-flex align-items-center justify-content-between gap-3 mb-3 flex-wrap no-print">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('laporan-operasional.index') }}" class="back-btn">&larr;</a>
            <div>
                <h2 class="fw-bold mb-1">Rekap Laporan Operasional</h2>
                <p class="text-muted mb-0">{{ $laporan->pelabuhan->nama ?? '-' }} - {{ $laporan->nama_bulan }} {{ $laporan->tahun }}</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('laporan-operasional.edit', $laporan) }}" class="btn btn-outline-secondary">Edit</a>
            <button onclick="window.print()" class="btn-dark-custom">Cetak / PDF</button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success no-print">{{ session('success') }}</div>
    @endif

    <div class="laporan-sheet">
        <div class="laporan-title">Daftar Rekapitulasi Aktivitas Harian Pelabuhan Perikanan</div>

        <table class="meta-table mb-3">
            <tr><td><strong>Pelabuhan Perikanan</strong></td><td>:</td><td>{{ $laporan->pelabuhan->nama ?? '-' }}</td></tr>
            <tr><td><strong>Kabupaten/Kota</strong></td><td>:</td><td>{{ $laporan->pelabuhan->kabupatenIkan->nama_kabupaten ?? '-' }}</td></tr>
            <tr><td><strong>Bulan</strong></td><td>:</td><td>{{ $laporan->nama_bulan }} {{ $laporan->tahun }}</td></tr>
        </table>

        <div class="row">
            {{-- DATA ARMADA TANGKAP --}}
            <div class="col-lg-6">
                <div class="section-heading">Data Armada Tangkap</div>
                <table class="recap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ukuran Kapal (GT)</th>
                            <th>Jumlah Kapal (Unit)</th>
                            <th>Jumlah ABK (Org)</th>
                            <th>Kelengkapan Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan->armadaTangkap as $i => $a)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $a->ukuran_kapal }}</td>
                                <td class="num">{{ number_format($a->jumlah_kapal, 0, ',', '.') }}</td>
                                <td class="num">{{ number_format($a->jumlah_abk, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $a->status_dokumen ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-center">Total</td>
                            <td class="num">{{ number_format($laporan->total_kapal, 0, ',', '.') }}</td>
                            <td class="num">{{ number_format($laporan->total_abk, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- PRODUKSI IKAN DOMINAN --}}
            <div class="col-lg-6">
                <div class="section-heading">Jumlah Produksi Ikan Dominan & Nilai Produksi</div>
                <table class="recap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Ikan</th>
                            <th>Produksi (Kg)</th>
                            <th>Harga Ikan (Rp)</th>
                            <th>Nilai Produksi (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan->produksiIkan as $i => $p)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $p->jenis_ikan }}</td>
                                <td class="num">{{ number_format($p->produksi_kg, 0, ',', '.') }}</td>
                                <td class="num">{{ number_format($p->harga_rp, 0, ',', '.') }}</td>
                                <td class="num">{{ number_format($p->nilai_rp, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-center">Total</td>
                            <td class="num">{{ number_format($laporan->total_produksi_kg, 0, ',', '.') }}</td>
                            <td></td>
                            <td class="num">{{ number_format($laporan->total_nilai_produksi, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row">
            {{-- LOGISTIK --}}
            <div class="col-lg-6">
                <div class="section-heading">Logistik</div>
                <table class="recap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kebutuhan Logistik</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga (Rp)</th>
                            <th>Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan->logistik as $i => $lg)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $lg->nama_item }}</td>
                                <td class="num">{{ number_format($lg->jumlah, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $lg->satuan ?? '-' }}</td>
                                <td class="num">{{ $lg->harga_rp !== null ? number_format($lg->harga_rp, 0, ',', '.') : '-' }}</td>
                                <td class="num">{{ number_format($lg->total_rp, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-center">Total</td>
                            <td class="num">{{ number_format($laporan->total_logistik, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- PEMASARAN --}}
            <div class="col-lg-6">
                <div class="section-heading">Data Pemasaran</div>
                <table class="recap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Jenis Ikan</th>
                            <th>Quantity (Kg)</th>
                            <th>Tujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan->pemasaran as $i => $pm)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-center">{{ $pm->kategori }}</td>
                                <td>{{ $pm->jenis_ikan }}</td>
                                <td class="num">{{ number_format($pm->quantity_kg, 0, ',', '.') }}</td>
                                <td>{{ $pm->tujuan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-5 offset-md-7 text-center">
                <p class="mb-0">{{ $laporan->pelabuhan->kabupatenIkan->nama_kabupaten ?? '' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="mb-5">Pengelola Kepelabuhan Perikanan</p>
                <p class="fw-bold mb-0">{{ $laporan->nama_pengelola ?? '(...........................)' }}</p>
                @if ($laporan->nip_pengelola)
                    <p class="mb-0">NIP. {{ $laporan->nip_pengelola }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

</body>
</html>