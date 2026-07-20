<table border="1" cellpadding="6" style="border-collapse:collapse; width:100%; font-family:sans-serif; font-size:12px;">
    <tr>
        <th colspan="9" style="font-size:16px; font-weight:bold; background:#0d1b2a; color:white; padding:10px;">
            REKAP PRODUKSI GARAM TAHUNAN - {{ $tahunDipilih }}
            @if($namaKabupaten) — {{ $namaKabupaten }} @endif
        </th>
    </tr>
    <tr><td colspan="9"></td></tr>

    <tr>
        <td style="font-weight:bold;">Total Data</td>
        <td>{{ $data->count() }}</td>
        <td style="font-weight:bold;">Total Produksi</td>
        <td>{{ $data->sum('produksi') }} Ton</td>
        <td style="font-weight:bold;">Total Harga</td>
        <td colspan="4">Rp {{ number_format($data->sum('harga'), 0, ',', '.') }}</td>
    </tr>
    <tr><td colspan="9"></td></tr>

    <tr style="background:#0d1b2a; color:white; font-weight:bold;">
        <th>Kabupaten</th>
        <th>Bulan</th>
        <th>Jenis Produksi</th>
        <th>Produksi (Ton)</th>
        <th>Lokasi</th>
        <th>Jumlah Petani</th>
        <th>Nama Kelompok</th>
        <th>Nama Pemilik</th>
        <th>Harga (Rp)</th>
    </tr>
    @foreach ($data as $d)
        <tr>
            <td>{{ $d->kabupaten->nama_kabupaten }}</td>
            <td>{{ $namaBulan[$d->bulan] }}</td>
            <td>{{ $d->jenis_produksi }}</td>
            <td>{{ $d->produksi }}</td>
            <td>{{ $d->lokasi }}</td>
            <td>{{ $d->jumlah_petani }}</td>
            <td>{{ $d->nama_kelompok }}</td>
            <td>{{ $d->nama_pemilik }}</td>
            <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
        </tr>
    @endforeach
</table>