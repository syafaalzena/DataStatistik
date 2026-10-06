<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Trip Tangkap - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
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
        .brand-logo-img { height: 40px; width: auto; }
        .back-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
        .back-btn:hover { background: #0f172a; color: #fff; }
        .back-btn img { transition: filter .18s ease; }
        .back-btn:hover img { filter: brightness(0) invert(1); }
        .btn-logout-icon { background: transparent; border: 1.5px solid rgba(248,250,252,.25); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }
        .btn-logout-icon img { filter: brightness(0) invert(1); transition: filter .18s ease; }
        .btn-logout-icon:hover img { filter: none; }
        .kab-badge { display: inline-block; background: #e0f2fe; color: #0369a1; font-weight: 600; font-size: 12px; padding: 4px 12px; border-radius: 20px; margin-bottom: 6px; }
        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 600; border: none; padding: 10px 22px; text-decoration: none; display: inline-block; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }
        .btn-outline-custom { background: #fff; color: var(--clr-dark); border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 600; padding: 10px 22px; text-decoration: none; display: inline-block; }
        .btn-outline-custom:hover { background: #f1f5f9; color: var(--clr-dark); }

        .riwayat-table { border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04); background: #fff; }
        .riwayat-table table { margin-bottom: 0; }
        .riwayat-table thead th { background: var(--clr-dark); color: #fff; font-weight: 600; border: none; font-size: 13px; white-space: nowrap; }
        .riwayat-table td { vertical-align: middle; font-size: 13px; white-space: nowrap; }
        .btn-delete-sm { background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; }
        .btn-delete-sm:hover { text-decoration: underline; }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }

        .tab-nav { display: flex; gap: 4px; background: #fff; border-radius: 10px; padding: 4px; box-shadow: 0 2px 8px rgba(0,0,0,.04); width: fit-content; }
        .tab-item { padding: 8px 18px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; color: #64748b; }
        .tab-item:hover { background: #f1f5f9; color: var(--clr-dark); }
        .tab-item.active { background: var(--clr-dark); color: #fff; }
        .tab-item.disabled { color: #cbd5e1; cursor: not-allowed; }
        .tab-item.disabled:hover { background: none; color: #cbd5e1; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <img src="{{ asset('images/pancacita.png') }}" alt="Logo Pancacita" class="brand-logo-img">
            <span class="brand-text">SIDKP</span>
        </a>
        
    </div>
</nav>

<div class="container pb-5">

    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('tangkap.input', $kabupaten->id) }}" class="back-btn">
            <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
        </a>
        <div>
            <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
            <h2 class="fw-bold mb-1">Data Trip Tangkap</h2>
            <p class="text-muted mb-0">Catatan kapal yang pulang melaut, dicatat tiap kejadian (bukan wajib harian).</p>
        </div>
    </div>

    @include('tangkap.partials.nav-tabs', ['kabupaten' => $kabupaten])

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex gap-2 flex-wrap mb-4">
        <a href="{{ route('tangkap.trip.create', $kabupaten->id) }}" class="btn-dark-custom">+ Tambah Data Trip</a>
        <a href="{{ route('tangkap.trip.rekap', $kabupaten->id) }}" class="btn-outline-custom">Rekap & Cetak</a>
    </div>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari pelabuhan, jenis API, tanggal...">
    </div>

    <div id="riwayatTrip" class="riwayat-table mb-4">
        @if($dataTrip->isEmpty())
            <div class="empty-state">Belum ada data trip untuk kabupaten ini. Klik "+ Tambah Data Trip" untuk mulai input.</div>
        @else
            <div class="table-responsive">
            <table class="table table-hover text-center align-middle mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelabuhan</th>
                        <th>WPPNRI</th>
                        <th>Jenis LK</th>
                        <th>Jenis API</th>
                        <th>Ukuran Kapal</th>
                        <th>Jumlah Trip</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataTrip as $t)
                        <tr>
                            <td>{{ $t->tanggal->translatedFormat('d F Y') }}</td>
                            <td>{{ $t->pelabuhan->nama ?? '-' }}</td>
                            <td>{{ $t->wppnri->kode ?? '-' }}</td>
                            <td>{{ $t->jenis_lk }}</td>
                            <td>{{ $t->jenisApi->nama ?? '-' }}</td>
                            <td>{{ $t->kategoriUkuranKapal->label ?? '-' }}</td>
                            <td>{{ $t->jumlah_trip }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a href="{{ route('tangkap.trip.edit', $t->id) }}" class="btn-delete-sm" style="color:#0f172a; text-decoration:none;">Edit</a>
                                    <form method="POST" action="{{ route('tangkap.trip.destroy', $t->id) }}"
                                          onsubmit="return confirm('Hapus data ini?');" class="d-inline mb-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-sm">Hapus</button>
                                    </form>
                                </div>
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
<script>
    function bukaEdit(id, tanggal, jumlah, pelabuhanNama) {
        document.getElementById('editPelabuhanNama').value = pelabuhanNama;
        document.getElementById('editTanggal').value = tanggal;
        document.getElementById('editJumlah').value = jumlah;
        document.getElementById('formEdit').action = '{{ url('/tangkap/trip') }}/' + id;
        document.getElementById('modalEdit').style.display = 'flex';
    }
    function tutupEdit() {
        document.getElementById('modalEdit').style.display = 'none';
    }
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#riwayatTrip tbody tr').forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });
</script>
</body>
</html>