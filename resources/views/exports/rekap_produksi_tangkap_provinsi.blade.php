@php $totalKolom = count($periodKeys) + 2; @endphp

<table border="1" cellpadding="6" style="border-collapse:collapse; width:100%; font-family:sans-serif; font-size:11px;">
    <tr>
        <th colspan="{{ $totalKolom }}" style="font-size:16px; font-weight:bold; background:#0f172a; color:white;">
            REKAP PRODUKSI TANGKAP BULANAN - {{ $periode }}
        </th>
    </tr>
    <tr><td colspan="{{ $totalKolom }}"></td></tr>
    <tr>
        <td style="font-weight:bold;">Total Volume Produksi Provinsi (kg)</td>
        <td colspan="{{ $totalKolom - 1 }}" style="font-weight:bold;">{{ number_format($grandVolume, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Total Nilai Produksi Provinsi (Rp)</td>
        <td colspan="{{ $totalKolom - 1 }}" style="font-weight:bold;">{{ number_format($grandNilai, 0, ',', '.') }}</td>
    </tr>
    <tr><td colspan="{{ $totalKolom }}"></td></tr>

    @foreach ($rekap as $kab)
        <tr>
            <th colspan="{{ $totalKolom }}" style="background:#0f172a; color:white; font-weight:bold;">
                {{ $kab['kabupaten'] }}
            </th>
        </tr>
        <tr style="background:#f1f5f9; font-weight:bold;">
            <th>Jenis Ikan</th>
            @foreach ($periodLabels as $label)
                <th>{{ $label }}</th>
            @endforeach
            <th>Total (Kg)</th>
        </tr>
        @foreach ($kab['per_ikan'] as $ik)
            <tr>
                <td>{{ $ik['jenis_ikan'] }}</td>
                @foreach ($periodKeys as $pk)
                    <td>{{ $ik['per_periode'][$pk] > 0 ? number_format($ik['per_periode'][$pk], 0, ',', '.') : '-' }}</td>
                @endforeach
                <td>{{ number_format($ik['total_volume'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr style="font-weight:bold; background:#e2e8f0;">
            <td>Total {{ $kab['kabupaten'] }}</td>
            @foreach ($periodKeys as $pk)
                @php
                    $totalPeriode = $kab['per_ikan']->sum(fn ($ik) => $ik['per_periode'][$pk]);
                @endphp
                <td>{{ number_format($totalPeriode, 0, ',', '.') }}</td>
            @endforeach
            <td>{{ number_format($kab['total_volume_kabupaten'], 0, ',', '.') }}</td>
        </tr>
        <tr><td colspan="{{ $totalKolom }}"></td></tr>
    @endforeach

    @if ($includeTrip)
        <tr>
            <th colspan="{{ $totalKolom }}" style="background:#0f172a; color:white; font-weight:bold;">
                RINGKASAN DATA TRIP
            </th>
        </tr>
        <tr style="background:#f1f5f9; font-weight:bold;">
            <th colspan="{{ $totalKolom - 1 }}">Kabupaten</th>
            <th>Total Trip</th>
        </tr>
        @foreach ($rekapTrip as $t)
            <tr>
                <td colspan="{{ $totalKolom - 1 }}">{{ $t['kabupaten'] }}</td>
                <td>{{ number_format($t['total_trip'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr style="font-weight:bold; background:#e2e8f0;">
            <td colspan="{{ $totalKolom - 1 }}">Total Provinsi</td>
            <td>{{ number_format($grandTrip, 0, ',', '.') }}</td>
        </tr>
    @endif
</table>