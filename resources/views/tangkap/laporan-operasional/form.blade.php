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
    <link href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">

    <style>
        :root {
            --clr-bg: #F7F5F0; 
            --clr-dark: #0f172a; 
            --clr-blue-brand: #38bdf8; 
        }
        body { 
            background: var(--clr-bg); 
            font-family: 'Inter', sans-serif; 
            color: var(--clr-dark); }

        .navbar { 
            background: var(--clr-dark); 
            color: white; 
            padding: 14px 0; 
            margin-bottom: 1.5rem; 
        }
        
        .brand-wrapper { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            text-decoration: none; 
        }

        .brand-logo-img { height: 40px; width: auto; }
        .brand-text { 
            font-weight: bold; 
            font-size: 26px; 
            color: #fff; 
            text-decoration: none;
        }
        .back-btn { 
            width: 48px; 
            height: 48px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: #fff; 
            border: 1px solid #e2e8f0; 
            border-radius: 30px; 
            text-decoration: none; 
            box-shadow: 0 2px 6px rgba(0,0,0,.05); 
        }
        .back-btn:hover { 
            background: #0f172a; 
            color: #fff; 
        }

        .back-btn img { transition: filter .18s ease; }
        .back-btn:hover img { filter: brightness(0) invert(1); }
        .btn-logout-icon { 
            background: transparent; 
            border: 1.5px solid rgba(248,250,252,.25);
            width: 44px; 
            height: 44px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            cursor: pointer; 
        }
        .btn-logout-icon:hover { 
            background: var(--clr-blue-brand); 
            border-color: var(--clr-blue-brand); 
        }

        .panel-card { 
            background: #fff; 
            border-radius: 14px; 
            box-shadow: 0 2px 8px rgba(0,0,0,.04); 
            padding: 24px; 
            margin-bottom: 20px; 
        }
        .form-control, .form-select { 
            border-radius: 8px; 
            border: 1px solid #e2e8f0; 
            font-size: 14px; 
        }
        .field-label { 
            font-size: 12px; 
            font-weight: 600; color: #64748b; 
            margin-bottom: 2px; 
            display: block; 
        }

        .section-title { 
            font-size: 18px; 
            font-weight: 700;
            margin-bottom: 4px; 
        }

        .section-sub { 
            color: #64748b; 
            font-size: 13px; 
            margin-bottom: 16px; 
        }

        .row-input { 
            border: 1px solid #eef0e8; 
            border-radius: 10px; 
            padding: 14px; 
            margin-bottom: 10px; 
            background: #fafaf7; 
        }

        .btn-remove-row { 
            background: none; 
            border: none; 
            color: #dc2626; 
            font-size: 13px; 
            font-weight: 600; 
        }

        .btn-remove-row:hover { 
            text-decoration: underline; 
        }

        .btn-add-row { 
            background: none; 
            border: 1.5px dashed #94a3b8; 
            color: #475569; 
            border-radius: 8px; 
            padding: 8px 16px; 
            font-weight: 600; 
            font-size: 14px; 
        }

        .btn-add-row:hover { 
            background: #f1f5f9; 
        }

        .btn-dark-custom { 
            background: var(--clr-dark); 
            color: #fff; 
            border-radius: 8px; 
            font-weight: 600; 
            border: none; 
            padding: 10px 26px; 
        }
        .btn-dark-custom:hover { 
            background: #1e293b; 
            color: #fff; 
        }
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
                <a href="{{ route('laporan-operasional.index', $kabupaten->id) }}" class="back-btn">
                    <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
                </a>
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

        <form method="POST" action="{{ $laporan ? route('laporan-operasional.update', $laporan) : route('laporan-operasional.store', $kabupaten->id) }}" enctype="multipart/form-data">
        @csrf
        @if ($laporan) @method('PUT') @endif

        {{-- HEADER --}}
        <div class="panel-card">
            <div class="section-title">Informasi Pelabuhan</div>
            <div class="section-sub">Pelabuhan, bulan, dan tahun laporan.</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="field-label">Pelabuhan Perikanan</label>
                    <select name="pelabuhan_id" id="pelabuhanSelect" class="form-select" required>
                        <option value="">-- Pilih Pelabuhan --</option>
                        @foreach ($pelabuhanList as $p)
                            <option value="{{ $p->id }}" @selected(old('pelabuhan_id', $laporan->pelabuhan_id ?? null) == $p->id)>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    @if ($pelabuhanList->isEmpty())
                        <div class="small text-danger mt-2">
                            Belum ada pelabuhan terdaftar untuk kabupaten ini. Hubungi admin untuk menambahkannya.
                        </div>
                    @endif
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
            <div class="section-title">Data Armada Tangkap (Per Trip)</div>
            <div class="section-sub">Catat setiap kali kapal berangkat melaut. Satu baris = satu trip.</div>
            <div id="armadaContainer">
                @php $armadaRows = old('ukuran_kapal', $laporan->armadaTangkap ?? []); @endphp
                @forelse ($armadaRows as $i => $row)
                    @php
                        $namaArmada = is_object($row) ? $row->nama_armada : old("nama_armada.$i");
                        $tglBerangkat = is_object($row) ? optional($row->tanggal_berangkat)->format('Y-m-d') : old("tanggal_berangkat.$i");
                        $jenisAlat = is_object($row) ? $row->jenis_alat_tangkap : old("jenis_alat_tangkap.$i");
                        $lat = is_object($row) ? $row->latitude : old("latitude.$i");
                        $lng = is_object($row) ? $row->longitude : old("longitude.$i");
                        $ukuran = is_object($row) ? $row->ukuran_kapal : ($row ?? old("ukuran_kapal.$i"));
                        $jmlAbk = is_object($row) ? $row->jumlah_abk : old("jumlah_abk.$i");
                        $fotoLama = is_object($row) ? optional($row->foto)->foto : null;
                        $lokasiFoto = is_object($row) ? optional($row->foto)->lokasi : old("lokasi_foto.$i");
                    @endphp
                    <div class="row-input row g-2 align-items-end" data-index="{{ $i }}">
                        <div class="col-md-3">
                            <label class="field-label">Nama Kapal</label>
                            <input type="text" name="nama_armada[{{ $i }}]" class="form-control" value="{{ $namaArmada }}" placeholder="cth: KM Sinar Laut">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Tanggal Berangkat</label>
                            <input type="date" name="tanggal_berangkat[{{ $i }}]" class="form-control" value="{{ $tglBerangkat }}">
                        </div>
                        <div class="col-md-3">
                            <label class="field-label">Jenis Alat Tangkap / API</label>
                            <input type="text" name="jenis_alat_tangkap[{{ $i }}]" class="form-control" value="{{ $jenisAlat }}" placeholder="cth: Rawai Dasar">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Ukuran Kapal (GT)</label>
                            <input type="text" name="ukuran_kapal[{{ $i }}]" class="form-control" value="{{ $ukuran }}" placeholder="cth: < 5">
                        </div>
                        <div class="col-md-2">
                            <label class="field-label">Jumlah ABK (Org)</label>
                            <input type="number" step="0.01" name="jumlah_abk[{{ $i }}]" class="form-control" value="{{ $jmlAbk }}">
                        </div>

                        <div class="col-md-12">
                            <label class="field-label">Dokumen Trip (bebas diisi: SLO, SPB, CV, dll)</label>
                            <div class="dokumen-list">
                                @if (is_object($row))
                                    @foreach ($row->dokumens as $d)
                                        <div class="d-flex gap-2 mb-1 dokumen-item">
                                            <input type="text" name="dokumen_nama[{{ $i }}][]" class="form-control form-control-sm" value="{{ $d->nama_dokumen }}" placeholder="cth: SLO">
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-dokumen">Hapus</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-tambah-dokumen mt-1">+ Tambah Dokumen</button>
                        </div>

                        <div class="col-md-4">
                            <label class="field-label">Foto Kapal</label>
                            <input type="file" name="foto[{{ $i }}]" class="form-control" accept="image/*">
                            <input type="hidden" name="foto_lama[{{ $i }}]" value="{{ $fotoLama }}">
                            @if ($fotoLama)
                                <div class="small text-muted mt-1">
                                    <img src="{{ Storage::url($fotoLama) }}" style="height:40px;border-radius:6px;" class="me-1">
                                    Foto sudah ada, upload baru untuk mengganti.
                                </div>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label class="field-label">Lokasi</label>
                            <input type="text" name="lokasi_foto[{{ $i }}]" class="form-control" value="{{ $lokasiFoto }}" placeholder="cth: Dermaga Lampulo">
                        </div>

                        <div class="col-md-4">
                            <label class="field-label">Titik Koordinat</label>
                            <input type="hidden" name="latitude[{{ $i }}]" value="{{ $lat }}">
                            <input type="hidden" name="longitude[{{ $i }}]" value="{{ $lng }}">
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-pilih-peta">📍 Pilih di Peta</button>
                                <button type="button" class="btn btn-link btn-sm text-danger p-0 btn-hapus-titik">Hapus titik</button>
                            </div>
                            <div class="small text-muted mt-1 koordinat-teks">{{ ($lat !== null && $lat !== '' && $lng !== null && $lng !== '') ? $lat . ', ' . $lng : 'Belum dipilih' }}</div>
                        </div>

                        <div class="col-md-1">
                            <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <button type="button" class="btn-add-row mt-2" onclick="addArmadaRow()">+ Tambah Trip</button>
        </div>

        {{-- PRODUKSI IKAN DOMINAN --}}
        <div class="panel-card">
            <div class="section-title">Produksi Ikan Dominan & Nilai Produksi</div>
            <div class="section-sub">Jenis ikan, produksi (kg), dan harga. Nilai produksi dihitung otomatis.</div>
            <div id="produksiContainer">
                @php $produksiRows = old('jenis_ikan', $laporan->produksiIkan ?? []); @endphp
                @forelse ($produksiRows as $i => $row)
                    @php
                        $jenis = is_object($row) ? $row->jenis_ikan : ($row ?? old("jenis_ikan.$i"));
                        $produksiKg = is_object($row) ? $row->produksi_kg : old("produksi_kg.$i");
                        $harga = is_object($row) ? $row->harga_rp : old("harga_rp.$i");
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
                        $nama = is_object($row) ? $row->nama_item : ($row ?? old("nama_item.$i"));
                        $jml = is_object($row) ? $row->jumlah : old("jumlah_logistik.$i");
                        $satuan = is_object($row) ? $row->satuan : old("satuan.$i");
                        $hrg = is_object($row) ? $row->harga_rp : old("harga_logistik.$i");
                        $total = is_object($row) ? $row->total_rp : old("total_logistik.$i");
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
                        $kategori = is_object($row) ? $row->kategori : old("kategori_pemasaran.$i");
                        $jenis = is_object($row) ? $row->jenis_ikan : ($row ?? old("jenis_ikan_pemasaran.$i"));
                        $qty = is_object($row) ? $row->quantity_kg : old("quantity_kg.$i");
                        $tujuan = is_object($row) ? $row->tujuan : old("tujuan.$i");
                        $namaPt = is_object($row) ? $row->nama_pt : old("nama_pt.$i");
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
                        <div class="col-md-3">
                            <label class="field-label">Tujuan (Kabupaten/Provinsi/Negara)</label>
                            <input type="text" name="tujuan[]" class="form-control" value="{{ $tujuan }}">
                        </div>
                        <div class="col-md-3">
                            <label class="field-label">Nama PT (opsional)</label>
                            <input type="text" name="nama_pt[]" class="form-control" value="{{ $namaPt }}" placeholder="cth: PT Samudra Jaya">
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

