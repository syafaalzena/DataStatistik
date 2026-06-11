<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container">

@foreach($kabupaten as $kab)
    <h3>{{ $kab->nama_kabupaten }}</h3>
@endforeach

<form action=""
    method="POST">

@csrf

<input type="hidden"
    name="kabupaten_id"
    value="{{ $kab->id }}">

<h4>Data Tahunan</h4>

<div class="mb-3">
    <label>Jumlah Petani Garam</label>
    <input type="number"
        name="jumlah_petani"
        class="form-control">
</div>

<div class="mb-3">
    <label>Luas Lahan Rebus (Ha)</label>
    <input type="number"
        step="0.01"
        name="luas_lahan_rebus"
        class="form-control">
</div>

<div class="mb-3">
    <label>Jumlah Lahan (Unit)</label>
    <input type="number"
        name="jumlah_lahan_unit"
        class="form-control">
</div>

<div class="mb-3">
    <label>Lokasi Desa/Kecamatan</label>
    <textarea
        name="lokasi"
        class="form-control"></textarea>
</div>

<button class="btn btn-success">
    Simpan Data Tahunan
</button>

</form>

<hr>

<h4>Data Bulanan</h4>

<table class="table table-bordered">

<thead>
<tr>
    <th>Bulan</th>
    <th>Jenis</th>
    <th>Produksi</th>
    <th>Harga</th>
</tr>
</thead>

<tbody>

@foreach($bulan as $b)

<tr>

<td>{{ $b }}</td>

<td>
<select class="form-control">
    <option>Rebus</option>
    <option>Jemur</option>
</select>
</td>

<td>
<input type="number"
    class="form-control">
</td>

<td>
<input type="number"
    class="form-control">
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

    
</body>
</html>