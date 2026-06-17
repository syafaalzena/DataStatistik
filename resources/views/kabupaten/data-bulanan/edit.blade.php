<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Produksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --clr-sea:    #0d1b2a;
            --clr-sea-lt: #E8F5F6;
            --clr-salt:   #F7F5F0;
            --clr-stone:  #3D3D3A;
            --clr-border: #E2DED6;
            --clr-white:  #FFFFFF;
            --radius-card: 14px;
            --shadow-card: 0 2px 16px rgba(26,107,114,.08);
            --font-base:  'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: var(--clr-salt);
            font-family: var(--font-base);
            color: var(--clr-stone);
        }

        .form-container {
            max-width: 650px;
            margin: 40px auto 60px;
        }

        .card-form {
            background: var(--clr-white);
            border: 1px solid var(--clr-border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--clr-sea) 0%, #0F4A50 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
            position: relative;
        }

        .card-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(105deg, transparent, transparent 38px, rgba(255,255,255,.03) 38px, rgba(255,255,255,.03) 39px);
            pointer-events: none;
        }

        .card-header h5 {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .card-body { padding: 2rem 1.5rem; }

        .form-label { font-weight: 600; font-size: 0.88rem; margin-bottom: 0.5rem; }

        .form-control, .form-select {
            border: 1px solid var(--clr-border);
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 0.55rem 0.85rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--clr-sea);
            box-shadow: 0 0 0 3px rgba(13, 27, 42, 0.1);
        }

        .btn-back {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 30px;
            text-decoration: none;
            transition: all .2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
        }

        .btn-back:hover {
            transform: translateY(-2px);
            background: #0f172a;
            border-color: #0f172a;
        }

        .btn-back:hover img {
            filter: brightness(0) invert(1);
        }

        .btn-simpan {
            background: var(--clr-sea);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            padding: 0.55rem 1.8rem;
            transition: all 0.2s ease;
        }

        .btn-simpan:hover { background: #1d2d44; color: #fff; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">

        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('kabupaten.show', $dataBulanan->kabupaten_id) }}" class="btn-back">
                <img src="{{ asset('images/back.png') }}" alt="Kembali" width="18" height="18">
            </a>
            <span class="ms-3 text-muted small fw-medium">Kembali ke Detail Kabupaten</span>
        </div>

        <div class="card card-form">
            <div class="card-header">
                <h5 class="mb-0">Edit Data Produksi</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('data-bulanan.update', $dataBulanan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="kabupaten_id" value="{{ $dataBulanan->kabupaten_id }}">

                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="tahun" class="form-control" value="{{ $dataBulanan->tahun }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select" required>
                            @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $nama)
                                <option value="{{ $num }}" {{ $dataBulanan->bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Produksi</label>
                        <select name="jenis_produksi" class="form-select" required>
                            <option value="Rebus" {{ $dataBulanan->jenis_produksi == 'Rebus' ? 'selected' : '' }}>Rebus</option>
                            <option value="Jemur" {{ $dataBulanan->jenis_produksi == 'Jemur' ? 'selected' : '' }}>Jemur</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Produksi (Ton)</label>
                        <input type="number" name="produksi" class="form-control" value="{{ $dataBulanan->produksi }}" step="any" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ $dataBulanan->harga }}" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-simpan">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>