<div class="modal fade" id="modalPeta" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Titik Koordinat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-2">
                    <input type="text" id="petaCari" class="form-control" placeholder="Cari tempat, cth: PPI Lampulo">
                    <button type="button" class="btn btn-dark" id="petaCariBtn">Cari</button>
                    <button type="button" class="btn btn-outline-secondary" id="petaLokasiSaya">Lokasi Saya</button>
                </div>
                <div id="petaHasil" class="list-group mb-2" style="max-height: 180px; overflow-y: auto;"></div>
                <div id="petaCanvas" style="height: 400px; border-radius: 8px;"></div>
                <div class="small text-muted mt-2">
                    Klik di peta untuk menaruh penanda, atau geser penandanya.
                    Titik terpilih: <strong id="petaKoordinat">belum dipilih</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-dark" id="petaGunakan" disabled>Gunakan Titik Ini</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    let petaMap = null, petaMarker = null, petaRow = null, petaLat = null, petaLng = null;
    let armadaIndexCounter = {{ count($armadaRows ?? []) }};
const petaModalEl = document.getElementById('modalPeta');
const PETA_AWAL = [4.6951, 96.7494]; // tengah Aceh

function tampilTitik(lat, lng) {
    petaLat = Number(lat.toFixed(7));
    petaLng = Number(lng.toFixed(7));
    document.getElementById('petaKoordinat').textContent = petaLat + ', ' + petaLng;
    document.getElementById('petaGunakan').disabled = false;
}

