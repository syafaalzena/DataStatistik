<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kabupaten - Laporan Operasional - SIDKP</title>

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

        .search-wrapper { max-width: 480px; margin: 0 auto 1.25rem auto; }
        .search-box input { width: 100%; padding: 12px 18px; border-radius: 30px; border: 1px solid #e2e8f0; background: #fff; }

        .kab-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
        @media (max-width: 992px) { .kab-list { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .kab-list { grid-template-columns: 1fr; } }

        .kab-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 16px; border-radius: 10px; border: 1px solid #eef0e8; background: #fff; text-decoration: none; color: var(--clr-dark); transition: all .15s ease; }
        .kab-item:hover { background: #f1f5f9; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(0,0,0,.05); color: var(--clr-dark); }
        .kab-item .kab-name { font-weight: 600; font-size: 14px; }
        .kab-empty { text-align: center; padding: 30px; color: #94a3b8; display: none; }
        .btn-dark-custom { background: var(--clr-dark); color: #fff; border-radius: 8px; font-weight: 600; border: none; padding: 10px 20px; text-decoration: none; display: inline-block; white-space: nowrap; }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }
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
    <div class="d-flex align-items-center justify-content-between gap-3 mb-4 flex-wrap">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('tangkap.index') }}" class="back-btn">&larr;</a>
            <div>
                <h2 class="fw-bold mb-1">Laporan Operasional Pelabuhan</h2>
                <p class="text-muted mb-0">Pilih kabupaten/kota untuk melihat atau menambah laporan.</p>
            </div>
        </div>
        <a href="{{ route('laporan-operasional.rekap') }}" class="btn-dark-custom">📊 Rekap Tahunan (Semua Kabupaten)</a>
    </div>

    <div class="search-wrapper">
        <div class="search-box">
            <input type="text" id="searchKabupaten" placeholder="Cari nama kabupaten atau kota...">
        </div>
    </div>

    <div class="kab-list" id="kabList">
        @forelse($kabupatenIkans as $kab)
            <a href="{{ route('laporan-operasional.index', $kab->id) }}" class="kab-item" data-name="{{ strtolower($kab->nama_kabupaten) }}">
                <span class="kab-name">{{ $kab->nama_kabupaten }}</span>
                <span>&rarr;</span>
            </a>
        @empty
            <div class="p-4 text-center">
                <div class="alert alert-warning mb-0">Belum ada data kabupaten.</div>
            </div>
        @endforelse
    </div>

    <div class="kab-empty" id="kabEmpty">Tidak ada kabupaten yang cocok dengan pencarian.</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const searchInput = document.getElementById('searchKabupaten');
    const items = document.querySelectorAll('#kabList .kab-item');
    const emptyState = document.getElementById('kabEmpty');

    searchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        let visibleCount = 0;
        items.forEach(function (item) {
            const match = item.getAttribute('data-name').includes(query);
            item.style.display = match ? 'flex' : 'none';
            if (match) visibleCount++;
        });
        emptyState.style.display = (visibleCount === 0 && items.length > 0) ? 'block' : 'none';
    });
</script>
</body>
</html>