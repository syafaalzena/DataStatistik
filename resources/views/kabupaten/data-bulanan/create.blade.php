<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Produksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --clr-sea:    #0d1b2a;
            --clr-sea-lt: #E8F5F6;
            --clr-salt:   #F7F5F0;
            --clr-stone:  #3D3D3A;
            --clr-mist:   #8A8A85;
            --clr-border: #E2DED6;
            --clr-white:  #FFFFFF;
            --clr-gold:   #C68B2F;
            --radius-card: 14px;
            --shadow-card: 0 2px 16px rgba(26,107,114,.08);
            --font-base:  'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: var(--clr-salt);
            font-family: var(--font-base);
            color: var(--clr-stone);
        }

        /* Container wrapper form */
        .form-container {
            max-width: 650px;
            margin: 40px auto 60px;
        }

        /* Desain Card Form disesuaikan tema */
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
            letter-spacing: 0.3px;
        }

        .card-body {
            padding: 2rem 1.5rem;
        }

        /* Desain Input & Select */
        .form-label {
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--clr-stone);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid var(--clr-border);
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 0.55rem 0.85rem;
            color: var(--clr-stone);
            background-color: var(--clr-white);
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--clr-sea);
            box-shadow: 0 0 0 3px rgba(13, 27, 42, 0.1);
        }

        /* Tombol Kembali Bulat Minimalis */
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
            flex-shrink: 0;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            background: #0f172a;
            border-color: #0f172a;
        }

        .btn-back:hover img {
            filter: brightness(0) invert(1);
        }

        /* Tombol Simpan */
        .btn-simpan {
            background: var(--clr-sea);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            padding: 0.55rem 1.8rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(13, 27, 42, 0.15);
        }

        .btn-simpan:hover {
            background: #1d2d44;
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">

        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('kabupaten.show', $kabupaten->id) }}" class="btn-back">
                <img src="{{ asset('images/back.png') }}" alt="Kembali" width="18" height="18" style="transition: filter 0.2s;">
            </a>
            <span class="ms-3 text-muted small fw-medium">Kembali ke Detail Kabupaten</span>
        </div>

        <div class="card card-form">
            <div class="card-header">
                <h5 class="mb-0">
                    Tambah Data Produksi — {{ $kabupaten->nama_kabupaten }}
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('data-bulanan.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="kabupaten_id" value="{{ $kabupaten->id }}">

                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number"
                               name="tahun"
                               class="form-control"
                               placeholder="Contoh: 2026"
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
                            <option value="Rebus">Rebus (Tunnel)</option>
                            <option value="Jemur">Jemur</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Produksi (Ton)</label>
                        <input type="number"
                               name="produksi"
                               class="form-control"
                               placeholder="0"
                               step="any"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number"
                               name="harga"
                               class="form-control"
                               placeholder="Contoh: 5000000"
                               required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-simpan">
                            Simpan Data
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>