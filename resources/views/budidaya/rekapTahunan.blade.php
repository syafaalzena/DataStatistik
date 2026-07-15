<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Tahunan - Budidaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Rekap Tahunan</h2>
        <a href="{{ route('budidaya.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
    </div>

    <form method="GET" action="{{ route('budidaya.rekapTahunan') }}" class="row g-3 align-items-end mb-4">
        <div class="col-auto">
            <label class="form-label">Dari tahun</label>
            <input type="number" name="tahun_awal" value="{{ $tahunAwal }}" class="form-control" style="width:100px">
        </div>
        <div class="col-auto">
            <label class="form-label">Sampai tahun</label>
            <input type="number" name="tahun_akhir" value="{{ $tahunAkhir }}" class="form-control" style="width:100px">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
    </form>
    <p class="text-muted small">Isi tahun yang sama di kedua kolom kalau cuma mau 1 tahun.</p>

    @forelse ($gabungan as $kab)
        <div class="card p-3 mb-4">
            <h5>{{ $kab['kabupaten'] }}</h5>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted">Produksi per Jenis Ikan (kg)</h6>
                    @if ($kab['produksi'])
                        <table class="table table-sm table-striped mb-0">
                            <tbody>
                                @foreach ($kab['produksi']['per_komoditas'] as $k)
                                    <tr>
                                        <td>{{ $k['komoditas'] }}</td>
                                        <td class="text-end">{{ number_format($k['total']) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="table-secondary fw-bold">
                                    <td>Total</td>
                                    <td class="text-end">{{ number_format($kab['produksi']['total_kabupaten']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted small">Belum ada data produksi.</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Sarana per Jenis Budidaya</h6>
                    @if ($kab['sarana'])
                        <table class="table table-sm table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Jenis Budidaya</th>
                                    <th class="text-end">Pembudidaya</th>
                                    <th class="text-end">Luas Lahan (m2)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kab['sarana']['per_jenis'] as $j)
                                    <tr>
                                        <td>{{ $j['jenis'] }}</td>
                                        <td class="text-end">{{ number_format($j['pembudidaya']) }}</td>
                                        <td class="text-end">{{ number_format($j['luas_lahan']) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="table-secondary fw-bold">
                                    <td>Total</td>
                                    <td class="text-end">{{ number_format($kab['sarana']['total_pembudidaya']) }}</td>
                                    <td class="text-end">{{ number_format($kab['sarana']['total_luas_lahan']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted small">Belum ada data sarana.</p>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Tidak ada data pada rentang tahun yang dipilih.</p>
    @endforelse
</div>
</body>
</html>