function setTitik(lat, lng) {
    if (!petaMarker) {
        petaMarker = L.marker([lat, lng], { draggable: true }).addTo(petaMap);
        petaMarker.on('dragend', function () {
            const p = petaMarker.getLatLng();
            tampilTitik(p.lat, p.lng);
        });
    } else {
        petaMarker.setLatLng([lat, lng]);
    }
    tampilTitik(lat, lng);
}

function resetTitik() {
    if (petaMarker) { petaMap.removeLayer(petaMarker); petaMarker = null; }
    petaLat = petaLng = null;
    document.getElementById('petaKoordinat').textContent = 'belum dipilih';
    document.getElementById('petaGunakan').disabled = true;
    document.getElementById('petaHasil').innerHTML = '';
    document.getElementById('petaCari').value = '';
}

// Buka peta dari tombol di baris armada mana pun (termasuk baris yang baru ditambah)
document.getElementById('armadaContainer').addEventListener('click', function (e) {
    const hapus = e.target.closest('.btn-hapus-titik');
    if (hapus) {
        const row = hapus.closest('.row-input');
        row.querySelector('input[name^="latitude"]').value = '';
        row.querySelector('input[name^="longitude"]').value = '';
        row.querySelector('.koordinat-teks').textContent = 'Belum dipilih';
        return;
    }

    const tambahDok = e.target.closest('.btn-tambah-dokumen');
    if (tambahDok) {
        const row = tambahDok.closest('.row-input');
        const idx = row.dataset.index;
        const div = document.createElement('div');
        div.className = 'd-flex gap-2 mb-1 dokumen-item';
        div.innerHTML = `<input type="text" name="dokumen_nama[${idx}][]" class="form-control form-control-sm" placeholder="cth: SLO">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-dokumen">Hapus</button>`;
        row.querySelector('.dokumen-list').appendChild(div);
        return;
    }

    const hapusDok = e.target.closest('.btn-hapus-dokumen');
    if (hapusDok) {
        hapusDok.closest('.dokumen-item').remove();
        return;
    }

    const btn = e.target.closest('.btn-pilih-peta');
    if (!btn) return;
    petaRow = btn.closest('.row-input');
    bootstrap.Modal.getOrCreateInstance(petaModalEl).show();
});

