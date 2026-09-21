<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tangkap - SIDKP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --clr-bg: #F7F5F0; --clr-dark: #0f172a; --clr-blue-brand: #38bdf8; }
        body { background: var(--clr-bg); font-family: 'Inter', sans-serif; color: var(--clr-dark); }
        .navbar { background: var(--clr-dark); color: white; padding: 14px 0; margin-bottom: 1.25rem; }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-text { font-weight: bold; font-size: 26px; color: #fff; }
        .back-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #e2e8f0; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
        .back-btn:hover { background: #0f172a; color: #fff; }
        .btn-logout-icon { background: transparent; border: 1.5px solid rgba(248,250,252,.25); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }

        .kategori-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        @media (max-width: 768px) { .kategori-grid { grid-template-columns: 1fr; } }

        .kategori-card {
            background: #fff; border: 1px solid #eef0e8; border-radius: 16px; padding: 28px;
            text-decoration: none; color: var(--clr-dark); display: block;
            box-shadow: 0 2px 8px rgba(0,0,0,.04); transition: all .18s ease;
        }
        .kategori-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.08); color: var(--clr-dark); border-color: #cbd5e1; }
        .kategori-icon {
            width: 52px; height: 52px; border-radius: 14px; background: #e0f2fe; color: #0369a1;
            display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;
        }
        .kategori-title { font-weight: 700; font-size: 18px; margin-bottom: 6px; }
        .kategori-sub { color: #64748b; font-size: 14px; margin-bottom: 12px; }
        .kategori-count { font-size: 12px; font-weight: 600; color: #0369a1; background: #e0f2fe; padding: 4px 10px; border-radius: 20px; display: inline-block; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="brand-wrapper">
            <span class="brand-text">SIDKP</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn-logout-icon" title="Logout"></button>
        </form>
    </div>
</nav>

<div class="container pb-5">
    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('dashboard') }}" class="back-btn">&larr;</a>
        <div>
            <h2 class="fw-bold mb-1">Data Tangkap</h2>
            <p class="text-muted mb-0">Pilih kategori data tangkap yang ingin dikelola.</p>
        </div>
    </div>

    <div class="kategori-grid">
        <a href="{{ route('tangkap.produksi.index') }}" class="kategori-card">
            <div class="kategori-icon">🐟</div>
            <div class="kategori-title">Produksi Tangkap per Kabupaten</div>
            <div class="kategori-sub">Input data produksi tangkap per komoditas, WPPNRI, alat tangkap, dan ukuran kapal per kabupaten/kota.</div>
            <span class="kategori-count">{{ $totalProduksiKabupaten }} Kabupaten/Kota</span>
        </a>

        <a href="{{ route('laporan-operasional.index') }}" class="kategori-card">
            <div class="kategori-icon">📋</div>
            <div class="kategori-title">Laporan Operasional Pelabuhan Perikanan</div>
            <div class="kategori-sub">Input rekapitulasi aktivitas harian pelabuhan: armada, produksi ikan dominan, logistik, dan pemasaran per bulan.</div>
            <span class="kategori-count">{{ $totalLaporanOperasional }} Laporan Tersimpan</span>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>