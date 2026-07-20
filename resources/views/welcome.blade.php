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

    <style>
        :root {
            --clr-bg: #fffcf3ff;
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

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: var(--clr-bg);
            color: var(--clr-dark);
            overflow-x: hidden;
        }

        /* ── NAVBAR ─────────────────────────────────── */
        .navbar {
            background: var(--clr-dark);
            padding: 14px 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-text {
            font-size: 26px;
            color: #ffffff;
            line-height: 1;
            padding-top: 2px;
            font-weight: 700;
        }

        .brand-logo-svg {
            width: 32px;
            height: 32px;
            fill: var(--clr-blue-brand);
            transition: transform 0.3s ease;
        }

        .brand-wrapper:hover .brand-logo-svg {
            transform: rotate(10deg) scale(1.05);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 16px; 
        }

        /* ── PROFILE ICON NAVBAR ─────────────────────── */
        .nav-profile-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--clr-blue-brand);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .nav-profile-img:hover {
            transform: scale(1.08);
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.5);
        }

        /* ── HERO ───────────────────────────────────── */
        .hero {
            background: var(--clr-bg);
            min-height: calc(100vh - 68px);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 1.5rem 0 4rem 0;
        }

        .hero-left {
            animation: fadeInUp 1s ease-out forwards;
        }

        .hero-left .label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            color: var(--clr-text-muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: .75rem;
        }

        .hero-left h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 3.2rem;
            font-weight: 800;
            color: var(--clr-dark);
            line-height: 1.15;
            margin-bottom: 1.25rem;
            letter-spacing: -.5px;
        }

        .text-switcher-container {
            min-height: 80px;
            margin-bottom: 2.5rem;
            max-width: 480px;
        }

        .hero-left p.switch-text {
            font-size: 1.05rem;
            color: var(--clr-text-muted);
            line-height: 1.7;
            margin-bottom: 0;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        .hero-left p.switch-text.fade-out {
            opacity: 0;
        }

        /* ── HERO RIGHT (Card) ── */
        .hero-card {
            background: #ffffffff;
            border: 1px solid var(--clr-border);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            margin-left: auto;
            animation: fadeInUp 1.2s ease-out forwards, floating 4s ease-in-out infinite;
            animation-delay: 0s, 1.2s;
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #38bdf8, #0284c7);
        }

        .hero-card .card-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .8rem;
            font-weight: 700;
            color: var(--clr-text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: linear-gradient(135deg, var(--clr-bg), #f0f9ff);
            border: 1px solid var(--clr-border);
            border-radius: 14px;
            padding: 1.2rem .5rem;
            flex: 1;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(56, 189, 248, 0.15);
            border-color: #38bdf8;
        }

        .stat-box .stat-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--clr-dark);
            display: block;
        }

        .stat-box .stat-label {
            font-size: .75rem;
            color: var(--clr-text-muted);
            margin-top: .25rem;
            display: block;
            font-weight: 500;
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: .5rem;
            height: 100px;
            margin-top: .5rem;
            padding-bottom: 4px;
        }

        .bar {
            flex: 1;
            border-radius: 6px 6px 0 0;
            background: linear-gradient(to top, #bae6fd, #7dd3fc);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .bar:hover {
            background: linear-gradient(to top, #38bdf8, #0ea5e9);
            filter: brightness(1.1);
        }
        
        .bar.active { 
            background: linear-gradient(to top, #0284c7, #38bdf8);
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
        }

        .bar-labels {
            display: flex;
            gap: .5rem;
            margin-top: .6rem;
        }
        
        .bar-labels span {
            flex: 1;
            text-align: center;
            font-size: .65rem;
            color: var(--clr-text-muted);
            font-weight: 600;
        }

        /* ── KEYFRAMES ──────────────────────────────── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes floating {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        /* ── RESPONSIVE ─────────────────────────────── */
        @media (max-width: 991.98px) {
            .hero-card { margin: 3rem auto 0 auto; }
            .hero-left h1 { font-size: 2.5rem; }
            .text-switcher-container { min-height: auto; }
        }

        /* ── OCEAN WAVE ─────────────────────────────── */
        .hero {
            position: relative;
            overflow: hidden;
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .ocean {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 32%;
            overflow: hidden;
            z-index: 1;
        }

        .wave {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 200%;
            height: 100%;
        }

        .wave-back {
            fill: #7dd3fc;
            opacity: .6;
            animation: waveMoveBack 18s linear infinite;
        }

        .wave-front {
            fill: #38bdf8;
            animation: waveMoveFront 10s linear infinite;
        }

        @keyframes waveMoveFront {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        @keyframes waveMoveBack {
            from { transform: translateX(-50%); }
            to   { transform: translateX(0); }
        }

        /* ── MODAL SLIDE ─────────────────────────────── */
        .login-modal-overlay {
            position: fixed;
            top: 0; 
            right: -50%; 
            width: 50%; 
            height: 100%;
            background: #fffcf3ff;
            z-index: 1000;
            box-shadow: -5px 0 20px rgba(0,0,0,0.1);
            transition: right 0.5s ease-in-out;
            padding: 40px;
            overflow-y: auto; 
            display: block;
        }

        .login-modal-overlay .w-100 {
            max-width: 400px;
            margin: 0 auto;
            padding-bottom: 50px;
        }

        .login-modal-overlay.active { right: 0; }

        /* ── PASSWORD WRAPPER ───────────────────────── */
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
            width: 20px;
            height: 20px;
            cursor: pointer;
            z-index: 10;
            opacity: 0.7;
        }

        .toggle-password:hover { opacity: 1; }

        /* ── TOAST NOTIFIKASI ───────────────────────── */
        .toast-notif {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            animation: slideInRight 0.4s ease;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .brand-logo-img {
            height: 30px;      
            width: auto;       
            object-fit: contain;
        }
    </style>
</head>
<body>

{{-- ── NOTIFIKASI ERROR / SUCCESS ─────────────────────────────── --}}
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

{{-- ── NAVBAR ──────────────────────────────────────────────────── --}}
<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="brand-wrapper">
            <img src="{{ asset('images/pancacita.png') }}" alt="Logo Pancacita" class="brand-logo-img">
            <span class="brand-text">SIDKP</span>
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

    <div class="ocean">
        <svg class="wave wave-back" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,60 C150,20 300,100 450,60 C600,20 750,100 900,60 C1050,20 1200,100 1350,60 L1350,120 L0,120 Z"/>
        </svg>
        <svg class="wave wave-front" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,70 C150,30 300,110 450,70 C600,30 750,110 900,70 C1050,30 1200,110 1350,70 L1350,120 L0,120 Z"/>
        </svg>
    </div>

    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 hero-left">
                <p class="label">SIDKP Data Platform</p>
                <h1>Sistem Informasi Dinas Kelautan dan Perikanan Aceh</h1>
                
                <div class="text-switcher-container">
                    <p class="switch-text" id="changing-text">
                        Kelola dan pantau data produksi garam, perikanan, dan budidaya laut seluruh kabupaten di Provinsi Aceh dalam satu sistem terintegrasi.
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-card">
                    <p class="card-title">Statistik Hasil Laut</p>

                    <div class="stat-row">
                        <div class="stat-box">
                            <span class="stat-num">24</span>
                            <span class="stat-label">Kabupaten</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-num">12</span>
                            <span class="stat-label">Bulan</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-num">∞</span>
                            <span class="stat-label">Data</span>
                        </div>
                    </div>

                    <p class="card-title">Total Produksi per Bulan</p>
                    <div class="bar-chart">
                        <div class="bar" style="height:40%"></div>
                        <div class="bar" style="height:60%"></div>
                        <div class="bar" style="height:45%"></div>
                        <div class="bar" style="height:80%"></div>
                        <div class="bar" style="height:65%"></div>
                        <div class="bar active" style="height:100%"></div>
                        <div class="bar" style="height:70%"></div>
                        <div class="bar" style="height:55%"></div>
                        <div class="bar" style="height:85%"></div>
                        <div class="bar" style="height:50%"></div>
                        <div class="bar" style="height:75%"></div>
                        <div class="bar" style="height:90%"></div>
                    </div>
                    <div class="bar-labels">
                        <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span>
                        <span>Mei</span><span>Jun</span><span>Jul</span><span>Agt</span>
                        <span>Sep</span><span>Okt</span><span>Nov</span><span>Des</span>
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