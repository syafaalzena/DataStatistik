<table border="1" cellpadding="6" style="border-collapse:collapse; width:100%; font-family:sans-serif; font-size:11px;">
    <tr>
        <th colspan="6" style="font-size:16px; font-weight:bold; background:#0f172a; color:white;">
            REKAP DATA TAHUNAN TANGKAP - {{ $periode }}
        </th>
    </tr>
    <tr><td colspan="6"></td></tr>
    <tr>
        <td style="font-weight:bold;">Total RTP Provinsi</td>
        <td colspan="5" style="font-weight:bold;">{{ number_format($grandRtp, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Total Kapal Provinsi</td>
        <td colspan="5" style="font-weight:bold;">{{ number_format($grandKapal, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Total Nelayan Provinsi</td>
        <td colspan="5" style="font-weight:bold;">{{ number_format($grandNelayan, 0, ',', '.') }}</td>
    </tr>
    <tr><td colspan="6"></td></tr>

    @foreach ($rekap as $kab)
        <tr>
            <th colspan="6" style="background:#0f172a; color:white; font-weight:bold;">
                {{ $kab['kabupaten'] }}
            </th>
        </tr>
        <tr style="background:#f1f5f9; font-weight:bold;">
            <th>Pelabuhan</th>
            <th>RTP</th>
            <th>Kapal</th>
            <th>API</th>
            <th>Nelayan Buruh</th>
            <th>Nelayan</th>
        </tr>
        @foreach ($kab['per_pelabuhan'] as $p)
            <tr>
                <td>{{ $p['pelabuhan'] }}</td>
                <td>{{ number_format($p['rtp'], 0, ',', '.') }}</td>
                <td>{{ number_format($p['kapal'], 0, ',', '.') }}</td>
                <td>{{ number_format($p['api'], 0, ',', '.') }}</td>
                <td>{{ number_format($p['nelayan_buruh'], 0, ',', '.') }}</td>
                <td>{{ number_format($p['nelayan'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr style="font-weight:bold; background:#e2e8f0;">
            <td>Total {{ $kab['kabupaten'] }}</td>
            <td>{{ number_format($kab['total_rtp'], 0, ',', '.') }}</td>
            <td>{{ number_format($kab['total_kapal'], 0, ',', '.') }}</td>
            <td>{{ number_format($kab['total_api'], 0, ',', '.') }}</td>
            <td>{{ number_format($kab['total_nelayan_buruh'], 0, ',', '.') }}</td>
            <td>{{ number_format($kab['total_nelayan'], 0, ',', '.') }}</td>
        </tr>
        <tr><td colspan="6"></td></tr>
    @endforeach
</table>