<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Produksi - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
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

        .form-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 24px; }
        .row-produksi { border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 14px; position: relative; background: #fafafa; }
        .row-produksi .row-title { font-weight: 600; font-size: 13px; color: #64748b; margin-bottom: 10px; }
        .btn-remove-row { position: absolute; top: 10px; right: 10px; background: none; border: none; color: #dc2626; font-weight: 600; font-size: 13px; }
        .btn-remove-row:hover { text-decoration: underline; }
        .nilai-preview { font-size: 13px; color: #0369a1; font-weight: 600; margin-top: 6px; }
        .btn-add-row { background: #e0f2fe; color: #0369a1; border: 1px dashed #7dd3fc; border-radius: 8px; font-weight: 600; padding: 10px 16px; width: 100%; }
        .btn-add-row:hover { background: #bae6fd; }

        .ikan-suggestions { display: none; position: absolute; z-index: 30; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; max-height: 240px; overflow-y: auto; width: 100%; box-shadow: 0 6px 16px rgba(0,0,0,.1); margin-top: 2px; }
        .ikan-suggestions .item { padding: 8px 12px; cursor: pointer; font-size: 14px; }
        .ikan-suggestions .item:hover { background: #f1f5f9; }
        .ikan-suggestions .item .latin { color: #64748b; font-size: 12px; font-style: italic; }
        .ikan-suggestions .empty { padding: 8px 12px; color: #94a3b8; font-size: 13px; }
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
        <a href="{{ route('tangkap.input', $kabupaten->id) }}" class="back-btn">&larr;</a>
        <div>
            <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
            <h2 class="fw-bold mb-1">Tambah Data Produksi</h2>
            <p class="text-muted mb-0">Isi bulan/tahun, lalu tambahkan satu atau lebih baris hasil tangkapan.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tangkap.produksi.store', $kabupaten->id) }}">
        @csrf

        <div class="form-card mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select" required>
                        <option value="">Pilih Bulan</option>
                        @foreach (['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $label)
                            <option value="{{ $val }}" {{ old('bulan') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', date('Y')) }}" required>
                </div>
            </div>
        </div>

        <div id="rowsWrapper"></div>

        <button type="button" class="btn-add-row mb-4" onclick="tambahBaris()">+ Tambah Baris Produksi</button>

        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('tangkap.input', $kabupaten->id) }}" class="btn-outline-custom">Batal</a>
            <button type="submit" class="btn-dark-custom">Simpan Semua Data</button>
        </div>
    </form>

</div>

{{-- Template 1 baris produksi, di-clone lewat JS --}}
<template id="rowTemplate">
    <div class="row-produksi">
        <button type="button" class="btn-remove-row" onclick="hapusBaris(this)">Hapus</button>
        <div class="row-title">Baris Produksi</div>
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label">Pelabuhan</label>
                <select name="pelabuhan_id[]" class="form-select input-pelabuhan" required>
                    <option value="">Pilih Pelabuhan</option>
                    @foreach ($pelabuhanList as $p)
                        <option value="{{ $p->id }}" data-jenis-lk="{{ $p->jenis_lk }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis LK <span class="text-muted" style="font-weight:400;">(otomatis)</span></label>
                <select name="jenis_lk[]" class="form-select input-jenis-lk" required style="pointer-events:none; background:#e9ecef;" tabindex="-1">
                    <option value="">- pilih pelabuhan dulu -</option>
                    <option value="Pelabuhan">Pelabuhan</option>
                    <option value="Non Pelabuhan">Non Pelabuhan</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">WPPNRI</label>
                <select name="wppnri_id[]" class="form-select" required>
                    <option value="">Pilih WPPNRI</option>
                    @foreach ($wppnriList as $w)
                        <option value="{{ $w->id }}">{{ $w->kode }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kategori Ukuran Kapal</label>
                <select name="kategori_ukuran_kapal_id[]" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoriKapalList as $k)
                        <option value="{{ $k->id }}">{{ $k->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis API</label>
                <select name="jenis_api_id[]" class="form-select" required>
                    <option value="">Pilih Jenis API</option>
                    @foreach ($jenisApiList as $a)
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 position-relative">
                <label class="form-label">Jenis Ikan</label>
                <input type="text" class="form-control input-ikan-search" placeholder="Ketik nama ikan..." autocomplete="off" required>
                <input type="hidden" name="komoditas_ikan_id[]" class="input-ikan-id" required>
                <div class="ikan-suggestions"></div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Volume Produksi (Kg)</label>
                <input type="number" step="0.01" min="0" name="volume_produksi_kg[]" class="form-control input-volume" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Harga (Rp/Kg)</label>
                <input type="number" step="1" min="0" name="harga_rp[]" class="form-control input-harga" required>
            </div>
        </div>
        <div class="nilai-preview">Nilai: Rp 0</div>
    </div>
</template>

@php
    $komoditasJs = $komoditasList->map(fn ($ik) => [
        'id' => $ik->id,
        'nama' => $ik->nama_ikan,
        'latin' => $ik->nama_latin,
    ]);
@endphp

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const wrapper = document.getElementById('rowsWrapper');
    const template = document.getElementById('rowTemplate');

    // Data 1.731 spesies ikan, dikirim sekali dari server untuk pencarian di sisi browser
    const KOMODITAS_IKAN = @json($komoditasJs);

    function cariIkan(keyword) {
        const kw = keyword.trim().toLowerCase();
        if (kw.length < 2) return [];
        return KOMODITAS_IKAN
            .filter(ik => ik.nama.toLowerCase().includes(kw) || (ik.latin && ik.latin.toLowerCase().includes(kw)))
            .slice(0, 50);
    }

    function setupIkanSearch(rowEl) {
        const searchInput = rowEl.querySelector('.input-ikan-search');
        const hiddenId = rowEl.querySelector('.input-ikan-id');
        const box = rowEl.querySelector('.ikan-suggestions');

        function renderResults(list) {
            box.innerHTML = '';
            if (list.length === 0) {
                box.innerHTML = '<div class="empty">Tidak ditemukan / ketik minimal 2 huruf</div>';
            } else {
                list.forEach(ik => {
                    const item = document.createElement('div');
                    item.className = 'item';
                    item.innerHTML = ik.nama + (ik.latin ? ' <span class="latin">(' + ik.latin + ')</span>' : '');
                    item.addEventListener('mousedown', function (e) {
                        e.preventDefault(); // supaya tidak keburu blur sebelum klik kepilih
                        searchInput.value = ik.nama + (ik.latin ? ' (' + ik.latin + ')' : '');
                        hiddenId.value = ik.id;
                        box.style.display = 'none';
                    });
                    box.appendChild(item);
                });
            }
            box.style.display = 'block';
        }

        searchInput.addEventListener('input', function () {
            hiddenId.value = ''; // reset pilihan lama begitu user ngetik ulang
            renderResults(cariIkan(searchInput.value));
        });
        searchInput.addEventListener('focus', function () {
            if (searchInput.value.trim().length >= 2) renderResults(cariIkan(searchInput.value));
        });
        document.addEventListener('click', function (e) {
            if (!rowEl.contains(e.target)) box.style.display = 'none';
        });
    }

    function tambahBaris() {
        const clone = template.content.cloneNode(true);
        const rowEl = clone.querySelector('.row-produksi');

        const volumeInput = rowEl.querySelector('.input-volume');
        const hargaInput = rowEl.querySelector('.input-harga');
        const preview = rowEl.querySelector('.nilai-preview');
        const pelabuhanSelect = rowEl.querySelector('.input-pelabuhan');
        const jenisLkSelect = rowEl.querySelector('.input-jenis-lk');

        pelabuhanSelect.addEventListener('change', function () {
            const opt = pelabuhanSelect.options[pelabuhanSelect.selectedIndex];
            jenisLkSelect.value = opt ? (opt.getAttribute('data-jenis-lk') || '') : '';
        });

        function updatePreview() {
            const v = parseFloat(volumeInput.value) || 0;
            const h = parseFloat(hargaInput.value) || 0;
            preview.textContent = 'Nilai: Rp ' + (v * h).toLocaleString('id-ID');
        }
        volumeInput.addEventListener('input', updatePreview);
        hargaInput.addEventListener('input', updatePreview);

        wrapper.appendChild(rowEl);
        // setupIkanSearch dipanggil setelah appendChild supaya rowEl sudah "hidup" di DOM
        setupIkanSearch(wrapper.lastElementChild);
    }

    function hapusBaris(btn) {
        const rows = wrapper.querySelectorAll('.row-produksi');
        if (rows.length <= 1) {
            alert('Minimal harus ada 1 baris produksi.');
            return;
        }
        btn.closest('.row-produksi').remove();
    }

    // Cegah submit kalau ada baris yang jenis ikannya belum benar-benar dipilih dari daftar
    document.querySelector('form').addEventListener('submit', function (e) {
        const kosong = wrapper.querySelectorAll('.input-ikan-id');
        for (const el of kosong) {
            if (!el.value) {
                e.preventDefault();
                alert('Ada baris yang "Jenis Ikan"-nya belum dipilih dari daftar saran. Ketik nama ikan lalu klik salah satu saran yang muncul.');
                el.closest('.row-produksi').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
        }
    });

    // Selalu mulai dengan 1 baris kosong
    tambahBaris();
</script>

</body>
</html>