<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tahunan Tangkap - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --clr-bg: #F7F5F0; --clr-dark: #0f172a; --clr-blue-brand: #38bdf8; }
        body { background: var(--clr-bg); font-family: 'Inter', sans-serif; color: var(--clr-dark); }
        .navbar { background: var(--clr-dark); color: white; padding: 14px 0; box-shadow: 0 4px 12px rgba(15,23,42,.05); margin-bottom: 1.5rem; }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-text { font-weight: bold; font-size: 26px; color: #fff; }
        .back-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
        .back-btn:hover { background: #0f172a; color: #fff; }
        .btn-logout-icon { background: transparent; border: 1.5px solid rgba(248,250,252,.25); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }
        .kab-badge { display: inline-block; background: #e0f2fe; color: #0369a1; font-weight: 600; font-size: 12px; padding: 4px 12px; border-radius: 20px; margin-bottom: 6px; }
        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 600; border: none; padding: 10px 22px; text-decoration: none; display: inline-block; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }
        .btn-outline-custom { background: #fff; color: var(--clr-dark); border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 600; padding: 10px 22px; text-decoration: none; display: inline-block; }
        .btn-outline-custom:hover { background: #f1f5f9; color: var(--clr-dark); }
        .tab-nav { display: flex; gap: 4px; background: #fff; border-radius: 10px; padding: 4px; box-shadow: 0 2px 8px rgba(0,0,0,.04); width: fit-content; }
        .tab-item { padding: 8px 18px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; color: #64748b; }
        .tab-item:hover { background: #f1f5f9; color: var(--clr-dark); }
        .tab-item.active { background: var(--clr-dark); color: #fff; }
        .tab-item.disabled { color: #cbd5e1; cursor: not-allowed; }
        .tab-item.disabled:hover { background: none; color: #cbd5e1; }
        .riwayat-table { border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04); background: #fff; }
        .riwayat-table table { margin-bottom: 0; }
        .riwayat-table thead th { background: var(--clr-dark); color: #fff; font-weight: 600; border: none; font-size: 13px; white-space: nowrap; }
        .riwayat-table td { vertical-align: middle; font-size: 13px; white-space: nowrap; }
        .btn-delete-sm { background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; }
        .btn-delete-sm:hover { text-decoration: underline; }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }
        .nelayan-total { font-weight: 700; color: #0369a1; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <span class="brand-text">SIDKP</span>
        </a>
        
    </div>
</nav>

<div class="container pb-5">

    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('tangkap.input', $kabupaten->id) }}" class="back-btn">&larr;</a>
        <div>
            <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
            <h2 class="fw-bold mb-1">Data Tahunan Tangkap</h2>
            <p class="text-muted mb-0">Rekapitulasi RTP, kapal, alat tangkap, dan nelayan per tahun.</p>
        </div>
    </div>

    @include('tangkap.partials.nav-tabs', ['kabupaten' => $kabupaten])

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex gap-2 flex-wrap mb-4">
        <a href="{{ route('tangkap.tahunan.create', $kabupaten->id) }}" class="btn-dark-custom">+ Tambah Data Tahunan</a>
        <a href="{{ route('tangkap.tahunan.rekap', $kabupaten->id) }}" class="btn-outline-custom">📊 Rekap / Export</a>
    </div>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari pelabuhan, jenis API, tahun...">
    </div>

    <div id="riwayatTahunan" class="riwayat-table mb-4">
        @if($dataTahunan->isEmpty())
            <div class="empty-state">Belum ada data tahunan untuk kabupaten ini. Klik "+ Tambah Data Tahunan" untuk mulai input.</div>
        @else
            <div id="tableWrapper" class="table-responsive">
            <table class="table table-hover text-center align-middle mb-0">
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataTahunan as $d)
                        <tr>
                            <td>{{ $d->tahun }}</td>
                            <td>{{ $d->pelabuhan->nama ?? '-' }}</td>
                            <td>{{ $d->wppnri->kode ?? '-' }}</td>
                            <td>{{ $d->jenis_lk }}</td>
                            <td>{{ $d->jenisApi->nama ?? '-' }}</td>
                            <td>{{ $d->kategoriUkuranKapal->label ?? '-' }}</td>
                            <td>{{ number_format($d->jumlah_rtp, 0, ',', '.') }}</td>
                            <td>{{ number_format($d->jumlah_kapal, 0, ',', '.') }}</td>
                            <td>{{ number_format($d->jumlah_api, 0, ',', '.') }}</td>
                            <td>{{ number_format($d->jumlah_nelayan_buruh, 0, ',', '.') }}</td>
                            <td class="nelayan-total">{{ number_format($d->jumlah_nelayan, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('tangkap.tahunan.edit', $d->id) }}" class="btn-delete-sm" style="color:#0f172a;">Edit</a>
                                <form method="POST" action="{{ route('tangkap.tahunan.destroy', $d->id) }}"
                                      onsubmit="return confirm('Hapus data ini?');" class="d-inline mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div id="noResultMsg" class="empty-state" style="display:none;">Tidak ada data yang cocok.</div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const searchInput = document.getElementById('searchInput');
    const tableWrapper = document.getElementById('tableWrapper');
    const noResultMsg = document.getElementById('noResultMsg');
    searchInput.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        let visibleCount = 0;
        document.querySelectorAll('#riwayatTahunan tbody tr').forEach(function (row) {
            const match = row.textContent.toLowerCase().includes(keyword);
            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });
        if (tableWrapper && noResultMsg) {
            tableWrapper.style.display = visibleCount === 0 ? 'none' : '';
            noResultMsg.style.display = visibleCount === 0 ? '' : 'none';
        }
    });
</script>

</body>
</html>
