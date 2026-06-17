<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataStatistik Aceh</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #f0f9ff;
        }

        /* ── NAVBAR ─────────────────────────────────── */
        .navbar {
            background: #fff;
            padding: 1rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 8px rgba(0,0,0,.07);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar .logo {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: 1.3rem;
            font-weight: 800;
            color: #0d7e8a;
            text-decoration: none;
        }

        .navbar .logo span {
            color: #06b6d4;
        }

        .navbar .logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0d7e8a, #06b6d4);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
        }

        .btn-started {
            background: linear-gradient(135deg, #0d7e8a, #06b6d4);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .6rem 1.5rem;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .2s;
        }
        .btn-started:hover { opacity: .85; color: #fff; }

        /* ── HERO ───────────────────────────────────── */
        .hero {
            background: linear-gradient(135deg, #0d7e8a 0%, #06b6d4 50%, #67e8f9 100%);
            min-height: calc(100vh - 68px);
            display: flex;
            align-items: center;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 60px,
                rgba(255,255,255,.03) 60px,
                rgba(255,255,255,.03) 61px
            );
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 3rem;
            position: relative;
            z-index: 1;
        }

        .hero-left .label {
            font-size: .85rem;
            font-weight: 600;
            color: rgba(255,255,255,.8);
            letter-spacing: .5px;
            margin-bottom: .75rem;
        }

        .hero-left h1 {
            font-size: 3rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1.25rem;
            letter-spacing: -.5px;
        }

        .hero-left p {
            font-size: 1rem;
            color: rgba(255,255,255,.8);
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 420px;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary-hero {
            background: #fff;
            color: #0d7e8a;
            border: none;
            border-radius: 10px;
            padding: .85rem 2rem;
            font-size: .95rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 15px rgba(0,0,0,.15);
        }
        .btn-primary-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,.2);
            color: #0d7e8a;
        }

        .btn-secondary-hero {
            background: rgba(255,255,255,.15);
            color: #fff;
            border: 2px solid rgba(255,255,255,.5);
            border-radius: 10px;
            padding: .85rem 2rem;
            font-size: .95rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s;
        }
        .btn-secondary-hero:hover {
            background: rgba(255,255,255,.25);
            color: #fff;
        }

        /* ── HERO RIGHT (ilustrasi) ──────────────────── */
        .hero-right {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-card {
            background: rgba(255,255,255,.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,.15);
        }

        .hero-card .card-title {
            font-size: .8rem;
            font-weight: 600;
            color: rgba(255,255,255,.7);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 1.5rem;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-box {
            background: rgba(255,255,255,.2);
            border-radius: 12px;
            padding: 1rem;
            flex: 1;
            text-align: center;
        }

        .stat-box .stat-num {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            display: block;
        }

        .stat-box .stat-label {
            font-size: .75rem;
            color: rgba(255,255,255,.75);
            margin-top: .25rem;
            display: block;
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: .5rem;
            height: 80px;
            margin-top: .5rem;
        }

        .bar {
            flex: 1;
            border-radius: 4px 4px 0 0;
            background: rgba(255,255,255,.4);
            transition: background .2s;
        }
        .bar.active { background: #fff; }

        .bar-labels {
            display: flex;
            gap: .5rem;
            margin-top: .4rem;
        }
        .bar-labels span {
            flex: 1;
            text-align: center;
            font-size: .65rem;
            color: rgba(255,255,255,.7);
        }

        /* ── RESPONSIVE ─────────────────────────────── */
        @media (max-width: 768px) {
            .hero-container { grid-template-columns: 1fr; }
            .hero-left h1 { font-size: 2rem; }
            .hero-right { display: none; }
            .navbar { padding: 1rem 1.25rem; }
            .hero { padding: 2rem 1.25rem; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="#" class="logo">
        
        Data<span>Statistik</span>
    </a>
    <a href="{{ route('kabupaten.index') }}" class="btn-started">Masuk</a>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-container">

        <div class="hero-left">
            <p class="label">DataStatistik Aceh Platform</p>
            <h1>Sistem Informasi Statistik Kelautan Aceh</h1>
            <p>Kelola dan pantau data produksi garam, perikanan, dan budidaya laut seluruh kabupaten di Provinsi Aceh dalam satu sistem terintegrasi.</p>
            <div class="hero-buttons">
                <a href="{{ route('statistik.index') }}" class="btn-primary-hero">Lihat Data</a>
                <a href="{{ route('garam.rekapBulanan') }}" class="btn-secondary-hero">Rekap Bulanan</a>
            </div>
        </div>

        <div class="hero-right">
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
</section>

</body>
</html>