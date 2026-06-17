<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kabupaten->nama_kabupaten }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* ── Token System ─────────────────────────────── */
        :root {
            --clr-sea:      #0d1b2a;   /* teal laut dalam */
            --clr-sea-lt:   #E8F5F6;   /* teal muda / background accent */
            --clr-salt:     #F7F5F0;   /* krem pasir / page bg */
            --clr-stone:    #3D3D3A;   /* teks utama */
            --clr-mist:     #8A8A85;   /* teks sekunder */
            --clr-border:   #E2DED6;   /* garis halus */
            --clr-white:    #FFFFFF;
            --clr-gold:     #C68B2F;   /* aksen harga / angka penting */

            --radius-card:  14px;
            --shadow-card:  0 2px 16px rgba(26,107,114,.08);
            --font-base:    'Plus Jakarta Sans', sans-serif;
            --font-mono:    'DM Mono', monospace;
        }

        /* ── Base ─────────────────────────────────────── */
        body {
            background-color: var(--clr-salt);
            font-family: var(--font-base);
            color: var(--clr-stone);
            min-height: 100vh;
        }

        /* ── Header strip ─────────────────────────────── */
        .page-header {
            background: linear-gradient(135deg, var(--clr-sea) 0%, #0F4A50 100%);
            border-radius: 0 0 28px 28px;
            padding: 2rem 0 2.4rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Garis tipis seperti kristal garam — signature element */
        .page-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                105deg,
                transparent,
                transparent 38px,
                rgba(255,255,255,.04) 38px,
                rgba(255,255,255,.04) 39px
            );
            pointer-events: none;
        }

        /* Style Tombol Back disamakan persis dengan halaman utama */
        .btn-back {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff; /* Background putih polos */
            border: 1px solid #e2e8f0; /* Border abu-abu tipis */
            border-radius: 30px; /* Bulat sempurna */
            text-decoration: none;
            transition: all .2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
            flex-shrink: 0;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            background: #0f172a; /* Berubah jadi navy gelap saat di-hover */
            border-color: #0f172a;
        }

        /* Efek membalik warna gambar back.png jadi putih saat di-hover */
        .btn-back:hover img {
            filter: brightness(0) invert(1);
        }

        .page-header h2 {
            color: #fff;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -.3px;
        }

        .page-header .subtitle {
            color: rgba(255,255,255,.65);
            font-size: .88rem;
            margin: 0;
        }

        /* ── Cards ────────────────────────────────────── */
        .data-card {
            background: var(--clr-white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            border: 1px solid var(--clr-border);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .data-card-header {
            padding: 1.25rem 1.5rem 1rem;
            border-bottom: 1px solid var(--clr-border);
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .data-card-header .card-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: var(--clr-sea-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .data-card-header h5 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            color: var(--clr-stone);
        }

        .data-card-body {
            padding: 1.25rem 1.5rem 1.5rem;
        }

        /* ── Tables ───────────────────────────────────── */
        .table {
            font-size: .875rem;
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--clr-sea);
            color: #fff;
            font-weight: 600;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: .75rem 1rem;
            border: none;
            white-space: nowrap;
        }

        .table thead th:first-child { border-radius: 8px 0 0 0; }
        .table thead th:last-child  { border-radius: 0 8px 0 0; }

        .table tbody tr {
            border-bottom: 1px solid var(--clr-border);
            transition: background .15s;
        }
        .table tbody tr:last-child { border-bottom: none; }
        .table tbody tr:hover { background: var(--clr-sea-lt); }

        .table tbody td {
            padding: .7rem 1rem;
            vertical-align: middle;
            color: var(--clr-stone);
            border: none;
        }

        /* Kolom tahun & angka — mono agar lurus */
        .table tbody td:first-child,
        .table tbody td:nth-child(2),
        .table tbody td:nth-child(4),
        .table tbody td:nth-child(5) {
            font-family: var(--font-base);
            font-size: .83rem;
        }

        /* Kolom harga */
        .cell-harga {
            font-weight: 500;
            color: var(--clr-gold);
        }

        /* Badge tahun */
        .badge-tahun {
            display: inline-block;
            background: var(--clr-sea-lt);
            color: var(--clr-sea);
            border-radius: 6px;
            padding: .2rem .55rem;
            font-family: var(--font-base);
            font-size: .8rem;
            font-weight: 500;
        }

        /* ── Empty state ──────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--clr-mist);
        }
        .empty-state .empty-icon {
            font-size: 2rem;
            margin-bottom: .5rem;
            opacity: .5;
        }
        .empty-state p {
            font-size: .9rem;
            margin: 0;
        }

        /* ── Responsive ───────────────────────────────── */
        @media (max-width: 576px) {
            .page-header { border-radius: 0 0 20px 20px; padding: 1.5rem 0 2rem; }
            .page-header h2 { font-size: 1.35rem; }
            .data-card-body { padding: 1rem; }
        }

        .btn-simpan {
            background: var(--clr-sea);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: .88rem;
            padding: .55rem 1.4rem;
        }
        .btn-simpan:hover { opacity: .85; color: #fff; }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('kabupaten.index') }}" class="btn-back">
                <img src="{{ asset('images/back.png') }}" alt="Kembali" width="24" height="24">
            </a>
            
            <div>
                <h2 class="m-0">{{ $kabupaten->nama_kabupaten }}</h2>
                <p class="subtitle mt-1">Data statistik garam wilayah ini</p>
            </div>
        </div>
    </div>
    <div style="margin-left:60px; margin-top:14px;">
        <a href="{{ route('data-bulanan.create', $kabupaten->id) }}"
           class="btn btn-sm"
           style="background:white; color:black; border-radius:8px; font-size:.99rem; font-weight:600;">
             + Tambah Data Produksi
        </a>
    </div>
</div>

<div class="container pb-5">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show"
         role="alert"
         style="
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 4px 15px rgba(0,0,0,.15);
         ">
         {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>
    </div>
    @endif


    {{-- DATA BULANAN --}}
    <div class="data-card">
        <div class="data-card-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div style="display:flex; align-items:center; gap:.6rem;">
                <div class="card-icon">
                    <img src="{{ asset('images/kalender.png') }}"
                         alt="Kalender"
                         width="20"
                         height="20">
                </div>
                <h5>Data Bulanan</h5>
            </div>
        </div>
        <div class="data-card-body">
            @if($dataBulanan->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <p>Belum ada data bulanan untuk wilayah ini.</p>
                </div>
            @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Jenis Produksi</th>
                            <th>Produksi (Ton)</th>
                            <th>Harga (Rp)</th>
                            <th>Aksi<th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataBulanan as $db)
                        <tr>
                            <td><span class="badge-tahun">{{ $db->tahun }}</span></td>
                            <td>{{ $db->bulan }}</td>
                            <td>{{ $db->jenis_produksi }}</td>
                            <td>{{ $db->produksi }}</td>
                            <td class="cell-harga">Rp {{ number_format($db->harga, 0, ',', '.') }}</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <a href="{{ route('data-bulanan.edit', $db->id) }}"
                                       style="text-decoration:none; display:flex; align-items:center;">
                                        <img src="{{ asset('images/pencil.png') }}"
                                             alt="Edit"
                                             width="20"
                                             height="20">
                                    </a>

                                    <form action="{{ route('data-bulanan.destroy', $db->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                          style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background:none; border:none; padding:0; display:flex; align-items:center;">
                                            <img src="{{ asset('images/delete.png') }}"
                                                 alt="Hapus"
                                                 width="20"
                                                 height="20">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>