<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kabupaten->nama_kabupaten }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">

    <a href="{{ route('kabupaten.index') }}" class="btn btn-outline-secondary mb-4">← Kembali</a>

    <h2 class="fw-bold mb-1">{{ $kabupaten->nama_kabupaten }}</h2>
    <p class="text-muted mb-4">Data statistik garam wilayah ini</p>

    {{-- DATA TAHUNAN --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">📊 Data Tahunan</h5>
            @if($dataTahunan->isEmpty())
                <p class="text-muted">Belum ada data tahunan.</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Tahun</th>
                            <th>Jumlah Petani</th>
                            <th>Lahan Rebus (ha)</th>
                            <th>Lahan Jemur (ha)</th>
                            <th>Jumlah Unit</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataTahunan as $dt)
                        <tr>
                            <td>{{ $dt->tahun }}</td>
                            <td>{{ $dt->jumlah_petani }}</td>
                            <td>{{ $dt->luas_lahan_rebus }}</td>
                            <td>{{ $dt->luas_lahan_jemur }}</td>
                            <td>{{ $dt->jumlah_lahan_unit }}</td>
                            <td>{{ $dt->lokasi }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    {{-- DATA BULANAN --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">📅 Data Bulanan</h5>
            @if($dataBulanan->isEmpty())
                <p class="text-muted">Belum ada data bulanan.</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Jenis Produksi</th>
                            <th>Produksi</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataBulanan as $db)
                        <tr>
                            <td>{{ $db->tahun }}</td>
                            <td>{{ $db->bulan }}</td>
                            <td>{{ $db->jenis_produksi }}</td>
                            <td>{{ $db->produksi }}</td>
                            <td>{{ number_format($db->harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>