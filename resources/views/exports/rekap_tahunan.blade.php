<table border="1" cellpadding="6" style="border-collapse:collapse; width:100%; font-family:sans-serif; font-size:12px;">
    <tr>
        <th colspan="4" style="font-size:16px; font-weight:bold; background:#0f172a; color:white;">
            REKAP TAHUNAN BUDIDAYA - {{ $periode }}
        </th>
    </tr>
    <tr><td colspan="4"></td></tr>

    @foreach ($gabungan as $kab)
        <tr>
            <th colspan="4" style="background:#0f172a; color:white; font-weight:bold;">
                {{ $kab['kabupaten'] }}
            </th>
        </tr>

        @if ($kab['produksi'])
            <tr style="background:#dbeafe; font-weight:bold;">
                <th colspan="4">Produksi per Jenis Ikan (kg)</th>
            </tr>
            <tr style="background:#f1f5f9; font-weight:bold;">
                <td colspan="2">Jenis Ikan</td>
                <td colspan="2">Produksi (kg)</td>
            </tr>
            @foreach ($kab['produksi']['per_komoditas'] as $k)
                <tr>
                    <td colspan="2">{{ $k['komoditas'] }}</td>
                    <td colspan="2">{{ number_format($k['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr style="font-weight:bold; background:#e2e8f0;">
                <td colspan="2">Total Produksi</td>
                <td colspan="2">{{ number_format($kab['produksi']['total_kabupaten'], 0, ',', '.') }}</td>
            </tr>
        @endif

        <tr><td colspan="4"></td></tr>

        @if ($kab['sarana'])
            <tr style="background:#fef3c7; font-weight:bold;">
                <th colspan="4">Sarana per Jenis Budidaya</th>
            </tr>
            <tr style="background:#f1f5f9; font-weight:bold;">
                <td>Jenis Budidaya</td>
                <td>RTP (unit)</td>
                <td>Pembudidaya</td>
                <td>Luas Lahan (m2)</td>
            </tr>
            @foreach ($kab['sarana']['per_jenis'] as $j)
                <tr>
                    <td>{{ $j['jenis'] }}</td>
                    <td>{{ number_format($j['rtp'], 0, ',', '.') }}</td>
                    <td>{{ number_format($j['pembudidaya'], 0, ',', '.') }}</td>
                    <td>{{ number_format($j['luas_lahan'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr style="font-weight:bold; background:#e2e8f0;">
            <td>Total Sarana</td>
            <td>{{ number_format($kab['sarana']['total_rtp'], 0, ',', '.') }}</td>
            <td>{{ number_format($kab['sarana']['total_pembudidaya'], 0, ',', '.') }}</td>
            <td>{{ number_format($kab['sarana']['total_luas_lahan'], 0, ',', '.') }}</td>
        </tr>
        @endif

        <tr><td colspan="4"></td></tr>
    @endforeach
</table>