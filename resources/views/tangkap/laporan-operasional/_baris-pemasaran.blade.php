@php
    $kategori = $r['kategori'] ?? 'Lokal';
    $jenis = $r['jenis'] ?? '';
    $qty = $r['qty'] ?? '';
    $tujuan = $r['tujuan'] ?? '';
    $namaPt = $r['nama_pt'] ?? '';
@endphp
<div class="row-input row g-2 align-items-end pemasaran-row">
    <div class="col-md-2">
        <label class="field-label">Kategori</label>
        <select name="kategori_pemasaran[{{ $i }}][]" class="form-select">
            <option value="Lokal" @selected($kategori == 'Lokal')>Lokal (Antar Kabupaten)</option>
            <option value="Regional" @selected($kategori == 'Regional')>Regional (Antar Provinsi)</option>
            <option value="Ekspor" @selected($kategori == 'Ekspor')>Ekspor</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="field-label">Jenis Ikan</label>
        <input type="text" name="jenis_ikan_pemasaran[{{ $i }}][]" class="form-control input-ikan" list="daftarIkan" autocomplete="off" value="{{ $jenis }}" placeholder="ketik / pilih nama ikan">
        <div class="warn-inline"></div>
    </div>
    <div class="col-md-2">
        <label class="field-label">Quantity (Kg)</label>
        <input type="number" step="0.01" name="quantity_kg[{{ $i }}][]" class="form-control produksi-kg" value="{{ $qty }}">
        <div class="warn-inline"></div>
    </div>
    <div class="col-md-2">
        <label class="field-label">Tujuan (Kab/Prov/Negara)</label>
        <input type="text" name="tujuan[{{ $i }}][]" class="form-control" value="{{ $tujuan }}">
    </div>
    <div class="col-md-2">
        <label class="field-label">Nama PT (opsional)</label>
        <input type="text" name="nama_pt[{{ $i }}][]" class="form-control" value="{{ $namaPt }}" placeholder="cth: PT Samudra Jaya">
    </div>
    <div class="col-md-1">
        <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
    </div>
</div>
