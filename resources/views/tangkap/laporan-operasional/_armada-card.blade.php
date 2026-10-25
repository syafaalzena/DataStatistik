@php $i = $a['i']; @endphp
<div class="armada-card" data-index="{{ $i }}">
    <div class="armada-head">
        <div class="armada-judul">Kapal <span class="armada-no"></span></div>
        <button type="button" class="btn-hapus-kapal">Hapus Kapal beserta isinya</button>
    </div>

    <div class="row-input armada-row row g-2 align-items-end" data-index="{{ $i }}">
        <div class="col-md-2">
            <label class="field-label">Nama Kapal</label>
            <input type="text" name="nama_armada[{{ $i }}]" class="form-control" value="{{ $a['nama'] }}" placeholder="cth: KM Sinar Laut">
        </div>
        <div class="col-md-2">
            <label class="field-label">Tanggal Berangkat</label>
            <input type="date" name="tanggal_berangkat[{{ $i }}]" class="form-control input-berangkat" value="{{ $a['berangkat'] }}">
        </div>
        <div class="col-md-2">
            <label class="field-label">Tanggal Pulang</label>
            <input type="date" name="tanggal_pulang[{{ $i }}]" class="form-control input-pulang" value="{{ $a['pulang'] }}" min="{{ $a['berangkat'] }}">
            <div class="warn-inline"></div>
        </div>
        <div class="col-md-2">
            <label class="field-label">Jenis Alat Tangkap / API</label>
            <select name="jenis_alat_tangkap[{{ $i }}]" class="form-select input-api">
                <option value="">-- Pilih API --</option>
                @foreach ($jenisApiList as $api)
                    <option value="{{ $api }}" @selected($a['alat'] == $api)>{{ $api }}</option>
                @endforeach
                @if ($a['alat'] && ! $jenisApiList->contains($a['alat']))
                    <option value="{{ $a['alat'] }}" selected>{{ $a['alat'] }} (data lama)</option>
                @endif
            </select>
        </div>
        <div class="col-md-2">
            <label class="field-label">Ukuran Kapal (GT)</label>
            <input type="text" name="ukuran_kapal[{{ $i }}]" class="form-control input-ukuran" value="{{ $a['ukuran'] }}" placeholder="cth: < 5">
            <div class="warn-inline"></div>
        </div>
        <div class="col-md-2">
            <label class="field-label">Jumlah ABK (Org)</label>
            <input type="number" step="0.01" name="jumlah_abk[{{ $i }}]" class="form-control input-abk" value="{{ $a['abk'] }}">
            <div class="warn-inline"></div>
        </div>

        <div class="col-md-3">
            <label class="field-label">WPPNRI</label>
            <select name="wppnri_id[{{ $i }}]" class="form-select">
                <option value="">-- Pilih WPPNRI --</option>
                @foreach ($wppnriList as $w)
                    <option value="{{ $w->id }}" @selected($a['wppnri'] == $w->id)>{{ $w->kode }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label class="field-label">Dokumen Trip (bebas diisi: SLO, SPB, CV, dll)</label>
            <div class="dokumen-list">
                @foreach ($a['dokumen'] as $namaDok)
                    <div class="d-flex gap-2 mb-1 dokumen-item">
                        <input type="text" name="dokumen_nama[{{ $i }}][]" class="form-control form-control-sm" value="{{ $namaDok }}" placeholder="cth: SLO">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-dokumen">Hapus</button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-tambah-dokumen mt-1">+ Tambah Dokumen</button>
        </div>

        <div class="col-md-4">
            <label class="field-label">Foto Kapal</label>
            <input type="file" name="foto[{{ $i }}]" class="form-control" accept="image/*">
            <input type="hidden" name="foto_lama[{{ $i }}]" value="{{ $a['foto_lama'] }}">
            @if ($a['foto_lama'])
                <div class="small text-muted mt-1">
                    <img src="{{ Storage::url($a['foto_lama']) }}" style="height:40px;border-radius:6px;" class="me-1">
                    Foto sudah ada, upload baru untuk mengganti.
                </div>
            @endif
        </div>
        <div class="col-md-3">
            <label class="field-label">Lokasi</label>
            <input type="text" name="lokasi_foto[{{ $i }}]" class="form-control" value="{{ $a['lokasi'] }}" placeholder="cth: Dermaga Lampulo">
        </div>

        <div class="col-md-4">
            <label class="field-label">Titik Koordinat</label>
            <input type="hidden" name="latitude[{{ $i }}]" value="{{ $a['lat'] }}">
            <input type="hidden" name="longitude[{{ $i }}]" value="{{ $a['lng'] }}">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-pilih-peta">📍 Pilih di Peta</button>
                <button type="button" class="btn btn-link btn-sm text-danger p-0 btn-hapus-titik">Hapus titik</button>
                <div class="small text-muted mt-1 koordinat-teks">{{ ($a['lat'] !== null && $a['lat'] !== '' && $a['lng'] !== null && $a['lng'] !== '') ? $a['lat'] . ', ' . $a['lng'] : 'Belum dipilih' }}</div>
            </div>
        </div>
    </div>

    {{-- PRODUKSI --}}
    <div class="sub-block">
        <div class="sub-title">Produksi Ikan Dominan & Nilai Produksi</div>
        <div class="produksi-list">
            @foreach ($a['produksi'] as $r)
                @include('tangkap.laporan-operasional._baris-produksi', ['i' => $i, 'r' => $r])
            @endforeach
        </div>
        <button type="button" class="btn-add-row mt-1" data-tambah="produksi">+ Tambah Produksi</button>
    </div>

    {{-- LOGISTIK --}}
    <div class="sub-block">
        <div class="sub-title">Logistik <span class="sub-hint">(BBM, Air, Es, Garam, Oli, Gas, Ransum, dll)</span></div>
        <div class="logistik-list">
            @foreach ($a['logistik'] as $r)
                @include('tangkap.laporan-operasional._baris-logistik', ['i' => $i, 'r' => $r])
            @endforeach
        </div>
        <button type="button" class="btn-add-row mt-1" data-tambah="logistik">+ Tambah Logistik</button>
    </div>

    {{-- PEMASARAN --}}
    <div class="sub-block">
        <div class="sub-title">Data Pemasaran <span class="sub-hint">(lokal/regional maupun ekspor)</span></div>
        <div class="pemasaran-list">
            @foreach ($a['pemasaran'] as $r)
                @include('tangkap.laporan-operasional._baris-pemasaran', ['i' => $i, 'r' => $r])
            @endforeach
        </div>
        <button type="button" class="btn-add-row mt-1" data-tambah="pemasaran">+ Tambah Pemasaran</button>
    </div>
</div>
