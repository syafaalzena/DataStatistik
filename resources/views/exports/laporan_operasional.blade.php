<table>
    <tr><td colspan="4"><strong>DAFTAR REKAPITULASI AKTIVITAS BULANAN PELABUHAN PERIKANAN</strong></td></tr>
    <tr><td>Pelabuhan</td><td>:</td><td colspan="2">{{ $laporan->pelabuhan->nama ?? '-' }}</td></tr>
    <tr><td>Kabupaten/Kota</td><td>:</td><td colspan="2">{{ $laporan->pelabuhan->kabupatenIkan->nama_kabupaten ?? '-' }}</td></tr>
    <tr><td>Bulan</td><td>:</td><td colspan="2">{{ $laporan->nama_bulan }} {{ $laporan->tahun }}</td></tr>
    <tr><td colspan="4"></td></tr>

    <tr><td colspan="7"><strong>DATA ARMADA TANGKAP (PER TRIP)</strong></td></tr>
    <tr>
        <th>No</th><th>Nama Kapal</th><th>Tanggal Berangkat</th><th>Jenis Alat Tangkap</th>
        <th>Ukuran (GT)</th><th>ABK</th><th>Dokumen</th>
    </tr>
    @foreach ($laporan->armadaTangkap as $i => $a)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $a->nama_armada ?? '-' }}</td>
            <td>{{ optional($a->tanggal_berangkat)->format('d-m-Y') ?? '-' }}</td>
            <td>{{ $a->jenis_alat_tangkap ?? '-' }}</td>
            <td>{{ $a->ukuran_kapal }}</td>
            <td>{{ $a->jumlah_abk }}</td>
            <td>{{ $a->dokumens->pluck('nama_dokumen')->join(', ') ?: '-' }}</td>
        </tr>
    @endforeach
    <tr><td colspan="7"></td></tr>

    <tr><td colspan="5"><strong>PRODUKSI IKAN DOMINAN & NILAI PRODUKSI</strong></td></tr>
    <tr><th>No</th><th>Jenis Ikan</th><th>Produksi (Kg)</th><th>Harga (Rp)</th><th>Nilai (Rp)</th></tr>
    @foreach ($laporan->produksiIkan as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->jenis_ikan }}</td>
            <td>{{ $p->produksi_kg }}</td>
            <td>{{ $p->harga_rp }}</td>
            <td>{{ $p->nilai_rp }}</td>
        </tr>
    @endforeach
    <tr><td colspan="5"></td></tr>

    <tr><td colspan="6"><strong>LOGISTIK</strong></td></tr>
    <tr><th>No</th><th>Kebutuhan</th><th>Jumlah</th><th>Satuan</th><th>Harga (Rp)</th><th>Total (Rp)</th></tr>
    @foreach ($laporan->logistik as $i => $lg)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $lg->nama_item }}</td>
            <td>{{ $lg->jumlah }}</td>
            <td>{{ $lg->satuan }}</td>
            <td>{{ $lg->harga_rp }}</td>
            <td>{{ $lg->total_rp }}</td>
        </tr>
    @endforeach
    <tr><td colspan="6"></td></tr>

    <tr><td colspan="5"><strong>DATA PEMASARAN</strong></td></tr>
    <tr><th>No</th><th>Kategori</th><th>Jenis Ikan</th><th>Quantity (Kg)</th><th>Tujuan</th></tr>
    @foreach ($laporan->pemasaran as $i => $pm)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $pm->kategori }}</td>
            <td>{{ $pm->jenis_ikan }}</td>
            <td>{{ $pm->quantity_kg }}</td>
            <td>{{ $pm->tujuan }}</td>
        </tr>
    @endforeach
</table>