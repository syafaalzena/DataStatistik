@php
    $jenis = $r['jenis'] ?? '';
    $kg = $r['kg'] ?? '';
    $harga = $r['harga'] ?? '';
@endphp
<div class="row-input row g-2 align-items-end produksi-row">
    <div class="col-md-4">
        <label class="field-label">Jenis Ikan</label>
        <input type="text" name="jenis_ikan[{{ $i }}][]" class="form-control input-ikan" list="daftarIkan" autocomplete="off" value="{{ $jenis }}" placeholder="ketik / pilih nama ikan">
        <div class="warn-inline"></div>
    </div>
    <div class="col-md-3">
        <label class="field-label">Produksi (Kg)</label>
        <input type="number" step="0.01" name="produksi_kg[{{ $i }}][]" class="form-control produksi-kg" value="{{ $kg }}" oninput="hitungNilai(this)">
        <div class="warn-inline"></div>
    </div>
    <div class="col-md-2">
        <label class="field-label">Harga Ikan (Rp)</label>
        <input type="number" step="0.01" name="harga_rp[{{ $i }}][]" class="form-control produksi-harga" value="{{ $harga }}" oninput="hitungNilai(this)">
        <div class="warn-inline"></div>
    </div>
    <div class="col-md-2">
        <label class="field-label">Nilai Produksi (Rp)</label>
        <input type="text" class="form-control produksi-nilai" value="{{ number_format((float) $kg * (float) $harga, 0, ',', '.') }}" readonly>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
    </div>
</div>
