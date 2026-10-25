@php
    $nama = $r['nama'] ?? '';
    $jml = $r['jumlah'] ?? '';
    $satuan = $r['satuan'] ?? '';
    $hrg = $r['harga'] ?? '';
    $total = $r['total'] ?? '';
@endphp
<div class="row-input row g-2 align-items-end logistik-row">
    <div class="col-md-3">
        <label class="field-label">Kebutuhan Logistik</label>
        <input type="text" name="nama_item[{{ $i }}][]" class="form-control" value="{{ $nama }}">
    </div>
    <div class="col-md-2">
        <label class="field-label">Jumlah</label>
        <input type="number" step="0.01" name="jumlah_logistik[{{ $i }}][]" class="form-control logistik-jumlah" value="{{ $jml }}" oninput="hitungTotalLogistik(this)">
    </div>
    <div class="col-md-2">
        <label class="field-label">Satuan</label>
        <input type="text" name="satuan[{{ $i }}][]" class="form-control" value="{{ $satuan }}" placeholder="Liter/Kg/Rp">
    </div>
    <div class="col-md-2">
        <label class="field-label">Harga (Rp)</label>
        <input type="number" step="0.01" name="harga_logistik[{{ $i }}][]" class="form-control logistik-harga" value="{{ $hrg }}" oninput="hitungTotalLogistik(this)">
    </div>
    <div class="col-md-2">
        <label class="field-label">Total (Rp)</label>
        <input type="number" step="0.01" name="total_logistik[{{ $i }}][]" class="form-control logistik-total" value="{{ $total }}">
    </div>
    <div class="col-md-1">
        <button type="button" class="btn-remove-row" onclick="this.closest('.row-input').remove()">Hapus</button>
    </div>
</div>
