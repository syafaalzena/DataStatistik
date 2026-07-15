<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Statistik Budidaya Provinsi Aceh</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Croissant+One&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --clr-bg: #F7F5F0;
            --clr-dark: #0f172a;
            --clr-blue-brand: #38bdf8;
        }

        body { 
            background: var(--clr-bg); 
            font-family: 'Inter', sans-serif; 
            color: var(--clr-dark);
        }

        /* Navbar Modern (Sama dengan Dashboard) */
        .navbar {
            background: var(--clr-dark);
            color: white;
            padding: 14px 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            margin-bottom: 1.25rem;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-text {
            font-weight: bold;
            font-size: 26px;
            color: #ffffff;
        }

        .brand-logo-svg {
            width: 32px;
            height: 32px;
            fill: var(--clr-blue-brand);
        }

        .back-btn {
            width: 48px;
            height: 48px;
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
        .back-btn:hover { transform: translateY(-2px); background: #0f172a; border-color: #0f172a; }
        .back-btn:hover img { filter: brightness(0) invert(1); }

        .btn-logout-icon {
            background: transparent;
            border: 1.5px solid rgba(248, 250, 252, 0.25);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-logout-icon img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
            transition: transform 0.25s ease;
        }

        .btn-logout-icon:hover {
            background: var(--clr-blue-brand);
            border-color: var(--clr-blue-brand);
        }

        .btn-logout-icon:hover img {
            transform: translateX(2px);
            filter: none;
        }

        /* Search Box */
        .search-wrapper {
            max-width: 480px;
            margin: 0 auto 1.25rem auto;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 12px 18px 12px 44px;
            border-radius: 30px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            font-size: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,.04);
            transition: all .2s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--clr-blue-brand);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
        }

        .search-box svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            fill: #94a3b8;
            pointer-events: none;
        }

        /* Compact List (grid multi-kolom biar muat 1 layar) */
        .kab-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        @media (max-width: 992px) {
            .kab-list { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 576px) {
            .kab-list { grid-template-columns: 1fr; }
        }

        .kab-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            border-radius: 10px;
            border: 1px solid #eef0e8;
            background: #ffffff;
            text-decoration: none;
            color: var(--clr-dark);
            transition: background .15s ease, transform .15s ease, box-shadow .15s ease;
        }

        .kab-item:hover {
            background: #f1f5f9;
            color: var(--clr-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0,0,0,.05);
        }

        .kab-item .kab-name {
            font-weight: 600;
            font-size: 14px;
        }

        .kab-item .kab-arrow {
            width: 16px;
            height: 16px;
            fill: #94a3b8;
            flex-shrink: 0;
            transition: transform .15s ease;
        }

        .kab-item:hover .kab-arrow {
            transform: translateX(3px);
            fill: var(--clr-blue-brand);
        }

        .kab-empty {
            text-align: center;
            padding: 30px 20px;
            color: #94a3b8;
            font-size: 14px;
            display: none;
        }

        .transition-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .transition-card:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important; }

        .brand-logo-img {
    height: 30px;      /* samain sama font-size .brand-text (26px) */
    width: auto;       /* ikut aspect ratio asli, nggak dipotong */
    object-fit: contain;
}

.brand-logo-img {
    height: 30px;      /* samain sama font-size .brand-text (26px) */
    width: auto;       /* ikut aspect ratio asli, nggak dipotong */
    object-fit: contain;
}
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="brand-wrapper">
            <img src="{{ asset('images/pancacita.png') }}" alt="Logo Pancacita" class="brand-logo-img">
            <span class="brand-text">SIDKP</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn-logout-icon" title="Logout">
                <img src="{{ asset('images/logout.png') }}" alt="Logout" width="20" height="20">
            </button>
        </form>
    </div>
</nav>

<div class="container pb-5">

    <div class="row mb-3 align-items-center">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('statistik.index') }}" class="back-btn">
                    <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
                </a>
                <div>
                    <h2 class="fw-bold mb-1">Data Statistik Budidaya Provinsi Aceh</h2>
                    <p class="text-muted mb-0">Silakan pilih kabupaten untuk mengelola data budidaya.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- SEARCH BOX --}}
    <div class="search-wrapper">
        <div class="search-box">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.5,14H14.71L14.43,13.73C15.41,12.59 16,11.11 16,9.5A6.5,6.5 0 0,0 9.5,3A6.5,6.5 0 0,0 3,9.5A6.5,6.5 0 0,0 9.5,16C11.11,16 12.59,15.41 13.73,14.43L14,14.71V15.5L19,20.49L20.49,19L15.5,14M9.5,14C7,14 5,12 5,9.5C5,7 7,5 9.5,5C12,5 14,7 14,9.5C14,12 12,14 9.5,14Z"/>
            </svg>
            <input type="text" id="searchKabupaten" placeholder="Cari nama kabupaten atau kota...">
        </div>
    </div>

    {{-- COMPACT LIST --}}
    <div class="kab-list" id="kabList">
        @forelse($kabupatenIkans as $kab)
        <a href="{{ route('budidaya.input', $kab->id) }}" class="kab-item" data-name="{{ strtolower($kab->nama_kabupaten) }}">
            <span class="kab-name">{{ $kab->nama_kabupaten }}</span>
            <svg class="kab-arrow" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.59,16.59L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.59Z"/>
            </svg>
        </a>
        @empty
        <div class="p-4 text-center">
            <div class="alert alert-warning mb-0">Belum ada data kabupaten.</div>
        </div>
        @endforelse
    </div>

    <div class="kab-empty" id="kabEmpty">Tidak ada kabupaten yang cocok dengan pencarian.</div>

    {{-- REKAP PROVINSI --}}
    <div class="card border-0 shadow-sm mb-4 mt-4" style="background: linear-gradient(145deg, #1e293b, #0f172a); border-radius: 16px;">
        <div class="card-body p-4 text-white">
            <div class="row align-items-center">
                <div class="col-md-8 mb-3 mb-md-0">
                    <h4 class="fw-bold mb-2">Akumulasi Data Tingkat Provinsi</h4>
                    <p class="text-white-50 m-0">Ringkasan total keseluruhan data budidaya dari seluruh kabupaten.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="bg-white bg-opacity-10 p-3 rounded-3 d-inline-block text-center">
                        <span class="small text-white-50 d-block">Total Wilayah</span>
                        <span class="fs-3 fw-bold">{{ $kabupatenIkans->count() }} Kabupaten</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- REKAP BULANAN & TAHUNAN --}}
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm transition-card" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Rekap Bulanan Provinsi</h5>
                        <p class="text-muted small m-0">Rentang bulan bebas, per kabupaten atau semua</p>
                    </div>
                    <a href="{{ route('budidaya.rekapBulanan') }}" class="btn btn-dark px-4 py-2 fw-semibold" style="border-radius: 8px;">Buka Rekap</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm transition-card" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Rekap Tahunan Provinsi</h5>
                        <p class="text-muted small m-0">Pilih 1 tahun, tampil semua kabupaten</p>
                    </div>
                    <a href="{{ route('budidaya.rekapTahunan') }}" class="btn btn-dark px-4 py-2 fw-semibold" style="border-radius: 8px;">Buka Rekap</a>
                </div>
            </div>
        </div>
    </div>

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
            const name = item.getAttribute('data-name');
            const match = name.includes(query);
            item.style.display = match ? 'flex' : 'none';
            if (match) visibleCount++;
        });

        emptyState.style.display = (visibleCount === 0 && items.length > 0) ? 'block' : 'none';
    });
</script>

</body>
</html>