// Leaflet harus dihitung ulang ukurannya setelah modal benar-benar tampil
petaModalEl.addEventListener('shown.bs.modal', function () {
    if (!petaMap) {
        petaMap = L.map('petaCanvas').setView(PETA_AWAL, 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap',
        }).addTo(petaMap);
        petaMap.on('click', function (e) { setTitik(e.latlng.lat, e.latlng.lng); });
    }
    petaMap.invalidateSize();
    resetTitik();

    // Kalau baris ini sudah punya koordinat, langsung tampilkan

    const lat = parseFloat(petaRow.querySelector('input[name^="latitude"]').value);
    const lng = parseFloat(petaRow.querySelector('input[name^="longitude"]').value);
    if (!isNaN(lat) && !isNaN(lng)) {
        petaMap.setView([lat, lng], 14);
        setTitik(lat, lng);
    } else {
        petaMap.setView(PETA_AWAL, 8);
    }
});

let petaTimer = null, petaAbort = null;

function labelHasil(p) {
    const bagian = [p.name, p.street, p.district, p.city, p.county, p.state];
    // buang bagian kosong dan yang dobel
    return bagian.filter((v, i) => v && bagian.indexOf(v) === i).join(', ');
}

async function cariLokasi() {
    const q = document.getElementById('petaCari').value.trim();
    const box = document.getElementById('petaHasil');

    if (q.length < 3) { box.innerHTML = ''; return; }

    // batalkan pencarian sebelumnya yang belum selesai
    if (petaAbort) petaAbort.abort();
    petaAbort = new AbortController();
    box.textContent = 'Mencari...';

    try {
        const url = 'https://photon.komoot.io/api/?limit=10&lat=4.6951&lon=96.7494&q=' + encodeURIComponent(q);
        const res = await fetch(url, { signal: petaAbort.signal });
        if (!res.ok) throw new Error('gagal');
        const data = await res.json();

        const hasil = (data.features || []).filter(f => f.properties.countrycode === 'ID');
        box.innerHTML = '';

        if (!hasil.length) {
            box.textContent = 'Tempat tidak ditemukan. Coba kata lain, atau klik langsung di peta.';
            return;
        }

        hasil.forEach(function (f) {
            const [lon, lat] = f.geometry.coordinates; // Photon: urutannya [longitude, latitude]
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action small';
            item.textContent = labelHasil(f.properties);
            item.addEventListener('click', function () {
                petaMap.setView([lat, lon], 15);
                setTitik(lat, lon);
                box.innerHTML = '';
            });
            box.appendChild(item);
        });
    } catch (err) {
        if (err.name === 'AbortError') return; // pencarian lama dibatalkan, itu normal
        box.textContent = 'Pencarian gagal. Klik langsung di peta saja.';
    }
}

