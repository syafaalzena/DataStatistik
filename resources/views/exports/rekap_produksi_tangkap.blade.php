<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        h2 { margin-bottom: 2px; }
        p { margin-top: 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background: #0f172a; color: #fff; }
    </style>
</head>
<body>
    <h2>Rekap Produksi Tangkap</h2>
    <p>Kabupaten/Kota: {{ $kabupaten->nama_kabupaten }} &mdash; Dicetak: {{ now()->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Bulan</th>
                <th>Pelabuhan</th>
                <th>WPPNRI</th>
                <th>Jenis LK</th>
                <th>Jenis API</th>
                <th>Ukuran Kapal</th>
                <th>Jenis Ikan</th>
                <th>Nama Latin</th>
                <th>Volume (Kg)</th>
                <th>Harga (Rp)</th>
                <th>Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataProduksi as $d)
                <tr>
                    <td>{{ $d->tahun }}</td>
                    <td>{{ \Carbon\Carbon::create()->month($d->bulan)->translatedFormat('F') }}</td>
                    <td>{{ $d->pelabuhan->nama ?? '-' }}</td>
                    <td>{{ $d->wppnri->kode ?? '-' }}</td>
                    <td>{{ $d->jenis_lk }}</td>
                    <td>{{ $d->jenisApi->nama ?? '-' }}</td>
                    <td>{{ $d->kategoriUkuranKapal->label ?? '-' }}</td>
                    <td>{{ $d->komoditasIkan->nama_ikan ?? '-' }}</td>
                    <td>{{ $d->komoditasIkan->nama_latin ?? '-' }}</td>
                    <td>{{ number_format($d->volume_produksi_kg, 2, ',', '.') }}</td>
                    <td>{{ number_format($d->harga_rp, 0, ',', '.') }}</td>
                    <td>{{ number_format($d->nilai_rp, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="12" style="text-align:center;">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>