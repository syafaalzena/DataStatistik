<table border="1" cellpadding="6" style="border-collapse:collapse; width:100%; font-family:sans-serif; font-size:11px;">
    <tr>
        <th colspan="{{ count($periodKeys) + 2 }}" style="font-size:16px; font-weight:bold; background:#0f172a; color:white;">
            REKAP PRODUKSI BULANAN - {{ $periode }}
        </th>
    </tr>
    <tr><td colspan="{{ count($periodKeys) + 2 }}"></td></tr>
    <tr>
        <td style="font-weight:bold;">Total Produksi Provinsi (kg)</td>
        <td colspan="{{ count($periodKeys) + 1 }}" style="font-weight:bold;">{{ number_format($grandTotal, 0, ',', '.') }}</td>
    </tr>
    <tr><td colspan="{{ count($periodKeys) + 2 }}"></td></tr>

    @foreach ($rekap as $kab)
        <tr>
            <th colspan="{{ count($periodKeys) + 2 }}" style="background:#0f172a; color:white; font-weight:bold;">
                {{ $kab['kabupaten'] }}
            </th>
        </tr>
        <tr style="background:#f1f5f9; font-weight:bold;">
            <th>Jenis Ikan</th>
            @foreach ($periodLabels as $label)
                <th>{{ $label }}</th>
            @endforeach
            <th>Total</th>
        </tr>
        @foreach ($kab['per_komoditas'] as $k)
            <tr>
                <td>{{ $k['komoditas'] }}</td>
                @foreach ($periodKeys as $pk)
                    <td>{{ $k['per_periode'][$pk] > 0 ? number_format($k['per_periode'][$pk], 0, ',', '.') : '-' }}</td>
                @endforeach
                <td>{{ number_format($k['total'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr style="font-weight:bold; background:#e2e8f0;">
            <td>Total {{ $kab['kabupaten'] }}</td>
            @foreach ($periodKeys as $pk)
                @php
                    $totalPeriode = $kab['per_komoditas']->sum(fn ($k) => $k['per_periode'][$pk]);
                @endphp
                <td>{{ number_format($totalPeriode, 0, ',', '.') }}</td>
            @endforeach
            <td>{{ number_format($kab['total_kabupaten'], 0, ',', '.') }}</td>
        </tr>
        <tr><td colspan="{{ count($periodKeys) + 2 }}"></td></tr>
    @endforeach
</table>