<table border="1">
    <tr>
        <th colspan="2" style="font-size:16px; font-weight:bold; background:#0f172a; color:white;">
            REKAP PRODUKSI BULANAN - {{ $periode }}
        </th>
    </tr>
    <tr><td colspan="2"></td></tr>
    <tr>
        <td style="font-weight:bold;">Total Produksi Provinsi (kg)</td>
        <td style="font-weight:bold;">{{ number_format($grandTotal, 0, ',', '.') }}</td>
    </tr>
    <tr><td colspan="2"></td></tr>

    @foreach ($rekap as $kab)
        <tr>
            <th colspan="2" style="background:#0f172a; color:white; font-weight:bold;">
                {{ $kab['kabupaten'] }}
            </th>
        </tr>
        <tr style="background:#f1f5f9; font-weight:bold;">
            <th>Jenis Ikan</th>
            <th>Produksi (kg)</th>
        </tr>
        @foreach ($kab['per_komoditas'] as $k)
            <tr>
                <td>{{ $k['komoditas'] }}</td>
                <td>{{ number_format($k['total'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr style="font-weight:bold; background:#e2e8f0;">
            <td>Total {{ $kab['kabupaten'] }}</td>
            <td>{{ number_format($kab['total_kabupaten'], 0, ',', '.') }}</td>
        </tr>
        <tr><td colspan="2"></td></tr>
    @endforeach
</table>