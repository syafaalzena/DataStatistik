<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('content')

<div class="container">

<h3>Rekap Bulanan</h3>

<table class="table table-bordered">

<thead>
<tr>
    <th>Kabupaten</th>
    <th>Bulan</th>
    <th>Jenis</th>
    <th>Produksi</th>
    <th>Harga</th>
</tr>
</thead>

<tbody>

@foreach($data as $row)

<tr>
    <td>{{ $row->nama_kabupaten }}</td>
    <td>{{ $row->bulan }}</td>
    <td>{{ $row->jenis_produksi }}</td>
    <td>{{ $row->produksi }}</td>
    <td>Rp {{ number_format($row->harga) }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>

@endsection
</body>
</html>