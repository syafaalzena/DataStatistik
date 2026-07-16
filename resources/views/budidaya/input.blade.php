<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Budidaya - {{ $kabupaten->nama_kabupaten }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Croissant+One&family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --clr-bg: #F7F5F0; --clr-dark: #0f172a; --clr-blue-brand: #38bdf8; }
        body { background: var(--clr-bg); font-family: 'Inter', sans-serif; color: var(--clr-dark); }

        .navbar { background: var(--clr-dark); color: white; padding: 14px 0; box-shadow: 0 4px 12px rgba(15,23,42,.05); margin-bottom: 1.5rem; }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-text { font-weight: bold; font-size: 26px; color: #fff; }
        .brand-logo-svg { width: 32px; height: 32px; fill: var(--clr-blue-brand); }

        .back-btn {
            width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;
            background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none;
            transition: all .2s ease; box-shadow: 0 2px 6px rgba(0,0,0,.05);
        }
        .back-btn:hover { transform: translateY(-2px); background: #0f172a; border-color: #0f172a; }
        .back-btn:hover img { filter: brightness(0) invert(1); }

        .btn-logout-icon {
            background: transparent; border: 1.5px solid rgba(248,250,252,.25);
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .25s ease;
        }
        .btn-logout-icon img { width: 20px; height: 20px; filter: brightness(0) invert(1); transition: transform .25s ease; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }
        .btn-logout-icon:hover img { transform: translateX(2px); filter: none; }

        .panel-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 24px; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #e2e8f0; }

        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 600; border: none; padding: 10px 22px; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }

        .btn-outline-custom {
            background: #fff; color: var(--clr-dark); border: 1px solid #e2e8f0;
            border-radius: 8px; font-weight: 600; padding: 9px 18px; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px; transition: all .2s ease;
        }
        .btn-outline-custom:hover { background: var(--clr-dark); color: #fff; border-color: var(--clr-dark); }

        .row-input { border: 1px solid #eef0e8; border-radius: 10px; padding: 12px; margin-bottom: 10px; background: #fafaf7; }

        .btn-remove-row {
            background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600;
        }
        .btn-remove-row:hover { text-decoration: underline; }

        .btn-add-row {
            background: none; border: 1.5px dashed #94a3b8; color: #475569;
            border-radius: 8px; padding: 8px 16px; font-weight: 600; font-size: 14px; width: 100%;
        }
        .btn-add-row:hover { background: #f1f5f9; }

        .riwayat-table { border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04); background: #fff; }
        .riwayat-table table { margin-bottom: 0; }
        .riwayat-table thead th { background: var(--clr-dark); color: #fff; font-weight: 600; border: none; font-size: 13px; }
        .riwayat-table td { vertical-align: middle; font-size: 14px; }

        .btn-delete-sm { background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; }
        .btn-delete-sm:hover { text-decoration: underline; }

        .empty-state { text-align: center; padding: 30px 20px; color: #94a3b8; }

        .section-title { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .section-sub { color: #64748b; font-size: 14px; margin-bottom: 16px; }

        .brand-logo-img {
    height: 30px;      /* samain sama font-size .brand-text (26px) */
    width: auto;       /* ikut aspect ratio asli, nggak dipotong */
    object-fit: contain;
}

.brand-logo-img {
    height: 30px;      /* samain sama font-size .brand-text (26px) */
    width: auto;       /* ikut aspect ratio asli, nggak dipotong */
    object-fit: contain;
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

    <div class="d-flex align-items-center justify-content-between gap-3 mb-4 flex-wrap">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('budidaya.index') }}" class="back-btn">
                <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
            </a>
            <div>
                <h2 class="fw-bold mb-1">Input Data Budidaya</h2>
                <p class="text-muted mb-0">Kabupaten: <strong>{{ $kabupaten->nama_kabupaten }}</strong></p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('budidaya.komoditas.create', $kabupaten->id) }}" class="btn-outline-custom">Kelola Komoditas</a>
            <a href="{{ route('budidaya.jenis.index', $kabupaten->id) }}" class="btn-outline-custom">Kelola Jenis Budidaya</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-warning">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($komoditasList->isEmpty() || $jenisList->isEmpty())
        <div class="alert alert-info">
            Sebelum input produksi, pastikan sudah ada minimal 1 <strong>komoditas</strong> dan 1 <strong>jenis budidaya</strong>
            untuk kabupaten ini. Gunakan tombol "Kelola Komoditas" / "Kelola Jenis Budidaya" di atas.
        </div>
    @endif

    {{-- ================= SECTION 1: PRODUKSI BULANAN ================= --}}
    <div class="panel-card mb-4">
        <div class="section-title">Input Produksi Bulanan</div>
        <div class="section-sub">Pilih bulan &amp; tahun, lalu isi hasil produksi per komoditas &times; jenis budidaya.</div>

        <form method="POST" action="{{ route('budidaya.produksi.store', $kabupaten->id) }}">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold small">Bulan</label>
                    <select name="bulan" class="form-select" required>
                        @foreach(range(1,12) as $b)
                            <option value="{{ $b }}" {{ now()->month == $b ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold small">Tahun</label>
                    <select name="tahun" class="form-select" required>
                        @foreach(range(now()->year - 3, now()->year + 1) as $y)
                            <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold small">Lokasi</label>
                    <input type="text" name="keterangan" class="form-control" placeholder=" desa / kecamatan">
                </div>
            </div>

            <label class="form-label fw-semibold small">Rincian Produksi</label>
            <div id="produksiRows">
                <div class="row-input row g-2 align-items-center produksi-row">
                    <div class="col-md-4">
                        <select name="komoditas_id[]" class="form-select">
                            <option value="">-- Pilih Komoditas --</option>
                            @foreach($komoditasList as $kom)
                                <option value="{{ $kom->id }}">{{ $kom->nama_komoditas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="jenis_id[]" class="form-select">
                            <option value="">-- Pilih Jenis Budidaya --</option>
                            @foreach($jenisList as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" min="0" name="produksi[]" class="form-control" placeholder="Hasil produksi (kg)">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn-remove-row" onclick="removeRow(this)">Hapus</button>
                    </div>
                    
                </div>
            </div>
            <button type="button" class="btn-add-row mb-3" onclick="addProduksiRow()">+ Tambah Baris</button>

            <button type="submit" class="btn-dark-custom">Simpan Produksi</button>
        </form>
    </div>

    {{-- RIWAYAT PRODUKSI --}}
    <div class="mb-3">
    <input
        type="text"
        id="searchInput"
        class="form-control"
        placeholder="🔍 Cari komoditas, jenis budidaya, bulan, tahun...">
</div>
    <div id="riwayatProduksi" class="riwayat-table mb-4">
        @if($dataProduksi->isEmpty())
            <div class="empty-state">Belum ada data produksi.</div>
        @else
            <table class="table table-hover text-center align-middle">
    <thead>
        <tr>
            <th>Bulan/Tahun</th>
            <th>Komoditas</th>
            <th>Jenis Budidaya</th>
            <th>Hasil Produksi (Kg)</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataProduksi as $d)
            <tr>
                <td>{{ \Carbon\Carbon::create()->month($d->bulan)->translatedFormat('F') }} {{ $d->tahun }}</td>
                <td>{{ $d->komoditas->nama_komoditas ?? '-' }}</td>
                <td>{{ $d->jenis->nama_jenis ?? '-' }}</td>
                <td>{{ rtrim(rtrim(number_format($d->hasil_produksi, 2, '.', ','), '0'), '.') }}</td>
                <td>{{ $d->keterangan ?? '-' }}</td>
                <td>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <button type="button"
                            onclick="bukaEditProduksi(
                                {{ $d->id }},
                                {{ $d->bulan }},
                                {{ $d->tahun }},
                                {{ $d->hasil_produksi }},
                                '{{ addslashes($d->komoditas->nama_komoditas ?? '-') }}',
                                '{{ addslashes($d->jenis->nama_jenis ?? '-') }}',
                                '{{ addslashes($d->keterangan ?? '') }}'
                            )"
                            style="background:none; border:none; padding:0; cursor:pointer; display:flex; align-items:center;">
                            <img src="{{ asset('images/pencil.png') }}" alt="Edit" width="20" height="20">
                        </button>
                        <form method="POST" action="{{ route('budidaya.produksi.destroy', $d->id) }}"
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
        @endif
    </div>

    {{-- ================= SECTION 2: SARANA TAHUNAN ================= --}}
    <div class="panel-card mb-4">
        <div class="section-title">Input Sarana Tahunan</div>
        <div class="section-sub">Diisi 1 kali per tahun: jumlah RTP, pembudidaya, dan luas lahan per jenis budidaya.</div>

        <form method="POST" action="{{ route('budidaya.sarana.store', $kabupaten->id) }}">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold small">Tahun</label>
                    <select name="tahun" class="form-select" required>
                        @foreach(range(now()->year - 3, now()->year + 1) as $y)
                            <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <label class="form-label fw-semibold small">Rincian Sarana per Jenis Budidaya</label>
            <div id="saranaRows">
                <div class="row-input row g-2 align-items-center sarana-row">
                    <div class="col-md-3">
                        <select name="jenis_id[]" class="form-select">
                            <option value="">-- Pilih Jenis Budidaya --</option>
                            @foreach($jenisList as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" min="0" name="rtp[]" class="form-control" placeholder="Jumlah RTP">
                    </div>
                    <div class="col-md-3">
                        <input type="number" min="0" name="pembudidaya[]" class="form-control" placeholder="Jumlah Pembudidaya">
                    </div>
                    <div class="col-md-2">
                        <input type="number" min="0" name="luas_lahan[]" class="form-control" placeholder="Luas Lahan">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn-remove-row" onclick="removeRow(this)">Hapus</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-add-row mb-3" onclick="addSaranaRow()">+ Tambah Baris</button>

            <button type="submit" class="btn-dark-custom">Simpan Sarana</button>
        </form>
    </div>

    {{-- RIWAYAT SARANA --}}
    <div class="mb-3">
    <input
        type="text"
        id="searchSarana"
        class="form-control"
        placeholder="🔍 Cari jenis budidaya atau tahun...">
</div>
    <div id="riwayatSarana" class="riwayat-table">
        @if($dataSarana->isEmpty())
            <div class="empty-state">Belum ada data sarana tahunan.</div>
        @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Jenis Budidaya</th>
                        <th class="text-end">Jumlah RTP</th>
                        <th class="text-end">Jumlah Pembudidaya</th>
                        <th class="text-end">Luas Lahan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataSarana as $d)
                        <tr>
                            <td>{{ $d->tahun }}</td>
                            <td>{{ $d->jenis->nama_jenis ?? '-' }}</td>
                            <td class="text-end">{{ number_format($d->jumlah_rtp) }}</td>
                            <td class="text-end">{{ number_format($d->jumlah_pembudidaya) }}</td>
                            <td class="text-end">{{ number_format($d->luas_lahan) }}</td>
                            <td class="text-end">
                                <button type="button"
                                    onclick="bukaEditSarana(
                                        {{ $d->id }},
                                        {{ $d->tahun }},
                                        {{ $d->jumlah_rtp }},
                                        {{ $d->jumlah_pembudidaya ?? 0 }},
                                        {{ $d->luas_lahan ?? 0 }},
                                        '{{ addslashes($s->jenis->nama_jenis ?? '-') }}'
                                    )"
                                    style="background:none; border:none; padding:0; cursor:pointer; display:flex; align-items:center;">
                                    <img src="{{ asset('images/pencil.png') }}" alt="Edit" width="20" height="20">
                                </button>
                                <form method="POST" action="{{ route('budidaya.sarana.destroy', $d->id) }}"
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
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function addProduksiRow() {
        const container = document.getElementById('produksiRows');
        const row = container.querySelector('.produksi-row').cloneNode(true);
        row.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
        row.querySelectorAll('input').forEach(el => el.value = '');
        container.appendChild(row);
    }

    function addSaranaRow() {
        const container = document.getElementById('saranaRows');
        const row = container.querySelector('.sarana-row').cloneNode(true);
        row.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
        row.querySelectorAll('input').forEach(el => el.value = '');
        container.appendChild(row);
    }

    function removeRow(btn) {
        const row = btn.closest('.row-input');
        const container = row.parentElement;
        // minimal harus ada 1 baris tersisa
        if (container.querySelectorAll('.row-input').length > 1) {
            row.remove();
        } else {
            row.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
            row.querySelectorAll('input').forEach(el => el.value = '');
        }
    }
</script>
<!-- script databulanan -->
<script>
function bukaEditProduksi(id, bulan, tahun, hasilProduksi, komoditasNama, jenisNama, keterangan) {
    document.getElementById('editKomoditasNama').value = komoditasNama;
    document.getElementById('editJenisNama').value = jenisNama;
    document.getElementById('editBulan').value = bulan;
    document.getElementById('editTahun').value = tahun;
    document.getElementById('editHasilProduksi').value = hasilProduksi;
    document.getElementById('editKeterangan').value = keterangan;

    document.getElementById('formEditProduksi').action = '{{ url('/budidaya/produksi') }}/' + id;
    document.getElementById('modalEditProduksi').style.display = 'flex';
}

function tutupEditProduksi() {
    document.getElementById('modalEditProduksi').style.display = 'none';
}
</script>

<!-- script data tahunan -->
<script>
function bukaEditSarana(id, tahun, rtp, pembudidaya, luasLahan, jenisNama) {
    document.getElementById('editSaranaJenisNama').value = jenisNama;
    document.getElementById('editSaranaTahunDisplay').value = tahun;
    document.getElementById('editSaranaTahun').value = tahun;
    document.getElementById('editSaranaRtp').value = rtp;
    document.getElementById('editSaranaPembudidaya').value = pembudidaya;
    document.getElementById('editSaranaLuasLahan').value = luasLahan;

    document.getElementById('formEditSarana').action = '{{ url('/budidaya/sarana') }}/' + id;
    document.getElementById('modalEditSarana').style.display = 'flex';
}

function tutupEditSarana() {
    document.getElementById('modalEditSarana').style.display = 'none';
}
</script>   

<!-- SCRIPT PENCARIAN -->
<script>
const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();

    const rows = document.querySelectorAll('#riwayatProduksi tbody tr');

    rows.forEach(function(row) {
        if (row.textContent.toLowerCase().includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<script>
const searchSarana = document.getElementById('searchSarana');

searchSarana.addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();

    const rows = document.querySelectorAll('#riwayatSarana tbody tr');

    rows.forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(keyword)
            ? ''
            : 'none';
    });
});
</script>

<!-- edit databulanan -->
<div id="modalEditProduksi" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:24px; border-radius:8px; width:420px; max-width:90%;">
        <h5 style="margin-bottom:16px;">Edit Data Produksi</h5>

        <form id="formEditProduksi" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label class="form-label">Komoditas</label>
                <input type="text" id="editKomoditasNama" class="form-control" disabled>
            </div>
            <div class="mb-2">
                <label class="form-label">Jenis Budidaya</label>
                <input type="text" id="editJenisNama" class="form-control" disabled>
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
                <label class="form-label">Hasil Produksi (kg)</label>
                <input type="number" step="0.01" min="0" name="hasil_produksi" id="editHasilProduksi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="keterangan" id="editKeterangan" class="form-control">
            </div>

            <div style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" class="btn btn-secondary" onclick="tutupEditProduksi()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- edit data tahunan -->
<div id="modalEditSarana" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:24px; border-radius:8px; width:420px; max-width:90%;">
        <h5 style="margin-bottom:16px;">Edit Data Tahunan (Sarana)</h5>

        <form id="formEditSarana" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label class="form-label">Jenis Budidaya</label>
                <input type="text" id="editSaranaJenisNama" class="form-control" disabled>
            </div>

            <div class="mb-2">
                <label class="form-label">Tahun</label>
                <input type="number" id="editSaranaTahunDisplay" class="form-control" disabled>
                <input type="hidden" name="tahun" id="editSaranaTahun">
            </div>

            <div class="mb-2">
                <label class="form-label">Jumlah RTP (unit)</label>
                <input type="number" min="0" name="jumlah_rtp" id="editSaranaRtp" class="form-control" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Jumlah Pembudidaya (orang)</label>
                <input type="number" min="0" name="jumlah_pembudidaya" id="editSaranaPembudidaya" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Luas Lahan (m2)</label>
                <input type="number" min="0" name="luas_lahan" id="editSaranaLuasLahan" class="form-control">
            </div>

            <div style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" class="btn btn-secondary" onclick="tutupEditSarana()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>