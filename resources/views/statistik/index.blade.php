<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistik Garam Aceh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --clr-bg: #F7F5F0;
            --clr-dark: #0f172a;
            --clr-text-muted: #64748b;
            --clr-border: #e2e8f0;
        }

        body { 
            background: var(--clr-bg); 
            font-family: 'Inter', sans-serif; 
            color: var(--clr-dark);
        }

        /* Navbar Modern */
        .navbar {
            background: var(--clr-dark);
            color: white;
            padding: 18px 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        /* Card Custom Styling */
        .custom-card {
            background: #ffffff;
            border: 1px solid var(--clr-border);
            border-radius: 16px;
            padding: 35px;
            transition: all 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.08) !important;
        }

        /* Button Modern */
        .btn-custom-dark {
            background: var(--clr-dark);
            color: #ffffff;
            padding: 12px 28px;
            border-radius: 10px;
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

        /* Icon Wrapper di Judul */
        .card-icon {
            object-fit: contain;
            vertical-align: middle;
        }
    </style>
</head>
<body>

    <nav class="navbar mb-5">
        <div class="container">
            <span class="navbar-brand mb-0 h2 fw-bold text-white fs-4">Data Statistik Kelautan dan Perikanan Provinsi Aceh</span>
        </div>
    </nav>

    <div class="container mb-5">

        <div class="row mb-4">
            <div class="col-12">
                <h1 class="fw-extrabold display-5 mb-2" style="font-weight: 600; color: var(--clr-dark);">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</h1>
                <p class="fs-6" style="color: var(--clr-text-muted);">Silakan pilih menu yang ingin Anda kelola.</p>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="custom-card h-100 d-flex flex-column justify-content-between shadow-sm">
                    <div>
                        <h2 class="fw-bold fs-3 mb-3 d-flex align-items-center gap-2">
                            <img src="{{ asset('images/salt.png') }}" alt="Garam" width="32" height="32" class="card-icon">
                            Data Garam
                        </h2>
                        <p style="color: var(--clr-text-muted); line-height: 1.7; font-size: 15px;">
                            Kelola data produksi garam dan statistik garam Aceh berdasarkan kabupaten/kota.
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('kabupaten.index') }}" class="btn-custom-dark">
                            Masuk
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="custom-card h-100 d-flex flex-column justify-content-between shadow-sm">
                    <div>
                        <h2 class="fw-bold fs-3 mb-3 d-flex align-items-center gap-2">
                            <img src="{{ asset('images/fish.png') }}" alt="Ikan" width="32" height="32" class="card-icon">
                            Data Budidaya Ikan
                        </h2>
                        <p style="color: var(--clr-text-muted); line-height: 1.7; font-size: 15px;">
                            Kelola data budidaya garam dan informasi pendukung untuk kebutuhan pelaporan.
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="btn-custom-dark">
                            Masuk
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>