<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background-color: #f8f9fa;
        }

        .table-container{
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        h3{
            font-size: 22px;
            font-weight: 600;
            color: #343a40;
        }

        .table th{
            background-color: #f1f3f5;
            color: #212529;
            text-align: center;
            vertical-align: middle;
        }

        .table td{
            text-align: center;
            vertical-align: middle;
        }

        .table tbody tr:hover{
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <div class="table-container">

        <h3 class="mb-3">Rekap Bulanan</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Kabupaten</th>
                    <th>Bulan</th>
                    <th>Jenis Produksi</th>
                    <th>Produksi</th>
                    <th>Harga</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-start">{{ $row->nama_kabupaten }}</td>
                    <td>{{ $row->bulan }}</td>
                    <td>{{ $row->jenis_produksi }}</td>
                    <td>{{ number_format($row->produksi) }}</td>
                    <td>Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

</body>
</html>