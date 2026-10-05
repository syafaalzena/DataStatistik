<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 9px; }
        h2 { margin-bottom: 2px; }
        p { margin-top: 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background: #0f172a; color: #fff; }
    </style>
</head>
<body>
    <h2>Tahunan - {{ $kabupaten->nama_kabupaten }}</h2>
    <p>Dicetak: {{ now()->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tahun</th><th>Pelabuhan</th><th>WPPNRI</th>
                <th>Jenis LK</th><th>Jenis API</th><th>Ukuran Kapal</th>
                <th>Jumlah RTP</th><th>Jumlah Kapal</th><th>Jumlah API</th>
                <th>Nelayan Buruh</th><th>Total Nelayan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapTahunan as $r)
                <tr>
                    <td>{{ $r->tahun }}</td>
                    <td>{{ $r->nama_pelabuhan }}</td>
                    <td>{{ $r->kode_wppnri }}</td>
                    <td>{{ $r->jenis_lk }}</td>
                    <td>{{ $r->nama_jenis_api }}</td>
                    <td>{{ $r->label_kategori }}</td>
                    <td>{{ $r->total_rtp }}</td>
                    <td>{{ $r->total_kapal }}</td>
                    <td>{{ $r->total_api }}</td>
                    <td>{{ $r->total_nelayan_buruh }}</td>
                    <td>{{ $r->total_nelayan }}</td>
                </tr>
            @empty
                <tr><td colspan="11" style="text-align:center;">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
