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

        .armada-card { border: 2px solid #cbd5e1; border-radius: 14px; padding: 16px; margin-bottom: 20px; background: #fff; }
        .armada-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .armada-judul { font-weight: 700; font-size: 15px; color: var(--clr-dark); }
        .btn-hapus-kapal { background: #fff; border: 1px solid #dc2626; color: #dc2626; border-radius: 8px; font-size: 12.5px; font-weight: 600; padding: 4px 12px; }
        .btn-hapus-kapal:hover { background: #dc2626; color: #fff; }
        .sub-block { margin-top: 14px; padding-top: 10px; border-top: 1px dashed #cbd5e1; }
        .sub-title { font-weight: 700; font-size: 13.5px; margin-bottom: 8px; }
        .sub-hint { font-weight: 400; font-size: 12px; color: #64748b; }
        .warn-inline { font-size: 11.5px; color: #b45309; margin-top: 2px; display: none; }
        .is-suspect { border-color: #f59e0b !important; background: #fffbeb; }
        #tabelRingkasan th, #tabelRingkasan td { font-size: 13px; padding: 4px 8px; }
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
            <span class="brand-text">SAMUDRA ACEH</span>
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

        <form method="POST" action="{{ $laporan ? route('laporan-operasional.update', $laporan) : route('laporan-operasional.store', $kabupaten->id) }}" enctype="multipart/form-data" id="formLaporan" novalidate>
        <datalist id="daftarIkan">
            @foreach ($ikanList as $ikan)
                <option value="{{ $ikan }}"></option>
            @endforeach
        </datalist>
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

        {{-- KAPAL: produksi, logistik, dan pemasaran ada di dalam tiap kapal --}}
        @php
            $kosongKapal = fn ($i) => [
                'i' => $i, 'nama' => '', 'berangkat' => '', 'pulang' => '', 'alat' => '', 'ukuran' => '', 'abk' => '',
                'dokumen' => [], 'foto_lama' => '', 'lokasi' => '', 'lat' => '', 'lng' => '',
                'produksi' => [], 'logistik' => [], 'pemasaran' => [],
            ];

            $armadaList = [];
            $idxLama = [];
            foreach (['ukuran_kapal', 'nama_armada', 'jenis_ikan', 'nama_item', 'jenis_ikan_pemasaran'] as $f) {
                $idxLama = array_merge($idxLama, array_keys((array) old($f, [])));
            }
            $idxLama = array_values(array_unique($idxLama));
            sort($idxLama);

            if (count($idxLama)) {
                // Form dikembalikan setelah gagal validasi: pakai isian terakhir pengguna
                foreach ($idxLama as $i) {
                    $k = $kosongKapal($i);
                    $k['nama'] = old("nama_armada.$i");
                    $k['berangkat'] = old("tanggal_berangkat.$i");
                    $k['pulang'] = old("tanggal_pulang.$i");
                    $k['alat'] = old("jenis_alat_tangkap.$i");
                    $k['ukuran'] = old("ukuran_kapal.$i");
                    $k['abk'] = old("jumlah_abk.$i");
                    $k['dokumen'] = array_values((array) old("dokumen_nama.$i", []));
                    $k['foto_lama'] = old("foto_lama.$i");
                    $k['lokasi'] = old("lokasi_foto.$i");
                    $k['lat'] = old("latitude.$i");
                    $k['lng'] = old("longitude.$i");
                    foreach ((array) old("jenis_ikan.$i", []) as $j => $v) {
                        $k['produksi'][] = ['jenis' => $v, 'kg' => old("produksi_kg.$i.$j"), 'harga' => old("harga_rp.$i.$j")];
                    }
                    foreach ((array) old("nama_item.$i", []) as $j => $v) {
                        $k['logistik'][] = ['nama' => $v, 'jumlah' => old("jumlah_logistik.$i.$j"), 'satuan' => old("satuan.$i.$j"), 'harga' => old("harga_logistik.$i.$j"), 'total' => old("total_logistik.$i.$j")];
                    }
                    foreach ((array) old("jenis_ikan_pemasaran.$i", []) as $j => $v) {
                        $k['pemasaran'][] = ['kategori' => old("kategori_pemasaran.$i.$j", 'Lokal'), 'jenis' => $v, 'qty' => old("quantity_kg.$i.$j"), 'tujuan' => old("tujuan.$i.$j"), 'nama_pt' => old("nama_pt.$i.$j")];
                    }
                    $armadaList[] = $k;
                }
            } elseif ($laporan) {
                foreach ($laporan->armadaTangkap as $n => $row) {
                    $k = $kosongKapal($n);
                    $k['nama'] = $row->nama_armada;
                    $k['berangkat'] = optional($row->tanggal_berangkat)->format('Y-m-d');
                    $k['pulang'] = optional($row->tanggal_pulang)->format('Y-m-d');
                    $k['alat'] = $row->jenis_alat_tangkap;
                    $k['ukuran'] = $row->ukuran_kapal;
                    $k['abk'] = $row->jumlah_abk;
                    $k['dokumen'] = $row->dokumens->pluck('nama_dokumen')->all();
                    $k['foto_lama'] = optional($row->foto)->foto;
                    $k['lokasi'] = optional($row->foto)->lokasi;
                    $k['lat'] = $row->latitude;
                    $k['lng'] = $row->longitude;
                    $k['produksi'] = $row->produksiIkan->map(fn ($x) => ['jenis' => $x->jenis_ikan, 'kg' => $x->produksi_kg, 'harga' => $x->harga_rp])->all();
                    $k['logistik'] = $row->logistik->map(fn ($x) => ['nama' => $x->nama_item, 'jumlah' => $x->jumlah, 'satuan' => $x->satuan, 'harga' => $x->harga_rp, 'total' => $x->total_rp])->all();
                    $k['pemasaran'] = $row->pemasaran->map(fn ($x) => ['kategori' => $x->kategori, 'jenis' => $x->jenis_ikan, 'qty' => $x->quantity_kg, 'tujuan' => $x->tujuan, 'nama_pt' => $x->nama_pt])->all();
                    $armadaList[] = $k;
                }

                // Data lama yang belum terhubung ke kapal manapun: taruh di kapal pertama supaya tidak hilang saat disimpan
                $yatimProduksi = $laporan->produksiIkan->whereNull('laporan_armada_tangkap_id');
                $yatimLogistik = $laporan->logistik->whereNull('laporan_armada_tangkap_id');
                $yatimPemasaran = $laporan->pemasaran->whereNull('laporan_armada_tangkap_id');
                if ($yatimProduksi->count() || $yatimLogistik->count() || $yatimPemasaran->count()) {
                    if (! count($armadaList)) { $armadaList[] = $kosongKapal(0); }
                    foreach ($yatimProduksi as $x) { $armadaList[0]['produksi'][] = ['jenis' => $x->jenis_ikan, 'kg' => $x->produksi_kg, 'harga' => $x->harga_rp]; }
                    foreach ($yatimLogistik as $x) { $armadaList[0]['logistik'][] = ['nama' => $x->nama_item, 'jumlah' => $x->jumlah, 'satuan' => $x->satuan, 'harga' => $x->harga_rp, 'total' => $x->total_rp]; }
                    foreach ($yatimPemasaran as $x) { $armadaList[0]['pemasaran'][] = ['kategori' => $x->kategori, 'jenis' => $x->jenis_ikan, 'qty' => $x->quantity_kg, 'tujuan' => $x->tujuan, 'nama_pt' => $x->nama_pt]; }
                }
            }

            if (! count($armadaList)) {
                $armadaList[] = $kosongKapal(0); // form baru: langsung ada satu kotak kapal
            }
            $armadaNext = max(array_map(fn ($x) => (int) $x['i'], $armadaList)) + 1;
        @endphp

        <div class="panel-card">
            <div class="section-title">Data Kapal, Produksi, Logistik &amp; Pemasaran</div>
            <div class="section-sub">Satu kotak = satu kapal/trip. Produksi, logistik, dan pemasaran diisi di dalam kotak kapalnya. Kalau kapal dihapus, semua isi di dalam kotaknya ikut terhapus.</div>
            <div id="armadaContainer">
                @foreach ($armadaList as $a)
                    @include('tangkap.laporan-operasional._armada-card', ['a' => $a])
                @endforeach
            </div>
            <button type="button" class="btn-add-row mt-2" onclick="addArmadaRow()">+ Tambah Kapal / Trip</button>
        </div>

        {{-- Cetakan baris baru (dipakai JavaScript; tidak ikut terkirim) --}}
        <template id="tplArmada">@include('tangkap.laporan-operasional._armada-card', ['a' => $kosongKapal('__I__')])</template>
        <template id="tplProduksi">@include('tangkap.laporan-operasional._baris-produksi', ['i' => '__I__', 'r' => []])</template>
        <template id="tplLogistik">@include('tangkap.laporan-operasional._baris-logistik', ['i' => '__I__', 'r' => []])</template>
        <template id="tplPemasaran">@include('tangkap.laporan-operasional._baris-pemasaran', ['i' => '__I__', 'r' => []])</template>

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

<div class="modal fade" id="modalKonfirmasi" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apakah pengisian sudah benar?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="small text-muted mb-2">Periksa kembali ukuran kapal, produksi (Kg), harga, dan nama ikan. Data yang sudah disimpan menjadi dasar laporan resmi.</p>
                <div id="konfirmPeringatan"></div>
                <div id="tabelRingkasan" class="table-responsive"></div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="cekBenar">
                    <label class="form-check-label small" for="cekBenar">
                        Saya menyatakan data di atas sudah saya periksa dan benar sesuai kondisi sebenarnya.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Periksa Lagi</button>
                <button type="button" class="btn btn-dark" id="btnSimpanFinal" disabled>Ya, Data Sudah Benar &amp; Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    let petaMap = null, petaMarker = null, petaRow = null, petaLat = null, petaLng = null;
    let armadaIndexCounter = {{ $armadaNext }};
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

    // ================= Pilihan API (sama dengan portal Produksi) =================
    const DAFTAR_API = @json($jenisApiList);
    function apiOptionsHtml() {
        return '<option value="">-- Pilih API --</option>' +
            DAFTAR_API.map(n => `<option value="${String(n).replace(/"/g, '&quot;')}">${n}</option>`).join('');
    }

    // ================= Validasi & peringatan pengisian =================
    const BATAS = {
        gtMax: 200,            // GT di atas ini dianggap tidak wajar untuk kapal ikan
        abkMax: 60,
        lamaTripMaxHari: 60,
        kgMax: 10000,          // per baris, 10 ton
        hargaMin: 1000, hargaMax: 500000,   // Rp/kg
        nilaiMax: 1000000000,  // Rp 1 miliar per baris
    };
    const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');

    function daftarIkanValid() {
        return Array.from(document.querySelectorAll('#daftarIkan option')).map(o => o.value);
    }
    function jarak(a, b) { // Levenshtein sederhana untuk menebak salah ketik
        const m = a.length, n = b.length, d = [];
        for (let i = 0; i <= m; i++) d[i] = [i];
        for (let j = 1; j <= n; j++) d[0][j] = j;
        for (let i = 1; i <= m; i++) for (let j = 1; j <= n; j++)
            d[i][j] = Math.min(d[i-1][j] + 1, d[i][j-1] + 1, d[i-1][j-1] + (a[i-1] === b[j-1] ? 0 : 1));
        return d[m][n];
    }
    function tebakIkan(nama) {
        const q = nama.toLowerCase();
        let terbaik = null, skor = 99;
        daftarIkanValid().forEach(v => {
            const s = jarak(q, v.toLowerCase());
            if (s < skor) { skor = s; terbaik = v; }
        });
        return skor <= Math.max(2, Math.floor(q.length / 4)) ? terbaik : null;
    }

    function tandai(input, pesan) {
        const box = input.parentElement.querySelector('.warn-inline');
        input.classList.toggle('is-suspect', !!pesan);
        if (box) { box.textContent = pesan ? '⚠ ' + pesan : ''; box.style.display = pesan ? 'block' : 'none'; }
    }

    function cekUkuran(v) {
        v = v.trim();
        if (!v) return null;
        const angka = (v.match(/\d+([.,]\d+)?/g) || []).map(x => parseFloat(x.replace(',', '.')));
        if (!angka.length) return 'Ukuran kapal tidak berisi angka. Pastikan sudah benar (cth: 5, < 5, 6 - 10).';
        const maks = Math.max(...angka);
        if (maks === 0) return 'Ukuran kapal 0 GT, apakah sudah benar?';
        if (maks > BATAS.gtMax) return `Ukuran ${maks} GT sangat besar untuk kapal ikan. Apakah sudah benar?`;
        return null;
    }
    function cekAbk(v) {
        const n = parseFloat(v);
        if (isNaN(n)) return null;
        if (n > BATAS.abkMax) return `${n} ABK sangat banyak. Apakah sudah benar?`;
        return null;
    }
    function cekKg(v) {
        const n = parseFloat(v);
        if (isNaN(n)) return null;
        if (n === 0) return 'Produksi 0 Kg. Apakah sudah benar?';
        if (n > BATAS.kgMax) return `${n.toLocaleString('id-ID')} Kg (${(n/1000).toLocaleString('id-ID')} ton) sangat besar untuk satu jenis ikan. Cek apakah ada angka nol berlebih.`;
        return null;
    }
    function cekHarga(v) {
        const n = parseFloat(v);
        if (isNaN(n)) return null;
        if (n < BATAS.hargaMin) return `Harga ${rp(n)}/Kg terlalu murah. Apakah sudah benar?`;
        if (n > BATAS.hargaMax) return `Harga ${rp(n)}/Kg terlalu mahal. Apakah sudah benar?`;
        return null;
    }
    function cekIkan(v) {
        v = v.trim();
        if (!v) return null;
        if (daftarIkanValid().some(x => x.toLowerCase() === v.toLowerCase())) return null;
        const saran = tebakIkan(v);
        return saran
            ? `"${v}" tidak ada di daftar ikan. Maksud Anda "${saran}"?`
            : `"${v}" tidak ada di daftar ikan. Periksa ejaan nama ikan.`;
    }
    function cekTanggal(row) {
        const b = row.querySelector('.input-berangkat').value;
        const p = row.querySelector('.input-pulang').value;
        if (!b || !p) return null;
        if (p < b) return { fatal: true, pesan: 'Tanggal pulang lebih awal dari tanggal berangkat.' };
        const hari = (new Date(p) - new Date(b)) / 86400000;
        if (hari > BATAS.lamaTripMaxHari) return { fatal: false, pesan: `Trip berlangsung ${hari} hari. Apakah sudah benar?` };
        return null;
    }

    // Peringatan langsung saat mengisi
    document.addEventListener('input', function (e) {
        const t = e.target, row = t.closest('.row-input');
        if (!row) return;
        if (t.matches('.input-ukuran')) tandai(t, cekUkuran(t.value));
        else if (t.matches('.input-abk')) tandai(t, cekAbk(t.value));
        else if (t.matches('.produksi-kg')) tandai(t, cekKg(t.value));
        else if (t.matches('.produksi-harga')) tandai(t, cekHarga(t.value));
        else if (t.matches('.input-ikan')) tandai(t, cekIkan(t.value));
    });
    document.addEventListener('change', function (e) {
        const t = e.target, row = t.closest('.row-input');
        if (!row) return;
        if (t.matches('.input-berangkat, .input-pulang')) {
            const b = row.querySelector('.input-berangkat'), p = row.querySelector('.input-pulang');
            p.min = b.value || '';
            const r = cekTanggal(row);
            tandai(p, r ? r.pesan : null);
        }
    });

    // Kumpulkan semua data + peringatan untuk dialog konfirmasi (dikelompokkan per kapal)
    function kumpulkan() {
        const peringatan = [], kapal = [];
        let fatal = false;

        document.querySelectorAll('#armadaContainer .armada-card').forEach((card, n) => {
            const row = card.querySelector('.armada-row');
            const namaIsi = row.querySelector('[name^="nama_armada"]').value.trim();
            const nama = namaIsi || ('Kapal ' + (n + 1));
            const ukuran = row.querySelector('.input-ukuran').value.trim();
            const abk = row.querySelector('.input-abk').value;
            const b = row.querySelector('.input-berangkat').value, p = row.querySelector('.input-pulang').value;
            const api = row.querySelector('.input-api').value;
            const pre = `<b>${nama}</b> › `;

            // --- Produksi
            const produksi = [], sudah = {};
            card.querySelectorAll('.produksi-row').forEach(r => {
                const ikan = r.querySelector('.input-ikan').value.trim();
                const kg = r.querySelector('.produksi-kg').value;
                const harga = r.querySelector('.produksi-harga').value;
                if (!ikan) return;
                const nilai = (parseFloat(kg) || 0) * (parseFloat(harga) || 0);
                produksi.push({ ikan, kg, harga, nilai });

                const k = ikan.toLowerCase();
                if (sudah[k]) peringatan.push(`${pre}<b>${ikan}</b> – diisi lebih dari satu kali di kapal ini. Apakah ada yang dobel?`);
                sudah[k] = true;

                if (kg === '' || harga === '') peringatan.push(`${pre}<b>${ikan}</b> – produksi (Kg) atau harga belum diisi, nilai produksi akan menjadi 0.`);
                [cekIkan(ikan), cekKg(kg), cekHarga(harga)].forEach(m => { if (m) peringatan.push(`${pre}<b>${ikan}</b> – ${m}`); });
                if (nilai > BATAS.nilaiMax) peringatan.push(`${pre}<b>${ikan}</b> – nilai produksi ${rp(nilai)} sangat besar. Cek Kg dan harganya.`);
            });

            // --- Logistik
            const logistik = [];
            card.querySelectorAll('.logistik-row').forEach(r => {
                const item = r.querySelector('[name^="nama_item"]').value.trim();
                const jumlah = r.querySelector('.logistik-jumlah').value;
                const satuan = r.querySelector('[name^="satuan"]').value.trim();
                const harga = r.querySelector('.logistik-harga').value;
                const totalIsi = r.querySelector('.logistik-total').value;
                if (!item) return;
                const total = totalIsi !== '' ? (parseFloat(totalIsi) || 0) : (parseFloat(jumlah) || 0) * (parseFloat(harga) || 0);
                logistik.push({ item, jumlah, satuan, total });
                if (jumlah === '') peringatan.push(`${pre}logistik <b>${item}</b> – jumlah belum diisi.`);
            });

            // --- Pemasaran
            const pemasaran = [], totalPemasaran = {};
            card.querySelectorAll('.pemasaran-row').forEach(r => {
                const kategori = r.querySelector('[name^="kategori_pemasaran"]').value;
                const ikan = r.querySelector('.input-ikan').value.trim();
                const qty = r.querySelector('.produksi-kg').value;
                const tujuan = r.querySelector('[name^="tujuan"]').value.trim();
                if (!ikan && qty === '' && !tujuan) return;
                const label = ikan || '(jenis ikan kosong)';
                pemasaran.push({ kategori, ikan: label, qty, tujuan });

                if (!ikan) peringatan.push(`${pre}pemasaran – jenis ikan belum diisi (tujuan: ${tujuan || '-'}).`);
                if (qty === '') peringatan.push(`${pre}pemasaran <b>${label}</b> – quantity (Kg) belum diisi.`);
                if (!tujuan) peringatan.push(`${pre}pemasaran <b>${label}</b> – tujuan belum diisi.`);
                [cekIkan(ikan), cekKg(qty)].forEach(m => { if (m) peringatan.push(`${pre}pemasaran <b>${label}</b> – ${m}`); });

                const k = ikan.toLowerCase();
                totalPemasaran[k] = (totalPemasaran[k] || 0) + (parseFloat(qty) || 0);
            });

            // Pemasaran dibandingkan dengan produksi kapal yang SAMA
            const totalProduksi = {};
            produksi.forEach(x => { const k = x.ikan.toLowerCase(); totalProduksi[k] = (totalProduksi[k] || 0) + (parseFloat(x.kg) || 0); });
            Object.keys(totalPemasaran).forEach(k => {
                if (!k) return;
                if (!(k in totalProduksi)) {
                    peringatan.push(`${pre}pemasaran <b>${k}</b> – tidak ada di produksi kapal ini. Apakah sudah benar?`);
                } else if (totalPemasaran[k] > totalProduksi[k]) {
                    peringatan.push(`${pre}pemasaran <b>${k}</b> – total ${totalPemasaran[k].toLocaleString('id-ID')} Kg melebihi produksi kapal ini (${totalProduksi[k].toLocaleString('id-ID')} Kg).`);
                }
            });

            // Kotak kapal yang benar-benar kosong dilewati
            if (!namaIsi && !ukuran && !produksi.length && !logistik.length && !pemasaran.length) return;

            if (!ukuran) peringatan.push(`${pre}ukuran kapal belum diisi.`);
            [cekUkuran(ukuran), cekAbk(abk)].forEach(m => { if (m) peringatan.push(`${pre}${m}`); });
            const tgl = cekTanggal(row);
            if (tgl) { peringatan.push(`${pre}${tgl.pesan}`); if (tgl.fatal) fatal = true; }

            kapal.push({ nama, b, p, api, ukuran, abk, produksi, logistik, pemasaran });
        });

        return { peringatan, kapal, fatal };
    }

    function isiModalKonfirmasi(d) {
        const w = document.getElementById('konfirmPeringatan');
        w.innerHTML = d.peringatan.length
            ? `<div class="alert alert-warning py-2 small"><b>Mohon dicek, ada ${d.peringatan.length} isian yang tampak tidak biasa:</b><ul class="mb-0 mt-1">` +
              d.peringatan.map(x => `<li>${x}</li>`).join('') + '</ul></div>'
            : '<div class="alert alert-success py-2 small mb-2">Tidak ada isian yang mencurigakan, tetapi tetap periksa ringkasan di bawah.</div>';

        let html = '', grandNilai = 0;
        d.kapal.forEach((k, n) => {
            html += `<div class="border rounded p-2 mb-3"><div class="fw-bold">Kapal ${n + 1}: ${k.nama}</div>` +
                `<div class="small text-muted mb-1">Berangkat ${k.b || '-'} · Pulang ${k.p || '-'} · API ${k.api || '-'} · Ukuran ${k.ukuran || '-'} GT · ABK ${k.abk || '-'}</div>`;

            if (k.produksi.length) {
                let total = 0;
                html += '<div class="fw-semibold small mt-2">Produksi Ikan</div><table class="table table-sm table-bordered mb-1"><thead><tr><th>Jenis Ikan</th><th class="text-end">Produksi (Kg)</th><th class="text-end">Harga/Kg</th><th class="text-end">Nilai</th></tr></thead><tbody>' +
                    k.produksi.map(x => { total += x.nilai; return `<tr><td>${x.ikan}</td><td class="text-end">${(parseFloat(x.kg) || 0).toLocaleString('id-ID')}</td><td class="text-end">${rp(parseFloat(x.harga) || 0)}</td><td class="text-end">${rp(x.nilai)}</td></tr>`; }).join('') +
                    `<tr class="fw-bold"><td colspan="3" class="text-end">Nilai kapal ini</td><td class="text-end">${rp(total)}</td></tr></tbody></table>`;
                grandNilai += total;
            }
            if (k.logistik.length) {
                let total = 0;
                html += '<div class="fw-semibold small mt-2">Logistik</div><table class="table table-sm table-bordered mb-1"><thead><tr><th>Kebutuhan</th><th class="text-end">Jumlah</th><th>Satuan</th><th class="text-end">Total</th></tr></thead><tbody>' +
                    k.logistik.map(x => { total += x.total; return `<tr><td>${x.item}</td><td class="text-end">${(parseFloat(x.jumlah) || 0).toLocaleString('id-ID')}</td><td>${x.satuan || '-'}</td><td class="text-end">${rp(x.total)}</td></tr>`; }).join('') +
                    `<tr class="fw-bold"><td colspan="3" class="text-end">Total logistik</td><td class="text-end">${rp(total)}</td></tr></tbody></table>`;
            }
            if (k.pemasaran.length) {
                html += '<div class="fw-semibold small mt-2">Pemasaran</div><table class="table table-sm table-bordered mb-1"><thead><tr><th>Kategori</th><th>Jenis Ikan</th><th class="text-end">Quantity (Kg)</th><th>Tujuan</th></tr></thead><tbody>' +
                    k.pemasaran.map(m => `<tr><td>${m.kategori}</td><td>${m.ikan}</td><td class="text-end">${(parseFloat(m.qty) || 0).toLocaleString('id-ID')}</td><td>${m.tujuan || '-'}</td></tr>`).join('') + '</tbody></table>';
            }
            html += '</div>';
        });
        if (d.kapal.length) html += `<div class="text-end fw-bold">Total nilai produksi semua kapal: ${rp(grandNilai)}</div>`;

        document.getElementById('tabelRingkasan').innerHTML = html || '<div class="small text-muted">Belum ada data kapal yang diisi.</div>';
        document.getElementById('cekBenar').checked = false;
        document.getElementById('btnSimpanFinal').disabled = true;
    }

    let sudahKonfirmasi = false;
    document.getElementById('formLaporan').addEventListener('submit', function (e) {
        if (sudahKonfirmasi) return;
        e.preventDefault();
        if (!this.reportValidity()) return;
        const d = kumpulkan();
        if (d.fatal) {
            alert('Tanggal pulang tidak boleh lebih awal dari tanggal berangkat. Perbaiki dulu sebelum menyimpan.');
            return;
        }
        isiModalKonfirmasi(d);
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalKonfirmasi')).show();
    });
    document.getElementById('cekBenar').addEventListener('change', function () {
        document.getElementById('btnSimpanFinal').disabled = !this.checked;
    });
    document.getElementById('btnSimpanFinal').addEventListener('click', function () {
        sudahKonfirmasi = true;
        document.getElementById('formLaporan').submit();
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

    // Cetakan baris dari <template> (tidak ada markup ganda di JavaScript)
    const TPL = {
        armada: document.getElementById('tplArmada').innerHTML,
        produksi: document.getElementById('tplProduksi').innerHTML,
        logistik: document.getElementById('tplLogistik').innerHTML,
        pemasaran: document.getElementById('tplPemasaran').innerHTML,
    };

    function nomoriKapal() {
        document.querySelectorAll('#armadaContainer .armada-card').forEach((c, n) => {
            c.querySelector('.armada-no').textContent = '#' + (n + 1);
        });
    }

    function addArmadaRow() {
        const idx = armadaIndexCounter++;
        document.getElementById('armadaContainer').insertAdjacentHTML('beforeend', TPL.armada.split('__I__').join(idx));
        nomoriKapal();
    }

    document.getElementById('armadaContainer').addEventListener('click', function (e) {
        // Tambah baris produksi / logistik / pemasaran di dalam kapal yang sama
        const tambah = e.target.closest('[data-tambah]');
        if (tambah) {
            const card = tambah.closest('.armada-card');
            const jenis = tambah.dataset.tambah;
            card.querySelector('.' + jenis + '-list').insertAdjacentHTML('beforeend', TPL[jenis].split('__I__').join(card.dataset.index));
            return;
        }

        // Hapus kapal: seluruh isi di dalam kotaknya ikut terhapus
        const hapus = e.target.closest('.btn-hapus-kapal');
        if (hapus) {
            const card = hapus.closest('.armada-card');
            const nama = card.querySelector('[name^="nama_armada"]').value.trim() || 'ini';
            const nP = card.querySelectorAll('.produksi-row').length;
            const nL = card.querySelectorAll('.logistik-row').length;
            const nM = card.querySelectorAll('.pemasaran-row').length;
            if (!confirm(`Hapus kapal "${nama}" beserta ${nP} baris produksi, ${nL} baris logistik, dan ${nM} baris pemasarannya?`)) return;
            card.remove();
            nomoriKapal();
        }
    });

    nomoriKapal();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>