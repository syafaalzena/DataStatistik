<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Produksi Tangkap - SIDKP</title>

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

        .back-btn {
            width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;
            background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none;
            transition: all .2s ease; box-shadow: 0 2px 6px rgba(0,0,0,.05);
        }
        .back-btn:hover { transform: translateY(-2px); background: #0f172a; border-color: #0f172a; color: #fff; }

        .btn-logout-icon {
            background: transparent; border: 1.5px solid rgba(248,250,252,.25);
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .25s ease;
        }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }

        .panel-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); padding: 24px; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #e2e8f0; font-size: 14px; }

        .field-label { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 2px; display: block; }

        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 600; border: none; padding: 10px 22px; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }

        .row-input { border: 1px solid #eef0e8; border-radius: 10px; padding: 14px; margin-bottom: 10px; background: #fafaf7; }

        .btn-remove-row { background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; }
        .btn-remove-row:hover { text-decoration: underline; }

        .btn-add-row {
            background: none; border: 1.5px dashed #94a3b8; color: #475569;
            border-radius: 8px; padding: 8px 16px; font-weight: 600; font-size: 14px;
        }
        .btn-add-row:hover { background: #f1f5f9; }
        .btn-add-row.full { width: 100%; }

        .riwayat-table { border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.04); background: #fff; }
        .riwayat-table table { margin-bottom: 0; }
        .riwayat-table thead th { background: var(--clr-dark); color: #fff; font-weight: 600; border: none; font-size: 13px; white-space: nowrap; }
        .riwayat-table td { vertical-align: middle; font-size: 13px; white-space: nowrap; }

        .btn-delete-sm { background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; }
        .btn-delete-sm:hover { text-decoration: underline; }

        .empty-state { text-align: center; padding: 30px 20px; color: #94a3b8; }

        .section-title { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .section-sub { color: #64748b; font-size: 14px; margin-bottom: 16px; }
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
        <a href="{{ route('dashboard') }}" class="back-btn">&larr;</a>
        <div>
            <h2 class="fw-bold mb-1">Input Produksi Tangkap</h2>
            <p class="text-muted mb-0">Kelola data hasil tangkapan laut per pelabuhan.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    @if($pelabuhanList->isEmpty() || $wppnriList->isEmpty() || $jenisApiList->isEmpty() || $kategoriKapalList->isEmpty() || $komoditasList->isEmpty())
        <div class="alert alert-info">
            Sebelum input produksi, pastikan tabel master (pelabuhan, WPPNRI, jenis API, kategori ukuran kapal, komoditas ikan) sudah terisi minimal 1 baris.
        </div>
    @endif

    {{-- ================= FORM INPUT PRODUKSI ================= --}}
    <div class="panel-card mb-4">
        <div class="section-title">Input Produksi Bulanan</div>
        <div class="section-sub">Pilih bulan &amp; tahun, lalu isi satu baris per kombinasi pelabuhan &times; jenis ikan.</div>

        <form method="POST" action="{{ route('tangkap.produksi.store') }}">
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
                    <input type="number" name="tahun" class="form-control" value="{{ now()->year }}" min="1900" max="2100" required>
                </div>
            </div>

            <label class="form-label fw-semibold small">Rincian Produksi</label>
            <div id="produksiRows">
                <div class="row-input produksi-row">
                    <div class="row g-2 mb-2">
                        <div class="col-6 col-md-3">
                            <span class="field-label">Pelabuhan</span>
                            <select name="pelabuhan_id[]" class="form-select" required>
                                <option value="">Pilih Pelabuhan</option>
                                @foreach($pelabuhanList as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->kabupatenIkan->nama_kabupaten ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="field-label">WPPNRI</span>
                            <select name="wppnri_id[]" class="form-select" required>
                                <option value="">Pilih WPPNRI</option>
                                @foreach($wppnriList as $w)
                                    <option value="{{ $w->id }}">{{ $w->kode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="field-label">Jenis LK</span>
                            <select name="jenis_lk[]" class="form-select" required>
                                <option value="Pelabuhan" selected>Pelabuhan</option>
                                <option value="Non Pelabuhan">Non Pelabuhan</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="field-label">Jenis API</span>
                            <select name="jenis_api_id[]" class="form-select" required>
                                <option value="">Pilih Jenis API</option>
                                @foreach($jenisApiList as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 col-md-3">
                            <span class="field-label">Ukuran Kapal</span>
                            <select name="kategori_ukuran_kapal_id[]" class="form-select" required>
                                <option value="">Pilih Ukuran</option>
                                @foreach($kategoriKapalList as $k)
                                    <option value="{{ $k->id }}">{{ $k->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="field-label">Jenis Ikan</span>
                            <select name="komoditas_ikan_id[]" class="form-select" required>
                                <option value="">Pilih Ikan</option>
                                @foreach($komoditasList as $ik)
                                    <option value="{{ $ik->id }}">{{ $ik->nama_ikan }}{{ $ik->nama_latin ? ' ('.$ik->nama_latin.')' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="field-label">Volume (Kg)</span>
                            <input type="number" step="0.01" min="0" name="volume_produksi_kg[]" class="form-control" placeholder="Contoh: 25.5" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="field-label">Harga (Rp)</span>
                            <input type="number" step="1" min="0" name="harga_rp[]" class="form-control" placeholder="Contoh: 25000" required>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="button" class="btn-remove-row" onclick="removeRow(this)">Hapus baris</button>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap mb-3">
                <button type="button" class="btn-add-row" onclick="addProduksiRow()">+ Tambah Baris</button>
                <button type="button" class="btn-add-row" data-bs-toggle="modal" data-bs-target="#modalTambahIkan">+ Tambah Jenis Ikan Baru</button>
            </div>

            <button type="submit" class="btn-dark-custom">Simpan Produksi</button>
        </form>
    </div>

    {{-- ================= RIWAYAT ================= --}}
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari pelabuhan, jenis ikan, bulan, tahun...">
    </div>
    <div id="riwayatProduksi" class="riwayat-table mb-4">
        @if($dataProduksi->isEmpty())
            <div class="empty-state">Belum ada data produksi.</div>
        @else
            <div class="table-responsive">
            <table class="table table-hover text-center align-middle mb-0">
                <thead>
                    <tr>
                        <th>Bulan/Tahun</th>
                        <th>Triwulan</th>
                        <th>Semester</th>
                        <th>Kabupaten</th>
                        <th>Pelabuhan</th>
                        <th>WPPNRI</th>
                        <th>Jenis LK</th>
                        <th>Jenis API</th>
                        <th>Ukuran Kapal</th>
                        <th>Jenis Ikan</th>
                        <th>Nama Latin</th>
                        <th>Kode FAO</th>
                        <th>Kelompok SDI</th>
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
                            <td>TW {{ $d->triwulan }}</td>
                            <td>Smt {{ $d->semester }}</td>
                            <td>{{ $d->pelabuhan->kabupatenIkan->nama_kabupaten ?? '-' }}</td>
                            <td>{{ $d->pelabuhan->nama ?? '-' }}</td>
                            <td>{{ $d->wppnri->kode ?? '-' }}</td>
                            <td>{{ $d->jenis_lk ?? '-' }}</td>
                            <td>{{ $d->jenisApi->nama ?? '-' }}</td>
                            <td>{{ $d->kategoriUkuranKapal->label ?? '-' }}</td>
                            <td>{{ $d->komoditasIkan->nama_ikan ?? '-' }}</td>
                            <td><em>{{ $d->komoditasIkan->nama_latin ?? '-' }}</em></td>
                            <td>{{ $d->komoditasIkan->kode_fao ?? '-' }}</td>
                            <td>{{ $d->komoditasIkan->kelompok_sdi ?? '-' }}</td>
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

    function removeRow(btn) {
        const row = btn.closest('.row-input');
        const container = row.parentElement;
        if (container.querySelectorAll('.row-input').length > 1) {
            row.remove();
        } else {
            row.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
            row.querySelectorAll('input').forEach(el => el.value = '');
        }
    }

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
    searchInput.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#riwayatProduksi tbody tr').forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });
</script>

{{-- MODAL EDIT --}}
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

{{-- MODAL TAMBAH JENIS IKAN --}}
<div class="modal fade" id="modalTambahIkan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('komoditas-ikan.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Ikan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Nama Ikan</label>
                        <input type="text" name="nama_ikan" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Nama Latin</label>
                        <input type="text" name="nama_latin" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Kode FAO</label>
                        <input type="text" name="kode_fao" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Kelompok SDI</label>
                        <input type="text" name="kelompok_sdi" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>