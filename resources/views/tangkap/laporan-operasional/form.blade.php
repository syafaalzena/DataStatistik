<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $laporan ? 'Edit' : 'Input' }} Laporan Operasional - SIDKP</title>

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

        .panel-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 24px; margin-bottom: 20px; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #e2e8f0; font-size: 14px; }
        .field-label { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 2px; display: block; }

        .section-title { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .section-sub { color: #64748b; font-size: 13px; margin-bottom: 16px; }

        .row-input { border: 1px solid #eef0e8; border-radius: 10px; padding: 14px; margin-bottom: 10px; background: #fafaf7; }
        .btn-remove-row { background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; }
        .btn-remove-row:hover { text-decoration: underline; }
        .btn-add-row { background: none; border: 1.5px dashed #94a3b8; color: #475569; border-radius: 8px; padding: 8px 16px; font-weight: 600; font-size: 14px; }
        .btn-add-row:hover { background: #f1f5f9; }

        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 600; border: none; padding: 10px 26px; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }
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
                <a href="{{ route('laporan-operasional.index', $kabupaten->id) }}" class="back-btn">&larr;</a>
        <div>
            <h2 class="fw-bold mb-1">{{ $laporan ? 'Edit' : 'Input' }} Laporan Operasional Pelabuhan</h2>
            <p class="text-muted mb-0">Isi rekapitulasi aktivitas harian pelabuhan perikanan untuk satu bulan.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

        <form method="POST" action="{{ $laporan ? route('laporan-operasional.update', $laporan) : route('laporan-operasional.store', $kabupaten->id) }}">
        @csrf
        @if ($laporan) @method('PUT') @endif

        {{-- HEADER --}}
        <div class="panel-card">
            <div class="section-title">Informasi Pelabuhan</div>
            <div class="section-sub">Pelabuhan, bulan, dan tahun laporan.</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="field-label">Pelabuhan Perikanan</label>
                    <select name="pelabuhan_id" class="form-select" required>
                        <option value="">-- Pilih Pelabuhan --</option>
                        @foreach ($pelabuhanList as $p)
                            <option value="{{ $p->id }}" @selected(old('pelabuhan_id', $laporan->pelabuhan_id ?? null) == $p->id)>
                                {{ $p->nama }} ({{ $p->kabupatenIkan->nama_kabupaten ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="field-label">Bulan</label>
                    <select name="bulan" class="form-select" required>
                        @php $namaBulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; @endphp
                        @foreach ($namaBulan as $num => $nama)
                            <option value="{{ $num }}" @selected(old('bulan', $laporan->bulan ?? now()->month) == $num)>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="field-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $laporan->tahun ?? now()->year) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="field-label">Nama Pengelola Kepelabuhan Perikanan</label>
                    <input type="text" name="nama_pengelola" class="form-control" value="{{ old('nama_pengelola', $laporan->nama_pengelola ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="field-label">NIP Pengelola</label>
                    <input type="text" name="nip_pengelola" class="form-control" value="{{ old('nip_pengelola', $laporan->nip_pengelola ?? '') }}">
                </div>
            </div>
        </div>

        {{-- ARMADA TANGKAP --}}
        <div class="panel-card">
            <div class="section-title">Data Armada Tangkap</div>
            <div class="section-sub">Jumlah kapal & ABK per kategori ukuran kapal (GT). Klik "Tambah Baris" untuk menambah kategori.</div>
            <div id="armadaContainer">
                @php $armadaRows = old('ukuran_kapal', $laporan->armadaTangkap ?? []); @endphp
                @forelse ($armadaRows as $i => $row)
                    @php
                        $ukuran = is_array($row) ? $row : ($row->ukuran_kapal ?? old("ukuran_kapal.$i"));
                        $jmlKapal = is_array($row) ? old("jumlah_kapal.$i") : $row->jumlah_kapal;
                        $jmlAbk = is_array($row) ? old("jumlah_abk.$i") : $row->jumlah_abk;
                        $status = is_array($row) ? old("status_dokumen.$i") : $row->status_dokumen;
                    @endphp
                    <div class="row-input row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="field-label">Ukuran Kapal (GT)</label>
                            <input type="text" name="ukuran_kapal[]" class="form-control" value="{{ $ukuran }}" placeholder="cth: < 5">
                        </div>
                        <div class="col-md-3">
                            <label class="field-label">Jumlah Kapal (Unit)</label>
                            <input type="number" step="0.01" name="jumlah_kapal[]" class="form-control" value="{{ $jmlKapal }}">
                        </div>
                        <div class="col-md-3">
                            <label class="field-label">Jumlah ABK (Org)</label>
                            <input type="number" step="0.01" name="jumlah_abk[]" class="form-control" value="{{ $jmlAbk }}">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Kelengkapan Dokumen</label>
                            <select name="status_dokumen[]" class="form-select">
                                <option value="">-</option>
                                <option value="Lengkap" @selected($status == 'Lengkap')>Lengkap</option>
                                <option value="Tidak Lengkap" @selected($status == 'Tidak Lengkap')>Tidak Lengkap</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <button type="button" class="btn-add-row mt-2" onclick="addArmadaRow()">+ Tambah Baris</button>
        </div>

        {{-- PRODUKSI IKAN DOMINAN --}}
        <div class="panel-card">
            <div class="section-title">Produksi Ikan Dominan & Nilai Produksi</div>
            <div class="section-sub">Jenis ikan, produksi (kg), dan harga. Nilai produksi dihitung otomatis.</div>
            <div id="produksiContainer">
                @php $produksiRows = old('jenis_ikan', $laporan->produksiIkan ?? []); @endphp
                @forelse ($produksiRows as $i => $row)
                    @php
                        $jenis = is_array($row) ? $row : ($row->jenis_ikan ?? old("jenis_ikan.$i"));
                        $produksiKg = is_array($row) ? old("produksi_kg.$i") : $row->produksi_kg;
                        $harga = is_array($row) ? old("harga_rp.$i") : $row->harga_rp;
                    @endphp
                    <div class="row-input row g-2 align-items-end produksi-row">
                        <div class="col-md-4">
                            <label class="field-label">Jenis Ikan</label>
                            <input type="text" name="jenis_ikan[]" class="form-control" value="{{ $jenis }}">
                        </div>
                        <div class="col-md-3">
                            <label class="field-label">Produksi (Kg)</label>
                            <input type="number" step="0.01" name="produksi_kg[]" class="form-control produksi-kg" value="{{ $produksiKg }}" oninput="hitungNilai(this)">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Harga Ikan (Rp)</label>
                            <input type="number" step="0.01" name="harga_rp[]" class="form-control produksi-harga" value="{{ $harga }}" oninput="hitungNilai(this)">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Nilai Produksi (Rp)</label>
                            <input type="text" class="form-control produksi-nilai" value="{{ number_format((float)$produksiKg * (float)$harga, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <button type="button" class="btn-add-row mt-2" onclick="addProduksiRow()">+ Tambah Baris</button>
        </div>

        {{-- LOGISTIK --}}
        <div class="panel-card">
            <div class="section-title">Logistik</div>
            <div class="section-sub">Kebutuhan logistik (BBM, Air, Es, Garam, Oli, Gas, Ransum, dll). Bisa tambah item lain.</div>
            <div id="logistikContainer">
                @php $logistikRows = old('nama_item', $laporan->logistik ?? []); @endphp
                @forelse ($logistikRows as $i => $row)
                    @php
                        $nama = is_array($row) ? $row : ($row->nama_item ?? old("nama_item.$i"));
                        $jml = is_array($row) ? old("jumlah_logistik.$i") : $row->jumlah;
                        $satuan = is_array($row) ? old("satuan.$i") : $row->satuan;
                        $hrg = is_array($row) ? old("harga_logistik.$i") : $row->harga_rp;
                        $total = is_array($row) ? old("total_logistik.$i") : $row->total_rp;
                    @endphp
                    <div class="row-input row g-2 align-items-end logistik-row">
                        <div class="col-md-3">
                            <label class="field-label">Kebutuhan Logistik</label>
                            <input type="text" name="nama_item[]" class="form-control" value="{{ $nama }}">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Jumlah</label>
                            <input type="number" step="0.01" name="jumlah_logistik[]" class="form-control logistik-jumlah" value="{{ $jml }}" oninput="hitungTotalLogistik(this)">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Satuan</label>
                            <input type="text" name="satuan[]" class="form-control" value="{{ $satuan }}" placeholder="Liter/Kg/Rp">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Harga (Rp)</label>
                            <input type="number" step="0.01" name="harga_logistik[]" class="form-control logistik-harga" value="{{ $hrg }}" oninput="hitungTotalLogistik(this)">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Total (Rp)</label>
                            <input type="number" step="0.01" name="total_logistik[]" class="form-control logistik-total" value="{{ $total }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <button type="button" class="btn-add-row mt-2" onclick="addLogistikRow()">+ Tambah Baris</button>
        </div>

        {{-- PEMASARAN --}}
        <div class="panel-card">
            <div class="section-title">Data Pemasaran</div>
            <div class="section-sub">Pemasaran dalam negeri (lokal/regional) maupun ekspor.</div>
            <div id="pemasaranContainer">
                @php $pemasaranRows = old('jenis_ikan_pemasaran', $laporan->pemasaran ?? []); @endphp
                @forelse ($pemasaranRows as $i => $row)
                    @php
                        $kategori = is_array($row) ? old("kategori_pemasaran.$i") : $row->kategori;
                        $jenis = is_array($row) ? $row : ($row->jenis_ikan ?? old("jenis_ikan_pemasaran.$i"));
                        $qty = is_array($row) ? old("quantity_kg.$i") : $row->quantity_kg;
                        $tujuan = is_array($row) ? old("tujuan.$i") : $row->tujuan;
                    @endphp
                    <div class="row-input row g-2 align-items-end">
                        <div class="col-md-2">
                            <label class="field-label">Kategori</label>
                            <select name="kategori_pemasaran[]" class="form-select">
                                <option value="Lokal" @selected($kategori == 'Lokal')>Lokal (Antar Kabupaten)</option>
                                <option value="Regional" @selected($kategori == 'Regional')>Regional (Antar Provinsi)</option>
                                <option value="Ekspor" @selected($kategori == 'Ekspor')>Ekspor</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="field-label">Jenis Ikan</label>
                            <input type="text" name="jenis_ikan_pemasaran[]" class="form-control" value="{{ $jenis }}">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Quantity (Kg)</label>
                            <input type="number" step="0.01" name="quantity_kg[]" class="form-control" value="{{ $qty }}">
                        </div>
                        <div class="col-md-4">
                            <label class="field-label">Tujuan (Kabupaten/Provinsi/Negara)</label>
                            <input type="text" name="tujuan[]" class="form-control" value="{{ $tujuan }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <button type="button" class="btn-add-row mt-2" onclick="addPemasaranRow()">+ Tambah Baris</button>
        </div>

        <div class="d-flex justify-content-end gap-2">
         <a href="{{ route('laporan-operasional.index', $kabupaten->id) }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn-dark-custom">Simpan Laporan</button>
        </div>
    </form>
</div>

<script>
    function hitungNilai(input) {
        const row = input.closest('.produksi-row');
        const kg = parseFloat(row.querySelector('.produksi-kg').value) || 0;
        const harga = parseFloat(row.querySelector('.produksi-harga').value) || 0;
        row.querySelector('.produksi-nilai').value = (kg * harga).toLocaleString('id-ID');
    }

    function hitungTotalLogistik(input) {
        const row = input.closest('.logistik-row');
        const jumlah = parseFloat(row.querySelector('.logistik-jumlah').value) || 0;
        const harga = parseFloat(row.querySelector('.logistik-harga').value) || 0;
        row.querySelector('.logistik-total').value = (jumlah * harga).toFixed(2);
    }

    function addArmadaRow() {
        const html = `
        <div class="row-input row g-2 align-items-end">
            <div class="col-md-3">
                <label class="field-label">Ukuran Kapal (GT)</label>
                <input type="text" name="ukuran_kapal[]" class="form-control" placeholder="cth: < 5">
            </div>
            <div class="col-md-3">
                <label class="field-label">Jumlah Kapal (Unit)</label>
                <input type="number" step="0.01" name="jumlah_kapal[]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="field-label">Jumlah ABK (Org)</label>
                <input type="number" step="0.01" name="jumlah_abk[]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="field-label">Kelengkapan Dokumen</label>
                <select name="status_dokumen[]" class="form-select">
                    <option value="">-</option>
                    <option value="Lengkap">Lengkap</option>
                    <option value="Tidak Lengkap">Tidak Lengkap</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
            </div>
        </div>`;
        document.getElementById('armadaContainer').insertAdjacentHTML('beforeend', html);
    }

    function addProduksiRow() {
        const html = `
        <div class="row-input row g-2 align-items-end produksi-row">
            <div class="col-md-4">
                <label class="field-label">Jenis Ikan</label>
                <input type="text" name="jenis_ikan[]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="field-label">Produksi (Kg)</label>
                <input type="number" step="0.01" name="produksi_kg[]" class="form-control produksi-kg" oninput="hitungNilai(this)">
            </div>
            <div class="col-md-2">
                <label class="field-label">Harga Ikan (Rp)</label>
                <input type="number" step="0.01" name="harga_rp[]" class="form-control produksi-harga" oninput="hitungNilai(this)">
            </div>
            <div class="col-md-2">
                <label class="field-label">Nilai Produksi (Rp)</label>
                <input type="text" class="form-control produksi-nilai" value="0" readonly>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
            </div>
        </div>`;
        document.getElementById('produksiContainer').insertAdjacentHTML('beforeend', html);
    }

    function addLogistikRow() {
        const html = `
        <div class="row-input row g-2 align-items-end logistik-row">
            <div class="col-md-3">
                <label class="field-label">Kebutuhan Logistik</label>
                <input type="text" name="nama_item[]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="field-label">Jumlah</label>
                <input type="number" step="0.01" name="jumlah_logistik[]" class="form-control logistik-jumlah" oninput="hitungTotalLogistik(this)">
            </div>
            <div class="col-md-2">
                <label class="field-label">Satuan</label>
                <input type="text" name="satuan[]" class="form-control" placeholder="Liter/Kg/Rp">
            </div>
            <div class="col-md-2">
                <label class="field-label">Harga (Rp)</label>
                <input type="number" step="0.01" name="harga_logistik[]" class="form-control logistik-harga" oninput="hitungTotalLogistik(this)">
            </div>
            <div class="col-md-2">
                <label class="field-label">Total (Rp)</label>
                <input type="number" step="0.01" name="total_logistik[]" class="form-control logistik-total">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
            </div>
        </div>`;
        document.getElementById('logistikContainer').insertAdjacentHTML('beforeend', html);
    }

    function addPemasaranRow() {
        const html = `
        <div class="row-input row g-2 align-items-end">
            <div class="col-md-2">
                <label class="field-label">Kategori</label>
                <select name="kategori_pemasaran[]" class="form-select">
                    <option value="Lokal">Lokal (Antar Kabupaten)</option>
                    <option value="Regional">Regional (Antar Provinsi)</option>
                    <option value="Ekspor">Ekspor</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="field-label">Jenis Ikan</label>
                <input type="text" name="jenis_ikan_pemasaran[]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="field-label">Quantity (Kg)</label>
                <input type="number" step="0.01" name="quantity_kg[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="field-label">Tujuan (Kabupaten/Provinsi/Negara)</label>
                <input type="text" name="tujuan[]" class="form-control">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
            </div>
        </div>`;
        document.getElementById('pemasaranContainer').insertAdjacentHTML('beforeend', html);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>