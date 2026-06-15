<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Produksi</title>

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
                Edit Data Produksi
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('data-bulanan.update', $dataBulanan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden"
                       name="kabupaten_id"
                       value="{{ $dataBulanan->kabupaten_id }}">

                <div class="mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="number"
                           name="tahun"
                           class="form-control"
                           value="{{ $dataBulanan->tahun }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select" required>
                        <option value="1" {{ $dataBulanan->bulan == 1 ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ $dataBulanan->bulan == 2 ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ $dataBulanan->bulan == 3 ? 'selected' : '' }}>Maret</option>
                        <option value="4" {{ $dataBulanan->bulan == 4 ? 'selected' : '' }}>April</option>
                        <option value="5" {{ $dataBulanan->bulan == 5 ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ $dataBulanan->bulan == 6 ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ $dataBulanan->bulan == 7 ? 'selected' : '' }}>Juli</option>
                        <option value="8" {{ $dataBulanan->bulan == 8 ? 'selected' : '' }}>Agustus</option>
                        <option value="9" {{ $dataBulanan->bulan == 9 ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $dataBulanan->bulan == 10 ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ $dataBulanan->bulan == 11 ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $dataBulanan->bulan == 12 ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Produksi</label>
                    <select name="jenis_produksi" class="form-select" required>
                        <option value="Rebus" {{ $dataBulanan->jenis_produksi == 'Rebus' ? 'selected' : '' }}>
                            Rebus
                        </option>
                        <option value="Jemur" {{ $dataBulanan->jenis_produksi == 'Jemur' ? 'selected' : '' }}>
                            Jemur
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Produksi (Ton)</label>
                    <input type="number"
                           name="produksi"
                           class="form-control"
                           value="{{ $dataBulanan->produksi }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number"
                           name="harga"
                           class="form-control"
                           value="{{ $dataBulanan->harga }}"
                           required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('kabupaten.show', $dataBulanan->kabupaten_id) }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-simpan">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>