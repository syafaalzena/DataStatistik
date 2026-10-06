<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDKP - Sistem Informasi Statistik Kelautan dan Perikanan Aceh</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Croissant+One&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --clr-bg: #fffcf3;
            --clr-dark: #0f172a;
            --clr-blue-brand: #38bdf8;
            --clr-text-muted: #64748b;
            --clr-border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: var(--clr-bg);
            color: var(--clr-dark);
            overflow-x: hidden;
        }

        /* ================= NAVBAR ================= */

        .navbar {
            position: fixed;
            top: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: min(92%, 1360px);
            padding: 6px 20px;
            background: rgba(15, 23, 42, 0.90);
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 8px 24px rgba(0,0,0,.13);
            z-index: 1000;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            gap: 11px;
            text-decoration: none;
        }

        .brand-text {
            font-size: 24px;
            color: #fff;
            line-height: 1;
            font-weight: 700;
        }

        .brand-logo-img {
            height: 27px;
            width: auto;
            object-fit: contain;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #loginBtn {
            border: 0;
            color: #0f172a;
            background: rgba(255,255,255,.94);
            transition: .25s ease;
        }

        #loginBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255,255,255,.20);
        }

        .nav-profile-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,.8);
            cursor: pointer;
            transition: .25s ease;
        }

        .nav-profile-img:hover {
            transform: scale(1.07);
            box-shadow: 0 0 18px rgba(125,211,252,.55);
        }

        /* ================= HERO ================= */

        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 92px 0 70px;
            color: #fff;

            background:
                linear-gradient(
                    90deg,
                    rgba(7, 31, 46, .80) 0%,
                    rgba(10, 55, 72, .62) 36%,
                    rgba(15, 23, 42, .22) 70%,
                    rgba(15, 23, 42, .08) 100%
                ),
                url("https://images.unsplash.com/photo-1518837695005-2083093ee35b?auto=format&fit=crop&w=2400&q=90")
                center center / cover no-repeat;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    180deg,
                    rgba(0,0,0,.04) 0%,
                    transparent 60%,
                    rgba(3,20,30,.30) 100%
                );
            pointer-events: none;
            z-index: 1;
        }

        .hero .container {
            position: relative;
            z-index: 3;
        }

        .hero-left {
            animation: fadeInUp 1s ease-out forwards;
        }

        .hero-left .label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .82rem;
            font-weight: 700;
            color: rgba(255,255,255,.82);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: .9rem;
            text-shadow: 0 2px 12px rgba(0,0,0,.25);
        }

        .hero-left h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(2.8rem, 5vw, 4.7rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.04;
            margin-bottom: 1.4rem;
            letter-spacing: -2px;
            max-width: 760px;
            text-shadow: 0 5px 25px rgba(0,0,0,.25);
        }

        .text-switcher-container {
            min-height: 90px;
            margin-bottom: 2rem;
            max-width: 650px;
            position: relative;
            padding-left: 17px;
        }

        .text-switcher-container::before {
            content: "";
            position: absolute;
            left: 0;
            top: 2px;
            bottom: 2px;
            width: 3px;
            border-radius: 20px;
            background: rgba(255,255,255,.92);
            box-shadow: 0 0 15px rgba(125,211,252,.4);
        }

        .hero-left p.switch-text {
            font-size: 1rem;
            color: rgba(255,255,255,.92);
            line-height: 1.65;
            margin-bottom: 0;
            text-shadow: 0 2px 13px rgba(0,0,0,.28);
            transition: opacity .5s ease-in-out;
        }

        .hero-left p.switch-text.fade-out {
            opacity: 0;
        }

        /* Tombol dan sosial hanya tambahan visual; tidak mengubah fitur yang sudah ada. */
        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 26px;
        }

        .hero-action {
            min-width: 185px;
            padding: 13px 28px;
            border-radius: 999px;
            font-weight: 700;
            text-decoration: none;
            text-align: center;
            transition: .25s ease;
        }

        .hero-action.primary {
            color: #164e63;
            background: #fff;
            border: 1px solid #fff;
        }

        .hero-action.secondary {
            color: #fff;
            background: rgba(255,255,255,.08);
            border: 2px solid rgba(255,255,255,.85);
            backdrop-filter: blur(8px);
        }

        .hero-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0,0,0,.18);
        }

        /* ================= DATA CARD ================= */

        .hero-card {
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(255,255,255,.72);
            border-radius: 24px;
            padding: 2rem 2.1rem;
            width: 100%;
            max-width: 440px;
            margin-left: auto;
            box-shadow: 0 24px 60px rgba(2,31,48,.30);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: fadeInUp 1.1s ease-out forwards, floating 5s ease-in-out infinite;
            animation-delay: 0s, 1.1s;
            position: relative;
            overflow: hidden;
            color: #0f172a;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #0f172a, #164e63, #38bdf8);
        }

        .card-kicker {
            margin: 0 0 .55rem;
            color: #0e7490;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: 1.6px;
        }

        .card-heading {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.55rem;
            line-height: 1.2;
            font-weight: 800;
            color: #0f172a;
        }

        .card-description {
            margin: .75rem 0 1.45rem;
            color: #64748b;
            font-size: .88rem;
            line-height: 1.6;
        }

        .mini-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .65rem;
        }

        .mini-stat {
            padding: .85rem .45rem;
            text-align: center;
            background: #f7fbfd;
            border: 1px solid #dceef5;
            border-radius: 14px;
        }

        .mini-stat-num {
            display: block;
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .mini-stat-label {
            display: block;
            margin-top: .35rem;
            color: #64748b;
            font-size: .65rem;
            line-height: 1.25;
        }

        .card-line {
            height: 1px;
            background: #e2e8f0;
            margin: 1.4rem 0 1rem;
        }

        .card-footer-text {
            display: flex;
            align-items: center;
            gap: .45rem;
            color: #64748b;
            font-size: .73rem;
            font-weight: 600;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 4px rgba(34,197,94,.10);
        }

        /* ================= LOGIN / REGISTER ================= */

        .login-modal-overlay {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            padding: 24px;
            background: rgba(7, 22, 32, .60);
            backdrop-filter: blur(9px);
            -webkit-backdrop-filter: blur(9px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            right: 0;
            transition: opacity .28s ease, visibility .28s ease;
        }

        .login-modal-overlay.active {
            right: 0;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .login-modal-overlay .w-100 {
            position: relative;
            width: min(100%, 430px) !important;
            max-width: 410px;
            max-height: calc(100vh - 24px);
            margin: 0;
            padding: 22px 30px 20px;
            overflow: hidden;
            background: rgba(255,255,255,.98);
            border: 1px solid rgba(255,255,255,.8);
            border-radius: 22px;
            box-shadow: 0 28px 80px rgba(0,0,0,.26);
        }

        .login-modal-overlay .w-100::before {
            content: "SAMUDRA ACEH";
            display: block;
            margin-bottom: 1rem;
            color: #0e7490;
            font-size: .66rem;
            font-weight: 800;
            letter-spacing: 1.6px;
        }

        .login-modal-overlay h2 {
            color: #0f172a;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.55rem;
            line-height: 1.2;
            margin-bottom: .4rem !important;
        }

        .login-modal-overlay h5 {
            color: #64748b;
            font-size: .88rem;
            font-weight: 500;
            margin-bottom: 1.4rem !important;
        }

        .login-modal-overlay .form-label {
            color: #334155;
            font-size: .76rem;
            font-weight: 700;
            margin-bottom: .4rem;
        }

        .login-modal-overlay .form-control {
            min-height: 45px;
            border: 1px solid #dbe4ea;
            border-radius: 11px;
            background: #fbfdfe;
            color: #0f172a;
            padding: .65rem .82rem;
            font-size: .84rem;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .login-modal-overlay .form-control::placeholder {
            color: #94a3b8;
        }

        .login-modal-overlay .form-control:focus {
            background: #fff;
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56,189,248,.11);
        }

        .login-modal-overlay .btn[type="submit"] {
            width: 100%;
            min-height: 44px;
            margin-top: .35rem;
            border: 0 !important;
            border-radius: 11px !important;
            background: #0f172a !important;
            color: #fff !important;
            font-size: .84rem !important;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .login-modal-overlay .btn[type="submit"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(15,23,42,.18);
        }

        .login-modal-overlay a,
        .login-modal-overlay button {
            cursor: pointer;
        }

        .login-modal-overlay #openRegister,
        .login-modal-overlay #switchToLogin {
            color: #0e7490 !important;
            text-decoration: none !important;
        }

        .login-modal-overlay #closeLogin,
        .login-modal-overlay #closeRegister {
            color: #94a3b8 !important;
            text-decoration: none !important;
            font-size: .78rem !important;
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            cursor: pointer;
            z-index: 10;
            opacity: .55;
        }

        .toggle-password:hover {
            opacity: .9;
        }

        .toast-notif {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: .9rem;
            font-weight: 500;
            box-shadow: 0 8px 20px rgba(0,0,0,.12);
            animation: slideInRight .4s ease;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }


        .login-modal-overlay form .mb-3 {
            margin-bottom: .48rem !important;
        }

        .login-modal-overlay form .form-label {
            font-size: .82rem;
            margin-bottom: .18rem;
        }

        .login-modal-overlay form .form-control {
            height: 37px;
            min-height: 37px;
            padding: .35rem .72rem;
            font-size: .84rem;
        }

        .login-modal-overlay form .text-center.mt-2 {
            margin-top: .45rem !important;
        }

        .login-modal-overlay form .text-center:not(.mt-2) {
            margin-top: .35rem !important;
        }

        #registerModal .login-modal-overlay .w-100 {
            max-width: 400px;
        }

        #registerModal .w-100 h2 {
            margin-bottom: .7rem !important;
        }

        #registerModal .toggle-password {
            width: 18px;
            height: 18px;
        }

        #registerModal .invalid-feedback,
        #registerModal .text-danger {
            font-size: .72rem !important;
            margin-top: 1px !important;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 991.98px) {
            .navbar {
                top: 16px;
                width: 94%;
            }

            .hero {
                padding-top: 130px;
                padding-bottom: 70px;
            }

            .hero-card {
                margin: 3rem auto 0;
            }

            .hero-left h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 575.98px) {
            .navbar {
                padding: 11px 15px;
                border-radius: 17px;
            }

            .brand-text {
                font-size: 20px;
            }

            .nav-right {
                gap: 7px;
            }

            #loginBtn {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .hero {
                background-position: 62% center;
            }

            .hero-left h1 {
                font-size: 2.35rem;
                letter-spacing: -1px;
            }

            .hero-action {
                width: 100%;
            }

            .hero-card {
                padding: 1.5rem;
                border-radius: 20px;
            }

            .login-modal-overlay {
                padding: 14px;
            }

            .login-modal-overlay .w-100 {
                width: 100% !important;
                padding: 20px 18px 16px;
                border-radius: 19px;
                max-height: calc(100vh - 16px);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    {{-- welcome.css harus di bawah <style> di atas supaya bisa menimpanya --}}
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>


@if ($errors->any())
    <div class="toast-notif alert alert-danger" id="toastError">
        <strong>Gagal!</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="toast-notif alert alert-success" id="toastSuccess">
        ✅ {{ session('success') }}
    </div>
@endif


<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="brand-wrapper">
            <img src="{{ asset('images/pancacita.png') }}" alt="Logo Samudra Aceh" class="brand-logo-img">
            <span class="brand-text">SAMUDRA ACEH</span>
        </a>
        
        <div class="nav-right">
            {{-- Tombol Login di Kiri, Gambar Profil di Kanan --}}
            <button id="loginBtn" class="btn btn-light rounded-pill px-4" style="font-weight: 600;">Login</button>
            <img src="{{ asset('images/pfp.jpg') }}" alt="Profile" class="nav-profile-img" id="profileImg">
        </div>
    </div>
</nav>

{{-- ── MODAL LOGIN ─────────────────────────────────────────────── --}}
<div id="loginModal" class="login-modal-overlay">
    <div class="w-100">
        <h2 class="mb-4"><b>Selamat Datang!</b></h2>
        <h5 class="mb-4">Silahkan Login</h5>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="example@gmail.com" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="passwordLogin"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" required>
                    <img src="{{ asset('images/view.png') }}" class="toggle-password"
                        onclick="togglePassword('passwordLogin', this)">
                </div>
                @error('password')
                    <div class="text-danger mt-1" style="font-size:0.85rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end mt-2" style="font-weight: 600;">
                <a href="{{ route('password.request') }}" style="color:#0f172a;font-size:0.85rem;text-decoration:underline;">
                    Lupa Password?
                </a>
            </div>

            <div class="text-center mt-4 px-4">
                <button type="submit" class="btn mb-3 px-4"
                    style="background-color: #0f1b35ff; color: white; border-radius: 20px; font-size: 0.9rem;">
                    Masuk
                </button>
            </div>

            <div class="text-center mt-2 px-4">
                <span style="color: #64748b; font-size: 0.9rem;">Belum mempunyai akun? </span>
                <button type="button" id="openRegister"
                    style="color: #0f172a; text-decoration: underline; font-weight: 600; border: none; background: none; font-size: 0.9rem;">
                    Register
                </button>
                <br>
                <button type="button" id="closeLogin"
                    style="color: #64748b; border: none; background: transparent; margin-top: 8px;">
                    Tutup
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL REGISTER ──────────────────────────────────────────── --}}
<div id="registerModal" class="login-modal-overlay">
    <div class="w-100">
        <h2 class="mb-4"><b>Buat Akun</b></h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" name="nip"
                    class="form-control @error('nip') is-invalid @enderror"
                    placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}" required>
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="example@gmail.com" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="passwordRegister"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Minimal 8 karakter" required>
                    <img src="{{ asset('images/view.png') }}" class="toggle-password"
                        onclick="togglePassword('passwordRegister', this)">
                </div>
                @error('password')
                    <div class="text-danger mt-1" style="font-size:0.85rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="passwordConfirm"
                        class="form-control" placeholder="Ulangi Password" required>
                    <img src="{{ asset('images/view.png') }}" class="toggle-password"
                        onclick="togglePassword('passwordConfirm', this)">
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn mb-3 px-4"
                    style="background-color: #0f1b35ff; color: white; border-radius: 20px; font-size: 0.9rem;">
                    Daftar
                </button>
            </div>

            <div class="text-center mt-2">
                <button type="button" id="closeRegister"
                    style="color: #64748b; border: none; background: none; font-size: 0.9rem;">
                    Tutup
                </button>
                <span style="color: #64748b; font-size: 0.9rem;"> | </span>
                <button type="button" id="switchToLogin"
                    style="background: none; border: none; color: #0f172a; font-weight: 600; text-decoration: underline; font-size: 0.9rem;">
                    Sudah punya akun? Login
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── HERO SECTION ────────────────────────────────────────────── --}}
<section class="hero">
<div class="container">
        <div class="row align-items-center">

            <div class="col-lg-7 hero-left">
                <p class="label">DATA KELAUTAN & PERIKANAN ACEH</p>

                <h1>
                    Samudra Aceh
                </h1>

                <div class="text-switcher-container">
                    <p class="switch-text" id="changing-text">
                        Kelola dan pantau data produksi garam, perikanan, dan budidaya laut seluruh kabupaten di Provinsi Aceh dalam satu sistem terintegrasi.
                    </p>
                </div>

                {{-- Tombol tambahan visual; tidak mengubah fitur Login/Register --}}
                <div class="hero-actions">
                    <button type="button" class="hero-action primary" id="heroLoginBtn">
                        Login
                    </button>

                    <button type="button" class="hero-action secondary" id="heroRegisterBtn">
                        Register
                    </button>
                </div>
            </div>

            <div class="col-lg-5" id="statistik">
                <div class="hero-card">
                    <p class="card-kicker">SAMUDRA ACEH</p>
                    <h3 class="card-heading">Data Kelautan &amp; Perikanan</h3>
                    <p class="card-description">
                        Satu ruang untuk mengelola, memantau, dan melihat informasi kelautan dan perikanan Aceh.
                    </p>

                    <div class="mini-stats">
                        <div class="mini-stat">
                            <span class="mini-stat-num">23</span>
                            <span class="mini-stat-label">Kabupaten/Kota</span>
                        </div>
                        <div class="mini-stat">
                            <span class="mini-stat-num">4</span>
                            <span class="mini-stat-label">Bidang Data</span>
                        </div>
                        <div class="mini-stat">
                            <span class="mini-stat-num">12</span>
                            <span class="mini-stat-label">Periode</span>
                        </div>
                    </div>

                    <div class="card-line"></div>

                    <div class="card-footer-text">
                        <span>Terintegrasi</span>
                        <span class="status-dot"></span>
                        <span>Data Aceh</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ── MODAL LOGIC ──────────────────────────────────────────────
    const loginBtn      = document.getElementById('loginBtn');
    const profileImg    = document.getElementById('profileImg');
    const openRegister  = document.getElementById('openRegister');
    const loginModal    = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    const closeLogin    = document.getElementById('closeLogin');
    const closeRegister = document.getElementById('closeRegister');
    const switchToLogin = document.getElementById('switchToLogin');

    if (loginBtn) loginBtn.addEventListener('click', () => loginModal.classList.add('active'));
    const heroLoginBtn = document.getElementById('heroLoginBtn');
    if (heroLoginBtn) heroLoginBtn.addEventListener('click', () => loginModal.classList.add('active'));

    // Tombol Register di bawah judul besar
    const heroRegisterBtn = document.getElementById('heroRegisterBtn');
    if (heroRegisterBtn) heroRegisterBtn.addEventListener('click', () => {
        loginModal.classList.remove('active');
        registerModal.classList.add('active');
    });

    if (profileImg) profileImg.addEventListener('click', () => loginModal.classList.add('active'));
    openRegister.addEventListener('click',  () => { loginModal.classList.remove('active'); registerModal.classList.add('active'); });
    closeLogin.addEventListener('click',    () => loginModal.classList.remove('active'));
    closeRegister.addEventListener('click', () => registerModal.classList.remove('active'));
    switchToLogin.addEventListener('click', () => { registerModal.classList.remove('active'); loginModal.classList.add('active'); });

    // ── AUTO-BUKA MODAL SETELAH REDIRECT ─────────────────────────
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            @if ($errors->has('email') && !$errors->has('name') && !$errors->has('nip'))
                loginModal.classList.add('active');
            @elseif ($errors->has('password') && !$errors->has('name') && !$errors->has('nip'))
                loginModal.classList.add('active');
            @else
                registerModal.classList.add('active');
            @endif
        });
    @endif

    @if (session('success'))
        document.addEventListener('DOMContentLoaded', () => {
            loginModal.classList.add('active');
        });
    @endif

    // ── AUTO-HIDE TOAST SETELAH 5 DETIK ──────────────────────────
    setTimeout(() => {
        const toastError   = document.getElementById('toastError');
        const toastSuccess = document.getElementById('toastSuccess');
        if (toastError)   toastError.style.display   = 'none';
        if (toastSuccess) toastSuccess.style.display = 'none';
    }, 5000);

    // ── TOGGLE SHOW/HIDE PASSWORD ─────────────────────────────────
    function togglePassword(inputId, imgElement) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            imgElement.src = "{{ asset('images/hide.png') }}";
        } else {
            input.type = 'password';
            imgElement.src = "{{ asset('images/view.png') }}";
        }
    }

    // ── TEXT SWITCHER HERO ────────────────────────────────────────
    const textElement = document.getElementById('changing-text');
    const textList = [
        "Kelola dan pantau data produksi garam, perikanan, dan budidaya laut seluruh kabupaten di Provinsi Aceh dalam satu sistem terintegrasi.",
        "Data statistik kelautan Aceh kini lebih mudah diakses, dikelola, dan dilaporkan secara real-time.",
        "Dukung pengambilan keputusan berbasis data untuk sektor perikanan dan kelautan Provinsi Aceh.",
    ];
    let currentIndex = 0;

    setInterval(() => {
        textElement.classList.add('fade-out');
        setTimeout(() => {
            currentIndex = (currentIndex + 1) % textList.length;
            textElement.innerText = textList[currentIndex];
            textElement.classList.remove('fade-out');
        }, 500);
    }, 7000);
</script>

</body>
</html>