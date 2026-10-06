<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #111; }
        .judul { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 4px; text-transform: uppercase; }
        .sub { text-align: center; margin-bottom: 14px; color: #475569; }
        .kabupaten-heading { background: #0f172a; color: #fff; font-weight: bold; padding: 4px 8px; font-size: 11px; text-transform: uppercase; margin-top: 12px; }
        table.recap { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.recap th, table.recap td { border: 1px solid #94a3b8; padding: 3px 6px; font-size: 9px; }
        table.recap th { background: #f1f5f9; text-align: center; }
        .num { text-align: right; }
        .ringkasan { margin-bottom: 14px; }
        .ringkasan td { padding: 2px 10px 2px 0; }
    </style>
</head>
<body>
    <div class="judul">Rekap Tahunan Laporan Operasional Pelabuhan Perikanan</div>
    <div class="sub">Tahun {{ $tahun }}</div>

    <table class="ringkasan">
        <tr>
            <td><strong>Total Produksi:</strong> {{ number_format($grandTotalProduksi, 0, ',', '.') }} Kg</td>
            <td><strong>Total Nilai Produksi:</strong> Rp {{ number_format($grandTotalNilai, 0, ',', '.') }}</td>
        </tr>
    </table>

    @forelse ($laporans as $namaKabupaten => $group)
        <div class="kabupaten-heading">{{ $namaKabupaten }}</div>
        <table class="recap">
            <thead>
                <tr>
                    <th>Pelabuhan</th><th>Bulan</th><th>Jumlah Kapal</th><th>Jumlah ABK</th>
                    <th>Produksi (Kg)</th><th>Nilai Produksi (Rp)</th><th>Total Logistik (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group as $l)
                    <tr>
                        <td>{{ $l->pelabuhan->nama ?? '-' }}</td>
                        <td>{{ $l->nama_bulan }}</td>
                        <td class="num">{{ number_format($l->total_kapal, 0, ',', '.') }}</td>
                        <td class="num">{{ number_format($l->total_abk, 0, ',', '.') }}</td>
                        <td class="num">{{ number_format($l->total_produksi_kg, 0, ',', '.') }}</td>
                        <td class="num">{{ number_format($l->total_nilai_produksi, 0, ',', '.') }}</td>
                        <td class="num">{{ number_format($l->total_logistik, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p style="text-align:center; margin-top:20px;">Belum ada laporan untuk tahun {{ $tahun }}.</p>
    @endforelse
</body>
</html>