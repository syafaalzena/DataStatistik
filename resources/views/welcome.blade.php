<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mina - Sistem Informasi Statistik Kelautan Aceh</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Croissant+One&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --clr-bg: #F7F5F0;
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
            font-family: 'Croissant One', serif;
            font-size: 26px;
            color: #ffffff;
            line-height: 1;
            padding-top: 2px;
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

        .btn-started {
            background: #ffffff;
            color: var(--clr-dark);
            border: none;
            border-radius: 25px;
            padding: .6rem 1.8rem;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s ease;
        }
        
        .btn-started:hover { 
            background: var(--clr-blue-brand); 
            color: var(--clr-dark); 
            transform: translateY(-1px);
        }

        .user-profile-link {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: transform 0.2s ease;
            margin-top: 2px;
        }

        .user-profile-link:hover {
            transform: scale(1.05);
        }

        .avatar-svg {
            width: 38px;
            height: 38px;
            fill: #f2f3f4ff; 
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

        /* Style untuk container teks deskripsi ganti-ganti */
        .text-switcher-container {
            min-height: 80px; /* Mencegah layout melompat saat teks berganti */
            margin-bottom: 2.5rem;
            max-width: 480px;
        }

        .hero-left p.switch-text {
            font-size: 1.05rem;
            color: var(--clr-text-muted);
            line-height: 1.7;
            margin-bottom: 0;
            opacity: 1;
            transition: opacity 0.5s ease-in-out; /* Efek halus fade in/out */
        }

        /* Class bantuan saat transisi hilangnya teks */
        .hero-left p.switch-text.fade-out {
            opacity: 0;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary-hero {
            background: var(--clr-dark);
            color: #ffffff;
            border: none;
            border-radius: 25px;
            padding: .85rem 2.2rem;
            font-size: .95rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }
        
        .btn-primary-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.25);
            color: #ffffff;
            background: #1e293b;
        }

        /* ── HERO RIGHT (Card) ── */
        .hero-card {
            background: #ffffff;
            border: 1px solid var(--clr-border);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.04);
            margin-left: auto;
            animation: fadeInUp 1.2s ease-out forwards, floating 4s ease-in-out infinite;
            animation-delay: 0s, 1.2s;
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
            background: var(--clr-bg);
            border: 1px solid var(--clr-border);
            border-radius: 14px;
            padding: 1.2rem .5rem;
            flex: 1;
            text-align: center;
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
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: .5rem;
            height: 90px;
            margin-top: .5rem;
        }

        .bar {
            flex: 1;
            border-radius: 4px 4px 0 0;
            background: var(--clr-border);
            transition: all 0.3s ease;
        }
        
        .bar.active { 
            background: var(--clr-dark); 
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.2);
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
        }

        /* ── KEYFRAMES ANIMASI ──────────────────────── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        /* ── RESPONSIVE ─────────────────────────────── */
        @media (max-width: 991.98px) {
            .hero-card { margin: 3rem auto 0 auto; }
            .hero-left h1 { font-size: 2.5rem; }
            .text-switcher-container { min-height: auto; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="#" class="brand-wrapper">
            <span class="brand-text">Mina</span>
            <svg class="brand-logo-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2,12C2,12 5,7 12,7C15.5,7 18.5,8.5 20.5,10.5L22,9V15L20.5,13.5C18.5,15.5 15.5,17 12,17C5,17 2,12 2,12M12,9C10.34,9 9,10.34 9,12C9,13.66 10.34,15 12,15C13.66,15 15,13.66 15,12C15,10.34 13.66,9 12,9M12,10.5A1.5,1.5 0 0,1 13.5,12A1.5,1.5 0 0,1 12,13.5A1.5,1.5 0 0,1 10.5,12A1.5,1.5 0 0,1 12,10.5M19,12A1,1 0 1,1 18,11A1,1 0 0,1 19,12Z"/>
            </svg>
        </a>
        
        <div class="nav-right">
            <a href="{{ route('kabupaten.index') }}" class="btn-started">Masuk</a>

            <a href="#" class="user-profile-link" title="Profil Pengguna">
                <svg class="avatar-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,16.5C14.7,16.5 17.4,17.4 18.9,19C17.3,20.6 14.8,21.5 12,21.5C9.2,21.5 6.7,20.6 5.1,19C6.6,17.4 9.3,16.5 12,16.5Z"/>
                </svg>
            </a>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 hero-left">
                <p class="label">Mina Data Platform</p>
                <h1>Sistem Informasi Statistik Kelautan Aceh</h1>
                
                <div class="text-switcher-container">
                    <p class="switch-text" id="changing-text">Kelola dan pantau data produksi garam, perikanan, dan budidaya laut seluruh kabupaten di Provinsi Aceh dalam satu sistem terintegrasi.</p>
                </div>

                <div class="hero-buttons">
                    <a href="{{ route('statistik.index') }}" class="btn-primary-hero">Lihat Data</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-card">
                    <p class="card-title">📊 Statistik Produksi Garam</p>

                    <div class="stat-row">
                        <div class="stat-box">
                            <span class="stat-num">8</span>
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
    const textElement = document.getElementById('changing-text');
    
    // List teks yang bakal bergantian
    const textList = [
        "Kelola dan pantau data produksi garam, perikanan, dan budidaya laut seluruh kabupaten di Provinsi Aceh dalam satu sistem terintegrasi.",
        "Nama MINA adalah Filosofi Istilah klasik Indonesia/Sansekerta yang berarti Ikan atau Hasil Laut !"
    ];
    
    let currentIndex = 0;

    setInterval(() => {
        // 1. Kasih class fade-out (teks menghilang perlahan selama 0.5 detik)
        textElement.classList.add('fade-out');
        
        setTimeout(() => {
            // 2. Ganti indeks text setelah teks benar-benar tidak terlihat
            currentIndex = (currentIndex + 1) % textList.length;
            textElement.innerText = textList[currentIndex];
            
            // 3. Munculkan kembali teks barunya (hapus class fade-out)
            textElement.classList.remove('fade-out');
        }, 500); // Waktu hilangnya pas dengan durasi CSS transition (0.5s)

    }, 7000); // Jalankan loop bergantian setiap 15000ms (15 Detik)
</script>

</body>
</html>