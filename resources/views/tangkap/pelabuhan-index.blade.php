<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelabuhan - {{ $kabupaten->nama_kabupaten }} - SIDKP</title>
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
        .riwayat-table td { vertical-align: middle; font-size: 13px; }
        .btn-delete-sm { background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; }
        .btn-delete-sm:hover { text-decoration: underline; }
        .empty-state { text-align: center; padding: 40px 20px; color: #94a3b8; }
        .badge-lk-pelabuhan { background: #dcfce7; color: #166534; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
        .badge-lk-non { background: #fef3c7; color: #92400e; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
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
            <h2 class="fw-bold mb-1">Kelola Pelabuhan</h2>
            <p class="text-muted mb-0">Daftar pelabuhan/lokasi tempat pendaratan ikan untuk kabupaten ini.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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

    <div class="mb-4">
        <button type="button" class="btn-dark-custom" onclick="bukaTambah()">+ Tambah Pelabuhan</button>
    </div>

    <div class="riwayat-table mb-4">
        @if($pelabuhanList->isEmpty())
            <div class="empty-state">Belum ada pelabuhan untuk kabupaten ini. Klik "+ Tambah Pelabuhan" untuk mulai.</div>
        @else
            <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Pelabuhan</th>
                        <th>Jenis LK</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelabuhanList as $p)
                        <tr>
                            <td>{{ $p->nama }}</td>
                            <td>
                                @if($p->jenis_lk === 'Pelabuhan')
                                    <span class="badge-lk-pelabuhan">Pelabuhan</span>
                                @else
                                    <span class="badge-lk-non">Non Pelabuhan</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button"
                                    onclick="bukaEdit({{ $p->id }}, '{{ addslashes($p->nama) }}', '{{ $p->jenis_lk }}')"
                                    class="btn-delete-sm" style="color:#0f172a;">Edit</button>
                                <form method="POST" action="{{ route('pelabuhan.destroy', $p->id) }}"
                                      onsubmit="return confirm('Hapus pelabuhan ini?');" class="d-inline mb-0">
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
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function bukaTambah() {
        document.getElementById('formTambah').reset();
        document.getElementById('modalTambah').style.display = 'flex';
    }
    function tutupTambah() {
        document.getElementById('modalTambah').style.display = 'none';
    }
    function bukaEdit(id, nama, jenisLk) {
        document.getElementById('editNama').value = nama;
        document.getElementById('editJenisLk').value = jenisLk;
        document.getElementById('formEdit').action = '{{ url('/tangkap/pelabuhan') }}/' + id;
        document.getElementById('modalEdit').style.display = 'flex';
    }
    function tutupEdit() {
        document.getElementById('modalEdit').style.display = 'none';
    }
</script>

{{-- MODAL TAMBAH PELABUHAN --}}
<div id="modalTambah" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:24px; border-radius:8px; width:420px; max-width:90%;">
        <h5 style="margin-bottom:16px;">Tambah Pelabuhan</h5>
        <form id="formTambah" method="POST" action="{{ route('pelabuhan.store', $kabupaten->id) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Pelabuhan</label>
                <input type="text" name="nama" class="form-control" required placeholder="Contoh: PPI Lampulo">
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis LK</label>
                <select name="jenis_lk" class="form-select" required>
                    <option value="Pelabuhan">Pelabuhan</option>
                    <option value="Non Pelabuhan">Non Pelabuhan</option>
                </select>
                <div class="form-text">Pilih "Non Pelabuhan" untuk entri tangkapan di luar pelabuhan resmi (setara "-" di Excel).</div>
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn-outline-custom" onclick="tutupTambah()">Batal</button>
                <button type="submit" class="btn-dark-custom">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT PELABUHAN --}}
<div id="modalEdit" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:24px; border-radius:8px; width:420px; max-width:90%;">
        <h5 style="margin-bottom:16px;">Edit Pelabuhan</h5>
        <form id="formEdit" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Pelabuhan</label>
                <input type="text" id="editNama" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis LK</label>
                <select id="editJenisLk" name="jenis_lk" class="form-select" required>
                    <option value="Pelabuhan">Pelabuhan</option>
                    <option value="Non Pelabuhan">Non Pelabuhan</option>
                </select>
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn-outline-custom" onclick="tutupEdit()">Batal</button>
                <button type="submit" class="btn-dark-custom">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
