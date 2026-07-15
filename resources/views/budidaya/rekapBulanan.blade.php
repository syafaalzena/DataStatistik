<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Produksi Bulanan - Budidaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Rekap Produksi Bulanan</h2>
        <a href="{{ route('budidaya.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
    </div>

    <form method="GET" action="{{ route('budidaya.rekapBulanan') }}" class="row g-3 align-items-end mb-4">
        <div class="col-auto">
            <label class="form-label">Dari bulan</label>
            <select name="bulan_awal" class="form-select">
                @foreach (['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $label)
                    <option value="{{ $val }}" {{ (string)$bulanAwal === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label class="form-label">Dari tahun</label>
            <input type="number" name="tahun_awal" value="{{ $tahunAwal }}" class="form-control" style="width:100px">
        </div>
        <div class="col-auto">
            <label class="form-label">Sampai bulan</label>
            <select name="bulan_akhir" class="form-select">
                @foreach (['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $label)
                    <option value="{{ $val }}" {{ (string)$bulanAkhir === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label class="form-label">Sampai tahun</label>
            <input type="number" name="tahun_akhir" value="{{ $tahunAkhir }}" class="form-control" style="width:100px">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
    </form>

    <div class="card p-3 mb-4 text-center">
        <div class="text-muted small">Total Produksi Seluruh Provinsi (kg)</div>
        <div class="fs-3 fw-bold">{{ number_format($grandTotal) }}</div>
    </div>

    @forelse ($rekap as $kab)
        <div class="card p-3 mb-3">
            <h5>{{ $kab['kabupaten'] }}</h5>
            <table class="table table-sm table-striped mb-0">
                <thead>
                    <tr>
                        <th>Jenis Ikan</th>
                        <th class="text-end">Produksi (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kab['per_komoditas'] as $k)
                        <tr>
                            <td>{{ $k['komoditas'] }}</td>
                            <td class="text-end">{{ number_format($k['total']) }}</td>
                        </tr>
                    @endforeach
                    <tr class="table-secondary fw-bold">
                        <td>Total {{ $kab['kabupaten'] }}</td>
                        <td class="text-end">{{ number_format($kab['total_kabupaten']) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @empty
        <p class="text-muted">Tidak ada data produksi pada rentang yang dipilih.</p>
    @endforelse
</div>
</body>
</html>