<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Statistik Garam Provinsi Aceh</title>
    
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
            margin-bottom: 2rem;
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

        /* Style Konten */
        .kab-card {
            border-radius: 12px;
            border: 1px solid #d6d7c4;
            transition: all 0.2s ease;
        }
        .kab-card:hover {
            background-color: #0f172a;
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
        }
        .kab-card:hover h5 { color: white !important; }
        
        .transition-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .transition-card:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important; }

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

        .btn-custom-dark {
            background: var(--clr-dark);
            color: #f5f6e7ff;
            padding: 12px 40px; 
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom-dark:hover {
            background: #1e293b;
            color: #ffffff;
            transform: translateY(-1px);
        }

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
        <div class="row mb-4 align-items-center">
            <div class="col-12">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('statistik.index') }}" class="back-btn">
                        <img src="{{ asset('images/back.png') }}" alt="Back" width="24" height="24">
                    </a>
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Data Statistik Garam Provinsi Aceh</h2>
                        <p class="text-muted mb-0">Silahkan pilih wilayah kabupaten untuk mengelola data atau lihat total rekapitulasi provinsi di bawah.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD KABUPATEN --}}
        <div class="row g-3 mb-4">
            @foreach($kabupaten as $kab)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('kabupaten.show', $kab->id) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm text-center p-3 kab-card">
                        <div class="card-body">
                            <h5 class="fw-semibold text-dark">{{ $kab->nama_kabupaten }}</h5>
                        </div>
                    </div>
                </a>
            </div> 
            @endforeach
        </div>

        {{-- REKAP PROVINSI --}}
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(145deg, #1e293b, #0f172a); border-radius: 16px;">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <h4 class="fw-bold mb-2">Akumulasi Data Tingkat Provinsi</h4>
                        <p class="text-white-50 m-0">Ringkasan total keseluruhan data dari seluruh kabupaten.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="bg-white bg-opacity-10 p-3 rounded-3 d-inline-block text-center">
                            <span class="small text-white-50 d-block">Total Wilayah</span>
                            <span class="fs-3 fw-bold">{{ $kabupaten->count() }} Kabupaten</span>
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
                            <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                                <img src="{{ asset('images/kalender.png') }}" alt="Kalender" width="24" height="24">
                                Rekap Bulanan Provinsi
                            </h5>
                            <p class="text-muted small m-0">Lihat total grafik bulanan se-Aceh</p>
                        </div>
                        <a href="{{ route('garam.rekapBulanan') }}" class="btn btn-dark px-4 py-2 fw-semibold" style="border-radius: 8px;">Buka Rekap</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm transition-card" style="border-radius: 12px;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                                <img src="{{ asset('images/statistik.png') }}" alt="Statistik" width="24" height="24">
                                Rekap Tahunan Provinsi
                            </h5>
                            <p class="text-muted small m-0">Lihat perbandingan total tahunan semua wilayah</p>
                        </div>
                        <a href="{{ route('garam.rekapTahunan') }}" class="btn btn-dark px-4 py-2 fw-semibold" style="border-radius: 8px;">Buka Rekap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>