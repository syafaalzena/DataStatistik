<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Komoditas - {{ $kabupaten->nama_kabupaten }}</title>

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

        body { background: var(--clr-bg); font-family: 'Inter', sans-serif; color: var(--clr-dark); }

        .navbar {
            background: var(--clr-dark);
            color: white;
            padding: 14px 0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            margin-bottom: 1.5rem;
        }
        .brand-wrapper { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-text { font-weight: bold; font-size: 26px; color: #ffffff; }
        .brand-logo-svg { width: 32px; height: 32px; fill: var(--clr-blue-brand); }

        .back-btn {
            width: 48px; height: 48px;
            display: flex; align-items: center; justify-content: center;
            background: #ffffff; border: 1px solid #e2e8f0; border-radius: 30px;
            text-decoration: none; transition: all .2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
        }
        .back-btn:hover { transform: translateY(-2px); background: #0f172a; border-color: #0f172a; }
        .back-btn:hover img { filter: brightness(0) invert(1); }

        .btn-logout-icon {
            background: transparent;
            border: 1.5px solid rgba(248, 250, 252, 0.25);
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.25s ease;
        }
        .btn-logout-icon img { width: 20px; height: 20px; filter: brightness(0) invert(1); transition: transform 0.25s ease; }
        .btn-logout-icon:hover { background: var(--clr-blue-brand); border-color: var(--clr-blue-brand); }
        .btn-logout-icon:hover img { transform: translateX(2px); filter: none; }

        .panel-card {
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
            padding: 24px;
        }

        .form-control { border-radius: 8px; border: 1px solid #e2e8f0; }

        .btn-dark-custom {
            background: var(--clr-dark);
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            padding: 10px 22px;
        }
        .btn-dark-custom:hover { background: #1e293b; color: #fff; }

        .komoditas-list {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #eef0e8;
        }
        .komoditas-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid #eef0e8;
            background: #ffffff;
        }
        .komoditas-item:last-child { border-bottom: none; }
        .komoditas-item:hover { background: #f8fafc; }

        .btn-delete-icon {
            background: none;
            border: none;
            color: #dc2626;
            font-size: 13px;
            font-weight: 600;
        }
        .btn-delete-icon:hover { text-decoration: underline; }

        .empty-state { text-align: center; padding: 24px; color: #94a3b8; font-size: 14px; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="#" class="brand-wrapper">
            <span class="brand-text">SIDKP</span>
            <svg class="brand-logo-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M2,12C2,12 5,7 12,7C15.5,7 18.5,8.5 20.5,10.5L22,9V15L20.5,13.5C18.5,15.5 15.5,17 12,17C5,17 2,12 2,12M12,9A3,3 0 1,0 12,15A3,3 0 1,0 12,9Z"/>
            </svg>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn-logout-icon" title="Logout">
                <img src="{{ asset('images/logout.png') }}" alt="Logout" width="20" height="20">
            </button>
        </form>
    </div>
</nav>

<div class="container pb-5" style="max-width: 640px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('budidaya.input', $kabupaten->id) }}" class="back-btn">
            <img src="{{ asset('images/back.png') }}" alt="Back" width="22" height="22">
        </a>
        <div>
            <h2 class="fw-bold mb-1">Kelola Komoditas</h2>
            <p class="text-muted mb-0">Kabupaten: <strong>{{ $kabupaten->nama_kabupaten }}</strong></p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM TAMBAH KOMODITAS --}}
    <div class="panel-card mb-4">
        <h5 class="fw-bold mb-3">Tambah Komoditas Baru</h5>
        <form method="POST" action="{{ route('budidaya.komoditas.store', $kabupaten->id) }}" class="d-flex gap-2">
            @csrf
            <input type="text" name="nama_komoditas" class="form-control" placeholder="Contoh: Udang Vaname" required>
            <button type="submit" class="btn-dark-custom text-nowrap">Simpan</button>
        </form>
    </div>

    {{-- LIST KOMODITAS YANG SUDAH ADA --}}
    <div class="panel-card">
        <h5 class="fw-bold mb-3">Daftar Komoditas ({{ $komoditasList->count() }})</h5>

        @if($komoditasList->isEmpty())
            <div class="empty-state">Belum ada komoditas untuk kabupaten ini.</div>
        @else
            <div class="komoditas-list">
                @foreach($komoditasList as $kom)
                    <div class="komoditas-item">
                        <span>{{ $kom->nama_komoditas }}</span>
                        <form method="POST" action="{{ route('budidaya.komoditas.destroy', [$kabupaten->id, $kom->id]) }}"
                              onsubmit="return confirm('Hapus komoditas ini?');" class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-icon">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('budidaya.input', $kabupaten->id) }}" class="text-decoration-none fw-semibold">
            &larr; Kembali ke Halaman Input {{ $kabupaten->nama_kabupaten }}
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>