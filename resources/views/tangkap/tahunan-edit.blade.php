<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Tahunan - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
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
        .nelayan-preview { font-size: 13px; color: #0369a1; font-weight: 600; margin-top: 10px; }
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
        <a href="{{ route('tangkap.tahunan.input', $kabupaten->id) }}" class="back-btn">&larr;</a>
        <div>
            <span class="kab-badge">{{ $kabupaten->nama_kabupaten }}</span>
            <h2 class="fw-bold mb-1">Edit Data Tahunan</h2>
            <p class="text-muted mb-0">Ubah rekap tahun ini.</p>
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

    <form method="POST" action="{{ route('tangkap.tahunan.update', $tahunan->id) }}">
        @csrf
        @method('PUT')

        <div class="form-card mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $tahunan->tahun) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Pelabuhan</label>
                    <select name="pelabuhan_id" class="form-select input-pelabuhan" required>
                        @foreach ($pelabuhanList as $p)
                            <option value="{{ $p->id }}" data-jenis-lk="{{ $p->jenis_lk }}" {{ old('pelabuhan_id', $tahunan->pelabuhan_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis LK <span class="text-muted" style="font-weight:400;">(otomatis)</span></label>
                    <select name="jenis_lk" class="form-select input-jenis-lk" required style="pointer-events:none; background:#e9ecef;" tabindex="-1">
                        <option value="Pelabuhan" {{ old('jenis_lk', $tahunan->jenis_lk) == 'Pelabuhan' ? 'selected' : '' }}>Pelabuhan</option>
                        <option value="Non Pelabuhan" {{ old('jenis_lk', $tahunan->jenis_lk) == 'Non Pelabuhan' ? 'selected' : '' }}>Non Pelabuhan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">WPPNRI</label>
                    <select name="wppnri_id" class="form-select" required>
                        @foreach ($wppnriList as $w)
                            <option value="{{ $w->id }}" {{ old('wppnri_id', $tahunan->wppnri_id) == $w->id ? 'selected' : '' }}>{{ $w->kode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori Ukuran Kapal</label>
                    <select name="kategori_ukuran_kapal_id" class="form-select" required>
                        @foreach ($kategoriKapalList as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_ukuran_kapal_id', $tahunan->kategori_ukuran_kapal_id) == $k->id ? 'selected' : '' }}>{{ $k->label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis API</label>
                    <select name="jenis_api_id" class="form-select" required>
                        @foreach ($jenisApiList as $a)
                            <option value="{{ $a->id }}" {{ old('jenis_api_id', $tahunan->jenis_api_id) == $a->id ? 'selected' : '' }}>{{ $a->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah RTP</label>
                    <input type="number" min="0" id="editRtp" name="jumlah_rtp" class="form-control" value="{{ old('jumlah_rtp', $tahunan->jumlah_rtp) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah Kapal</label>
                    <input type="number" min="0" name="jumlah_kapal" class="form-control" value="{{ old('jumlah_kapal', $tahunan->jumlah_kapal) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah API</label>
                    <input type="number" min="0" name="jumlah_api" class="form-control" value="{{ old('jumlah_api', $tahunan->jumlah_api) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nelayan Buruh</label>
                    <input type="number" min="0" id="editBuruh" name="jumlah_nelayan_buruh" class="form-control" value="{{ old('jumlah_nelayan_buruh', $tahunan->jumlah_nelayan_buruh) }}" required>
                </div>
            </div>
            <div id="previewNelayan" class="nelayan-preview">Total Nelayan: {{ $tahunan->jumlah_nelayan }}</div>
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('tangkap.tahunan.input', $kabupaten->id) }}" class="btn-outline-custom">Batal</a>
            <button type="submit" class="btn-dark-custom">Simpan Perubahan</button>
        </div>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const pelabuhanSelect = document.querySelector('.input-pelabuhan');
    const jenisLkSelect = document.querySelector('.input-jenis-lk');
    pelabuhanSelect.addEventListener('change', function () {
        const opt = pelabuhanSelect.options[pelabuhanSelect.selectedIndex];
        jenisLkSelect.value = opt ? (opt.getAttribute('data-jenis-lk') || '') : '';
    });

    const rtpInput = document.getElementById('editRtp');
    const buruhInput = document.getElementById('editBuruh');
    const preview = document.getElementById('previewNelayan');
    function updatePreview() {
        const rtp = parseInt(rtpInput.value) || 0;
        const buruh = parseInt(buruhInput.value) || 0;
        preview.textContent = 'Total Nelayan: ' + (rtp + buruh).toLocaleString('id-ID');
    }
    rtpInput.addEventListener('input', updatePreview);
    buruhInput.addEventListener('input', updatePreview);
</script>

</body>
</html>
