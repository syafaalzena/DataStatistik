<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>

        <div class="container">
            <h3>Rekap Tahunan</h3>
        <table class="table table-bordered" border="1">
            <thead>
        <tr>
            <th>Kabupaten</th>
            <th>Petani</th>
            <th>Lahan Rebus</th>
            <th>Jumlah Unit</th>
        </tr>
        </thead>

        <tbody>

        @foreach($data as $row)

        <tr>
            <td>{{ $row->nama_kabupaten }}</td>
            <td>{{ $row->jumlah_petani }}</td>
            <td>{{ $row->luas_lahan_rebus }}</td>
            <td>{{ $row->jumlah_lahan_unit }}</td>
        </tr>

        @endforeach
        </tbody>
        </table>
        </div>
</body>
</html>