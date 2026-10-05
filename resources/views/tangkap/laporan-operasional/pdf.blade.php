<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #111; }
        .judul { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 14px; text-transform: uppercase; }
        .meta td { padding: 2px 6px; }
        .section-heading { background: #0f172a; color: #fff; font-weight: bold; padding: 4px 8px; font-size: 11px; text-transform: uppercase; margin-top: 10px; }
        table.recap { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        table.recap th, table.recap td { border: 1px solid #94a3b8; padding: 4px 6px; font-size: 10px; }
        table.recap th { background: #f1f5f9; text-align: center; }
        .num { text-align: right; }
        .ttd { margin-top: 30px; width: 40%; float: right; text-align: center; }
    </style>
</head>
<body>
    <div class="judul">Daftar Rekapitulasi Aktivitas Bulanan Pelabuhan Perikanan</div>

    <table class="meta">
        <tr><td><strong>Pelabuhan Perikanan</strong></td><td>:</td><td>{{ $laporan->pelabuhan->nama ?? '-' }}</td></tr>
        <tr><td><strong>Kabupaten/Kota</strong></td><td>:</td><td>{{ $laporan->pelabuhan->kabupatenIkan->nama_kabupaten ?? '-' }}</td></tr>
        <tr><td><strong>Bulan</strong></td><td>:</td><td>{{ $laporan->nama_bulan }} {{ $laporan->tahun }}</td></tr>
    </table>

    <div class="section-heading">Data Armada Tangkap (Per Trip)</div>
    <table class="recap">
        <thead>
            <tr>
                <th>No</th><th>Nama Kapal</th><th>Tanggal</th><th>Jenis Alat</th>
                <th>Ukuran (GT)</th><th>ABK</th><th>Dokumen</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan->armadaTangkap as $i => $a)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $a->nama_armada ?? '-' }}</td>
                    <td>{{ optional($a->tanggal_berangkat)->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $a->jenis_alat_tangkap ?? '-' }}</td>
                    <td>{{ $a->ukuran_kapal }}</td>
                    <td class="num">{{ $a->jumlah_abk }}</td>
                    <td>{{ $a->dokumens->pluck('nama_dokumen')->join(', ') ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    @if ($laporan->rekap_kapal->isNotEmpty())
    <div class="section-heading">Rekap Kapal Beroperasi</div>
    <table class="recap">
        <thead>
            <tr><th>Nama Kapal</th><th>Ukuran (GT)</th><th>Jumlah Trip Bulan Ini</th></tr>
        </thead>
        <tbody>
            @foreach ($laporan->rekap_kapal as $namaKapal => $r)
                <tr>
                    <td>{{ $namaKapal }}</td>
                    <td class="num">{{ $r['ukuran_kapal'] }}</td>
                    <td class="num">{{ $r['jumlah_trip'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@php $tripDenganFoto = $laporan->armadaTangkap->filter(fn ($a) => $a->foto); @endphp
@if ($tripDenganFoto->isNotEmpty())
    <div class="section-heading">Dokumentasi Foto Kapal Per Trip</div>
    <table class="recap">
        <thead>
            <tr>
                <th>No</th><th>Nama Kapal</th><th>Tanggal</th><th>Foto</th><th>Lokasi</th><th>Jam Upload</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tripDenganFoto as $i => $a)
                @php
                    $pathFile = \Illuminate\Support\Facades\Storage::disk('public')->path($a->foto->foto);
                    $fotoBase64 = file_exists($pathFile)
                        ? 'data:image/' . pathinfo($pathFile, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($pathFile))
                        : null;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $a->nama_armada ?? '-' }}</td>
                    <td>{{ optional($a->tanggal_berangkat)->format('d-m-Y') ?? '-' }}</td>
                    <td>
                        @if ($fotoBase64)
                            <img src="{{ $fotoBase64 }}" style="height:50px;">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $a->foto->lokasi ?? '-' }}</td>
                    <td>{{ $a->foto->jam_upload }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

    <div class="section-heading">Produksi Ikan Dominan & Nilai Produksi</div>
    <table class="recap">
        <thead>
            <tr><th>No</th><th>Jenis Ikan</th><th>Produksi (Kg)</th><th>Harga (Rp)</th><th>Nilai (Rp)</th></tr>
        </thead>
        <tbody>
            @forelse ($laporan->produksiIkan as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->jenis_ikan }}</td>
                    <td class="num">{{ number_format($p->produksi_kg, 0, ',', '.') }}</td>
                    <td class="num">{{ number_format($p->harga_rp, 0, ',', '.') }}</td>
                    <td class="num">{{ number_format($p->nilai_rp, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-heading">Logistik</div>
    <table class="recap">
        <thead>
            <tr><th>No</th><th>Kebutuhan</th><th>Jumlah</th><th>Satuan</th><th>Harga (Rp)</th><th>Total (Rp)</th></tr>
        </thead>
        <tbody>
            @forelse ($laporan->logistik as $i => $lg)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $lg->nama_item }}</td>
                    <td class="num">{{ number_format($lg->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $lg->satuan ?? '-' }}</td>
                    <td class="num">{{ $lg->harga_rp !== null ? number_format($lg->harga_rp, 0, ',', '.') : '-' }}</td>
                    <td class="num">{{ number_format($lg->total_rp, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-heading">Data Pemasaran</div>
    <table class="recap">
        <thead>
            <tr><th>No</th><th>Kategori</th><th>Jenis Ikan</th><th>Quantity (Kg)</th><th>Tujuan</th></tr>
        </thead>
        <tbody>
            @forelse ($laporan->pemasaran as $i => $pm)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $pm->kategori }}</td>
                    <td>{{ $pm->jenis_ikan }}</td>
                    <td class="num">{{ number_format($pm->quantity_kg, 0, ',', '.') }}</td>
                    <td>{{ $pm->tujuan ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd">
        <p>{{ $laporan->pelabuhan->kabupatenIkan->nama_kabupaten ?? '' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Pengelola Kepelabuhan Perikanan</p>
        <br><br><br>
        <p><strong>{{ $laporan->nama_pengelola ?? '(...........................)' }}</strong></p>
        @if ($laporan->nip_pengelola)
            <p>NIP. {{ $laporan->nip_pengelola }}</p>
        @endif
    </div>
</body>
</html>