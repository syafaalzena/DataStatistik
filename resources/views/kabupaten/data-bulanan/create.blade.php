<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Produksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#F7F5F0;
        }

        .card-form{
            max-width:700px;
            margin:50px auto;
            border:none;
            border-radius:14px;
            box-shadow:0 2px 16px rgba(26,107,114,.08);
        }

        .card-header{
            background:#0d1b2a;
            color:white;
            border-radius:14px 14px 0 0 !important;
            padding:1rem 1.5rem;
        }

        .btn-simpan{
            background:#0d1b2a;
            color:#fff;
            border:none;
            border-radius:8px;
            padding:.55rem 1.4rem;
        }

        .btn-simpan:hover{
            color:#fff;
            opacity:.9;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="card card-form">
        <div class="card-header">
            <h5 class="mb-0">
                Tambah Data Produksi - {{ $kabupaten->nama_kabupaten }}
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('data-bulanan.store') }}" method="POST">
                @csrf

                <input type="hidden"
                       name="kabupaten_id"
                       value="{{ $kabupaten->id }}">

                <div class="mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="number"
                           name="tahun"
                           class="form-control"
                           placeholder="2024"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select" required>
                        <option value="">-- Pilih Bulan --</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Produksi</label>
                    <select name="jenis_produksi" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Rebus">Rebus</option>
                        <option value="Jemur">Jemur</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Produksi (Ton)</label>
                    <input type="number"
                           name="produksi"
                           class="form-control"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number"
                           name="harga"
                           class="form-control"
                           required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('kabupaten.show', $kabupaten->id) }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-simpan">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
</body>
</html>