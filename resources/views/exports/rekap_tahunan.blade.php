<table border="1">
    <tr>
        <th colspan="2" style="font-size:16px; font-weight:bold; background:#0f172a; color:white;">
            REKAP TAHUNAN BUDIDAYA - {{ $periode }}
        </th>
    </tr>
    <tr><td colspan="2"></td></tr>

    @foreach ($gabungan as $kab)
        <tr>
            <th colspan="2" style="background:#0f172a; color:white; font-weight:bold;">
                {{ $kab['kabupaten'] }}
            </th>
        </tr>

        @if ($kab['produksi'])
            <tr style="background:#dbeafe; font-weight:bold;">
                <th colspan="2">Produksi per Jenis Ikan (kg)</th>
            </tr>
            <tr style="background:#f1f5f9; font-weight:bold;">
                <td>Jenis Ikan</td>
                <td>Produksi (kg)</td>
            </tr>
            @foreach ($kab['produksi']['per_komoditas'] as $k)
                <tr>
                    <td>{{ $k['komoditas'] }}</td>
                    <td>{{ number_format($k['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr style="font-weight:bold; background:#e2e8f0;">
                <td>Total Produksi</td>
                <td>{{ number_format($kab['produksi']['total_kabupaten'], 0, ',', '.') }}</td>
            </tr>
        @endif

        <tr><td colspan="2"></td></tr>

        @if ($kab['sarana'])
            <tr style="background:#fef3c7; font-weight:bold;">
                <th colspan="2">Sarana per Jenis Budidaya</th>
            </tr>
            <tr style="background:#f1f5f9; font-weight:bold;">
                <td>Jenis Budidaya</td>
                <td>Pembudidaya / Luas Lahan (m2)</td>
            </tr>
            @foreach ($kab['sarana']['per_jenis'] as $j)
                <tr>
                    <td>{{ $j['jenis'] }}</td>
                    <td>{{ number_format($j['pembudidaya'], 0, ',', '.') }} orang / {{ number_format($j['luas_lahan'], 0, ',', '.') }} m2</td>
                </tr>
            @endforeach
            <tr style="font-weight:bold; background:#e2e8f0;">
                <td>Total Sarana</td>
                <td>{{ number_format($kab['sarana']['total_pembudidaya'], 0, ',', '.') }} orang / {{ number_format($kab['sarana']['total_luas_lahan'], 0, ',', '.') }} m2</td>
            </tr>
        @endif

        <tr><td colspan="2"></td></tr>
    @endforeach
</table>