// Cari otomatis 0,4 detik setelah berhenti mengetik
document.getElementById('petaCari').addEventListener('input', function () {
    clearTimeout(petaTimer);
    petaTimer = setTimeout(cariLokasi, 400);
});

// Tombol Cari dan Enter tetap jalan, langsung tanpa menunggu
document.getElementById('petaCariBtn').addEventListener('click', cariLokasi);
document.getElementById('petaCari').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        clearTimeout(petaTimer);
        cariLokasi();
    }
});

document.getElementById('petaLokasiSaya').addEventListener('click', function () {
    if (!navigator.geolocation) { alert('Browser tidak mendukung lokasi.'); return; }
    navigator.geolocation.getCurrentPosition(function (pos) {
        petaMap.setView([pos.coords.latitude, pos.coords.longitude], 16);
        setTitik(pos.coords.latitude, pos.coords.longitude);
    }, function () { alert('Tidak bisa mengambil lokasi. Izinkan akses lokasi di browser.'); });
});

document.getElementById('petaGunakan').addEventListener('click', function () {
    if (petaLat === null || !petaRow) return;
    petaRow.querySelector('input[name^="latitude"]').value = petaLat;
    petaRow.querySelector('input[name^="longitude"]').value = petaLng;
    petaRow.querySelector('.koordinat-teks').textContent = petaLat + ', ' + petaLng;
    bootstrap.Modal.getInstance(petaModalEl).hide();
});

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
        const idx = armadaIndexCounter++;
        const html = `
        <div class="row-input row g-2 align-items-end" data-index="${idx}">
            <div class="col-md-3">
                <label class="field-label">Nama Kapal</label>
                <input type="text" name="nama_armada[${idx}]" class="form-control" placeholder="cth: KM Sinar Laut">
            </div>
            <div class="col-md-2">
                <label class="field-label">Tanggal Berangkat</label>
                <input type="date" name="tanggal_berangkat[${idx}]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="field-label">Jenis Alat Tangkap / API</label>
                <input type="text" name="jenis_alat_tangkap[${idx}]" class="form-control" placeholder="cth: Rawai Dasar">
            </div>
            <div class="col-md-2">
                <label class="field-label">Ukuran Kapal (GT)</label>
                <input type="text" name="ukuran_kapal[${idx}]" class="form-control" placeholder="cth: < 5">
            </div>
            <div class="col-md-2">
                <label class="field-label">Jumlah ABK (Org)</label>
                <input type="number" step="0.01" name="jumlah_abk[${idx}]" class="form-control">
            </div>

            <div class="col-md-12">
                <label class="field-label">Dokumen Trip (bebas diisi: SLO, SPB, CV, dll)</label>
                <div class="dokumen-list"></div>
                <button type="button" class="btn btn-sm btn-outline-secondary btn-tambah-dokumen mt-1">+ Tambah Dokumen</button>
            </div>

            <div class="col-md-4">
                <label class="field-label">Foto Kapal</label>
                <input type="file" name="foto[${idx}]" class="form-control" accept="image/*">
            </div>
            <div class="col-md-3">
                <label class="field-label">Lokasi</label>
                <input type="text" name="lokasi_foto[${idx}]" class="form-control" placeholder="cth: Dermaga Lampulo">
            </div>

            <div class="col-md-4">
                <label class="field-label">Titik Koordinat</label>
                <input type="hidden" name="latitude[${idx}]">
                <input type="hidden" name="longitude[${idx}]">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm btn-pilih-peta">📍 Pilih di Peta</button>
                    <button type="button" class="btn btn-link btn-sm text-danger p-0 btn-hapus-titik">Hapus titik</button>
                </div>
                <div class="small text-muted mt-1 koordinat-teks">Belum dipilih</div>
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
            <div class="col-md-3">
                <label class="field-label">Tujuan (Kabupaten/Provinsi/Negara)</label>
                <input type="text" name="tujuan[]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="field-label">Nama PT (opsional)</label>
                <input type="text" name="nama_pt[]" class="form-control" placeholder="cth: PT Samudra Jaya">
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