<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDKP - Sistem Informasi Dinas Kelautan dan Perikanan</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Croissant+One&family=Dancing+Script:wght@400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --clr-bg: #F7F5F0;
            --clr-dark: #0f172a;
            --clr-blue-brand: #38bdf8;
            --clr-text-muted: #64748b;
            --clr-border: #e2e8f0;
        }

        body { 
            background: var(--clr-bg); 
            font-family: 'Poppins', sans-serif; 
            color: var(--clr-dark);
        }

        /* Navbar Modern */
        .navbar {
            background: var(--clr-dark);
            color: white;
            padding: 14px 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        /* Styling Brand / Logo MINA */
        .brand-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-text {
            font-size: 22px;
            color: #ffffff;
            line-height: 1;
            padding-top: 2px;
            font-weight: 600;
        }

        /* Ikon Ikan SVG */
        .brand-logo-svg {
            width: 32px;
            height: 32px;
            fill: var(--clr-blue-brand);
            transition: transform 0.3s ease;
        }

        .brand-wrapper:hover .brand-logo-svg {
            transform: rotate(10deg) scale(1.05);
        }

        .brand-logo-img {
            height: 30px;
            width: auto;
            object-fit: contain;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #0c4a6e 100%);
            border-radius: 20px;
            padding: 36px 40px;
            margin-top: 28px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            color: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        }

        .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(56, 189, 248, 0.15);
            color: var(--clr-blue-brand);
            padding: 5px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 14px;
        }

        .welcome-banner h3 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .welcome-banner p {
            color: rgba(248, 250, 252, 0.7);
            font-size: 14px;
            margin-bottom: 0;
            max-width: 520px;
        }

        .welcome-banner-decor {
            position: absolute;
            right: -10px;
            bottom: -30px;
            opacity: 0.12;
            pointer-events: none;
        }

        .welcome-banner-decor svg {
            width: 200px;
            height: 200px;
        }

        @media (max-width: 576px) {
            .welcome-banner { padding: 28px 24px; }
            .welcome-banner h3 { font-size: 20px; }
        }

        /* Kontainer Scroll Horizontal Modern */
        .scroll-container-wrapper {
            position: relative;
        }

        .horizontal-scroll-row {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 25px;
            padding-top: 10px;
            -webkit-overflow-scrolling: touch;
        }

        .horizontal-scroll-row::-webkit-scrollbar {
            height: 8px;
        }
        .horizontal-scroll-row::-webkit-scrollbar-track {
            background: transparent;
        }
        .horizontal-scroll-row::-webkit-scrollbar-thumb {
            background: #a5a5a56a;
            border-radius: 20px;
        }

        .scroll-card-item {
            flex: 0 0 auto;
            width: 450px; 
            max-width: 90vw;
        }

        .custom-card {
            background: #ffffff;
            border: 1px solid var(--clr-border);
            border-radius: 16px;
            padding: 35px;
            transition: all 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.31) !important;
        }

        .custom-card h2 {
            font-size: 19px;
            font-weight: 600;
        }

        .btn-custom-dark {
            background: var(--clr-dark);
            color: #f5f6e7ff;
            padding: 12px 28px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.25s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-custom-dark svg {
            width: 16px;
            height: 16px;
            transition: transform 0.25s ease;
        }

        .btn-custom-dark:hover {
            background: rgba(186, 186, 186, 1);
            color: var(--clr-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(190, 190, 190, 0.35);
            outline: 2px solid rgba(138, 138, 138, 1);
        }

        .btn-custom-dark:hover svg {
            transform: translateX(4px);
        }

        .card-icon {
            object-fit: contain;
            vertical-align: middle;
        }

        .scroll-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-70%);
            width: 48px;
            height: 48px;
            background: #ffffff;
            border: 1px solid var(--clr-border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            z-index: 10;
            transition: all 0.2s;
        }
        
        .scroll-nav-btn:hover {
            background: var(--clr-dark);
            border-color: var(--clr-dark);
        }

        .scroll-nav-btn:hover img {
            filter: brightness(0) invert(1);
        }

        .scroll-btn-left { 
            left: -40px; 
        }
        
        .scroll-btn-right { 
            right: -40px; 
        }

        .img-flip-horizontal {
            transform: scaleX(-1);
        }

        .footer {
            padding: 2.5rem 0;
            background: var(--clr-dark);
            text-align: center;
            font-size: 0.9rem;
            color: rgba(248, 250, 252, 0.65);
            border-top: none;
        }

        .footer p.fw-semibold {
            color: #f8fafc;
            font-size: 1rem;
            letter-spacing: 0.3px;
        }

        .footer .opacity-75 {
            color: rgba(248, 250, 252, 0.5);
        }

        .footer {
            border-top: 1px solid rgba(56, 189, 248, 0.2);
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

        /* ── MODAL KONFIRMASI LOGOUT ─────────────────────────── */
        .logout-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        .logout-modal-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .logout-modal-box {
            background: #ffffff;
            border-radius: 20px;
            padding: 32px 30px;
            width: 100%;
            max-width: 380px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.25);
            transform: translateY(20px) scale(0.96);
            transition: transform 0.25s ease;
        }

        .logout-modal-overlay.active .logout-modal-box {
            transform: translateY(0) scale(1);
        }

        .logout-modal-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(68, 105, 239, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px auto;
        }

        .logout-modal-icon svg {
            width: 30px;
            height: 30px;
            fill: #3661afff;
        }

        .logout-modal-box h4 {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--clr-dark);
            margin-bottom: 8px;
        }

        .logout-modal-box p {
            color: var(--clr-text-muted);
            font-size: 0.85rem;
            margin-bottom: 26px;
        }

        .logout-modal-actions {
            display: flex;
            gap: 12px;
        }

        .logout-modal-actions button {
            flex: 1;
            padding: 11px 0;
            border-radius: 14px;
            font-weight: 500;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-logout-cancel {
            background: var(--clr-bg);
            color: var(--clr-dark);
            border: 1px solid var(--clr-border) !important;
        }

        .btn-logout-cancel:hover {
            background: #ececec;
        }

        .btn-logout-confirm {
            background: #2b4d8fff;
            color: #ffffff;
        }

        .btn-logout-confirm:hover {
            background: #103755ff;
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

        <button type="button" class="btn-logout-icon" title="Logout" id="openLogoutModal">
            <img src="{{ asset('images/logout.png') }}" alt="Logout" width="20" height="20">
        </button>
    </div>
</nav>

{{-- ── MODAL KONFIRMASI LOGOUT ─────────────────────────────── --}}
<div class="logout-modal-overlay" id="logoutModal">
    <div class="logout-modal-box">
        <div class="logout-modal-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M16,17V14H9V10H16V7L21,12L16,17M14,2A2,2 0 0,1 16,4V6H14V4H5V20H14V18H16V20A2,2 0 0,1 14,22H5A2,2 0 0,1 3,20V4A2,2 0 0,1 5,2H14Z"/>
            </svg>
        </div>
        <h4>Yakin ingin logout?</h4>
        <p>Anda akan keluar dari sesi ini dan perlu login kembali untuk mengakses sistem.</p>

        <div class="logout-modal-actions">
            <button type="button" class="btn-logout-cancel" id="cancelLogout">Batal</button>
            <form method="POST" action="{{ route('logout') }}" class="mb-0" style="flex:1;">
                @csrf
                <button type="submit" class="btn-logout-confirm w-100">Ya, Logout</button>
            </form>
        </div>
    </div>
</div>

    <div class="container mb-5">

        <div class="welcome-banner">
            <span class="welcome-badge">👋 Selamat Datang Kembali</span>
            <h3>Halo, {{ auth()->user()->name }}!</h3>
            <p>Silahkan pilih menu di bawah ini untuk mulai mengelola data statistik kelautan dan perikanan Provinsi Aceh.</p>

            <div class="welcome-banner-decor">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M2,12C2,12 5,7 12,7C15.5,7 18.5,8.5 20.5,10.5L22,9V15L20.5,13.5C18.5,15.5 15.5,17 12,17C5,17 2,12 2,12M12,9C10.34,9 9,10.34 9,12C9,13.66 10.34,15 12,15C13.66,15 15,13.66 15,12C15,10.34 13.66,9 12,9Z"/>
                </svg>
            </div>
        </div>

        <div class="scroll-container-wrapper">
            
            <button class="scroll-nav-btn scroll-btn-left" onclick="scrollSlide('left')">
                <img src="{{ asset('images/back.png') }}" alt="Geser Kiri" width="22" height="22">
            </button>
            
            <button class="scroll-nav-btn scroll-btn-right" onclick="scrollSlide('right')">
                <img src="{{ asset('images/back.png') }}" alt="Geser Kanan" width="22" height="22" class="img-flip-horizontal">
            </button>

            <div class="horizontal-scroll-row g-4" id="menuScrollRow">
                
                <div class="scroll-card-item px-2">
                    <div class="custom-card h-100 d-flex flex-column justify-content-between shadow-sm">
                        <div>
                            <h2 class="mb-3 d-flex align-items-center gap-2">
                                <img src="{{ asset('images/salt.png') }}" alt="Garam" width="32" height="32" class="card-icon">
                                Data Garam
                            </h2>
                            <p style="color: var(--clr-text-muted); line-height: 1.7; font-size: 14px;">
                                Kelola data produksi garam dan statistik garam Aceh berdasarkan kabupaten/kota.
                            </p>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('kabupaten.index') }}" class="btn-custom-dark">
                                Masuk
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59,16.59L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.59Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="scroll-card-item px-2">
                    <div class="custom-card h-100 d-flex flex-column justify-content-between shadow-sm">
                        <div>
                            <h2 class="mb-3 d-flex align-items-center gap-2">
                                <img src="{{ asset('images/fish.png') }}" alt="Ikan" width="32" height="32" class="card-icon">
                                Data Budidaya Ikan
                            </h2>
                            <p style="color: var(--clr-text-muted); line-height: 1.7; font-size: 14px;">
                                Kelola data budidaya garam dan informasi pendukung untuk kebutuhan pelaporan.
                            </p>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('budidaya.index') }}" class="btn-custom-dark">
                                Masuk
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59,16.59L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.59Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="scroll-card-item px-2">
                    <div class="custom-card h-100 d-flex flex-column justify-content-between shadow-sm">
                        <div>
                            <h2 class="mb-3 d-flex align-items-center gap-2">
                                <img src="{{ asset('images/wave.png') }}" alt="Kelautan" width="32" height="32" class="card-icon" style="filter: hue-rotate(50deg);">
                                Data Budidaya Tangkap
                            </h2>
                            <p style="color: var(--clr-text-muted); line-height: 1.7; font-size: 14px;">
                                Kelola wilayah laut, pelabuhan, serta Hasil Tangkap Provinsi Aceh.
                            </p>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="#" class="btn-custom-dark">
                                Masuk
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59,16.59L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.59Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function scrollSlide(direction) {
            const row = document.getElementById('menuScrollRow');
            const scrollAmount = 470;
            row.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth'
            });
        }

        // ── LOGIKA MODAL KONFIRMASI LOGOUT ──────────────────────
        const logoutModal      = document.getElementById('logoutModal');
        const openLogoutModal  = document.getElementById('openLogoutModal');
        const cancelLogout     = document.getElementById('cancelLogout');

        openLogoutModal.addEventListener('click', () => {
            logoutModal.classList.add('active');
        });

        cancelLogout.addEventListener('click', () => {
            logoutModal.classList.remove('active');
        });

        // Tutup modal kalau klik di luar box
        logoutModal.addEventListener('click', (e) => {
            if (e.target === logoutModal) {
                logoutModal.classList.remove('active');
            }
        });

        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                logoutModal.classList.remove('active');
            }
        });
    </script>
</body>
</html>