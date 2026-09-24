<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produksi Tangkap - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
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

        .riwayat-table { border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04); background: #fff; }
        .riwayat-table table { margin-bottom: 0; }
        .riwayat-table thead th { background: var(--clr-dark); color: #fff; font-weight: 600; border: none; font-size: 13px; white-space: nowrap; }
        .riwayat-table td { vertical-align: middle; font-size: 13px; white-space: nowrap; }
        .btn-delete-sm { background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; }
        .btn-delete-sm:hover { text-decoration: underline; }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }
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

    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('tangkap.produksi.index') }}" class="back-btn">&larr;</a>
        <div>
            <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
            <h2 class="fw-bold mb-1">Data Produksi Tangkap</h2>
            <p class="text-muted mb-0">Rekapitulasi hasil tangkapan per pelabuhan per bulan.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex gap-2 flex-wrap mb-4">
        <a href="{{ route('tangkap.produksi.create', $kabupaten->id) }}" class="btn-dark-custom">+ Tambah Data Produksi</a>
        <a href="{{ route('tangkap.produksi.rekap', $kabupaten->id) }}" class="btn-outline-custom"> Lihat & Cetak</a>
        <a href="{{ route('pelabuhan.index', $kabupaten->id) }}" class="btn-outline-custom"> Kelola Pelabuhan</a>
    </div>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari pelabuhan, jenis ikan, bulan, tahun...">
    </div>

    <div id="riwayatProduksi" class="riwayat-table mb-4">
        @if($dataProduksi->isEmpty())
            <div class="empty-state">Belum ada data produksi untuk kabupaten ini. Klik "+ Tambah Data Produksi" untuk mulai input.</div>
        @else
            <div id="tableWrapper" class="table-responsive">
            <table class="table table-hover text-center align-middle mb-0">
                <thead>
                    <tr>
                        <th>Bulan/Tahun</th>
                        <th>Pelabuhan</th>
                        <th>WPPNRI</th>
                        <th>Jenis LK</th>
                        <th>Jenis API</th>
                        <th>Ukuran Kapal</th>
                        <th>Jenis Ikan</th>
                        <th>Volume (Kg)</th>
                        <th>Harga (Rp)</th>
                        <th>Nilai (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataProduksi as $d)
                        <tr>
                            <td>{{ \Carbon\Carbon::create()->month($d->bulan)->translatedFormat('F') }} {{ $d->tahun }}</td>
                            <td>{{ $d->pelabuhan->nama ?? '-' }}</td>
                            <td>{{ $d->wppnri->kode ?? '-' }}</td>
                            <td>{{ $d->jenis_lk ?? '-' }}</td>
                            <td>{{ $d->jenisApi->nama ?? '-' }}</td>
                            <td>{{ $d->kategoriUkuranKapal->label ?? '-' }}</td>
                            <td>{{ $d->komoditasIkan->nama_ikan ?? '-' }}</td>
                            <td>{{ number_format($d->volume_produksi_kg, 2, ',', '.') }}</td>
                            <td>Rp {{ number_format($d->harga_rp, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($d->nilai_rp, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <button type="button"
                                        onclick="bukaEdit(
                                            {{ $d->id }},
                                            {{ $d->bulan }},
                                            {{ $d->tahun }},
                                            {{ $d->volume_produksi_kg }},
                                            {{ $d->harga_rp }},
                                            '{{ addslashes($d->pelabuhan->nama ?? '-') }}',
                                            '{{ addslashes($d->komoditasIkan->nama_ikan ?? '-') }}'
                                        )" class="btn-delete-sm" style="color:#0f172a;">Edit</button>
                                    <form method="POST" action="{{ route('tangkap.produksi.destroy', $d->id) }}"
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
            <div id="noResultMsg" class="empty-state" style="display:none;">Tidak ada data yang cocok.</div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function bukaEdit(id, bulan, tahun, volume, harga, pelabuhanNama, ikanNama) {
        document.getElementById('editPelabuhanNama').value = pelabuhanNama;
        document.getElementById('editIkanNama').value = ikanNama;
        document.getElementById('editBulan').value = bulan;
        document.getElementById('editTahun').value = tahun;
        document.getElementById('editVolume').value = volume;
        document.getElementById('editHarga').value = harga;
        document.getElementById('formEdit').action = '{{ url('/tangkap/produksi') }}/' + id;
        document.getElementById('modalEdit').style.display = 'flex';
    }
    function tutupEdit() {
        document.getElementById('modalEdit').style.display = 'none';
    }
    const searchInput = document.getElementById('searchInput');
    const tableWrapper = document.getElementById('tableWrapper');
    const noResultMsg = document.getElementById('noResultMsg');
    searchInput.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        let visibleCount = 0;
        document.querySelectorAll('#riwayatProduksi tbody tr').forEach(function (row) {
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

{{-- MODAL EDIT PRODUKSI --}}
<div id="modalEdit" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:24px; border-radius:8px; width:420px; max-width:90%;">
        <h5 style="margin-bottom:16px;">Edit Data Produksi</h5>
        <form id="formEdit" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label class="form-label">Pelabuhan</label>
                <input type="text" id="editPelabuhanNama" class="form-control" disabled>
            </div>
            <div class="mb-2">
                <label class="form-label">Jenis Ikan</label>
                <input type="text" id="editIkanNama" class="form-control" disabled>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" id="editBulan" class="form-select" required>
                        @foreach (['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" id="editTahun" class="form-control" required>
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Volume Produksi (Kg)</label>
                <input type="number" step="0.01" min="0" name="volume_produksi_kg" id="editVolume" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" step="1" min="0" name="harga_rp" id="editHarga" class="form-control" required>
            </div>
            <div style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" class="btn btn-secondary" onclick="tutupEdit()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>