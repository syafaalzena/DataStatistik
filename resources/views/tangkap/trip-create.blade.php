<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Trip - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
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
        .row-trip { border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 14px; position: relative; background: #fafafa; }
        .row-trip .row-title { font-weight: 600; font-size: 13px; color: #64748b; margin-bottom: 10px; }
        .btn-remove-row { position: absolute; top: 10px; right: 10px; background: none; border: none; color: #dc2626; font-weight: 600; font-size: 13px; }
        .btn-remove-row:hover { text-decoration: underline; }
        .btn-add-row { background: #e0f2fe; color: #0369a1; border: 1px dashed #7dd3fc; border-radius: 8px; font-weight: 600; padding: 10px 16px; width: 100%; }
        .btn-add-row:hover { background: #bae6fd; }
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
        <a href="{{ route('tangkap.trip.input', $kabupaten->id) }}" class="back-btn">&larr;</a>
        <div>
            <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
            <h2 class="fw-bold mb-1">Tambah Data Trip</h2>
            <p class="text-muted mb-0">Catat tiap kapal yang pulang melaut — boleh beberapa kejadian sekaligus dengan tanggal berbeda-beda.</p>
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

    @if($pelabuhanList->isEmpty())
        <div class="alert alert-warning">Belum ada pelabuhan terdaftar untuk kabupaten ini. Tambahkan dulu lewat halaman Data Produksi.</div>
    @endif

    <form method="POST" action="{{ route('tangkap.trip.store', $kabupaten->id) }}">
        @csrf

        <div id="rowsWrapper"></div>

        <button type="button" class="btn-add-row mb-4" onclick="tambahBaris()">+ Tambah Baris Trip</button>

        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('tangkap.trip.input', $kabupaten->id) }}" class="btn-outline-custom">Batal</a>
            <button type="submit" class="btn-dark-custom">Simpan Semua Data</button>
        </div>
    </form>

</div>

<template id="rowTemplate">
    <div class="row-trip">
        <button type="button" class="btn-remove-row" onclick="hapusBaris(this)">Hapus</button>
        <div class="row-title">Baris Trip</div>
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
                <label class="form-label">Jenis API</label>
                <select name="jenis_api_id[]" class="form-select" required>
                    <option value="">Pilih Jenis API</option>
                    @foreach ($jenisApiList as $a)
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
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
                <label class="form-label">Tanggal Kapal Pulang</label>
                <input type="date" name="tanggal[]" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jumlah Trip</label>
                <input type="number" min="1" name="jumlah_trip[]" class="form-control" value="1" required>
            </div>
        </div>
    </div>
</template>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const wrapper = document.getElementById('rowsWrapper');
    const template = document.getElementById('rowTemplate');

    function tambahBaris() {
        const clone = template.content.cloneNode(true);
        const rowEl = clone.querySelector('.row-trip');

        const pelabuhanSelect = rowEl.querySelector('.input-pelabuhan');
        const jenisLkSelect = rowEl.querySelector('.input-jenis-lk');

        pelabuhanSelect.addEventListener('change', function () {
            const opt = pelabuhanSelect.options[pelabuhanSelect.selectedIndex];
            jenisLkSelect.value = opt ? (opt.getAttribute('data-jenis-lk') || '') : '';
        });

        wrapper.appendChild(rowEl);
    }

    function hapusBaris(btn) {
        const rows = wrapper.querySelectorAll('.row-trip');
        if (rows.length <= 1) {
            alert('Minimal harus ada 1 baris trip.');
            return;
        }
        btn.closest('.row-trip').remove();
    }

    tambahBaris();
</script>

</body>
</html>