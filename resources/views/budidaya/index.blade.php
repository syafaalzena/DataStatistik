<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Statistik Budidaya Provinsi Aceh</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --clr-bg:#F7F5F0;
            --clr-dark:#0f172a;
            --clr-blue:#38bdf8;
        }

        body{
            background:var(--clr-bg);
            font-family:'Inter',sans-serif;
        }

        .navbar{
            background:var(--clr-dark);
            padding:14px 0;
            margin-bottom:35px;
        }

        .brand-wrapper{
            display:flex;
            align-items:center;
            gap:12px;
            text-decoration:none;
        }

        .brand-text{
            color:#fff;
            font-size:26px;
            font-weight:bold;
        }

        .brand-logo{
            width:30px;
            fill:var(--clr-blue);
        }

        .back-btn{
            width:48px;
            height:48px;
            display:flex;
            justify-content:center;
            align-items:center;
            background:white;
            border-radius:50%;
            border:1px solid #ddd;
            transition:.2s;
        }

        .back-btn:hover{
            background:#0f172a;
        }

        .back-btn:hover img{
            filter:brightness(0) invert(1);
        }

        .kab-card{
            border:none;
            border-radius:14px;
            transition:.25s;
            cursor:pointer;
        }

        .kab-card:hover{
            background:#0f172a;
            transform:translateY(-4px);
            box-shadow:0 10px 18px rgba(0,0,0,.15);
        }

        .kab-card:hover h5{
            color:white!important;
        }

        .btn-logout{
            background:none;
            border:none;
        }

        .btn-logout img{
            width:24px;
            filter:brightness(0) invert(1);
        }

    </style>

</head>

<body>

<nav class="navbar">

<div class="container d-flex justify-content-between align-items-center">

<a href="#" class="brand-wrapper">

<span class="brand-text">SIDKP</span>

<svg class="brand-logo" viewBox="0 0 24 24">
<path d="M2,12C2,12 5,7 12,7C15.5,7 18.5,8.5 20.5,10.5L22,9V15L20.5,13.5C18.5,15.5 15.5,17 12,17C5,17 2,12 2,12M12,9A3,3 0 1,0 12,15A3,3 0 1,0 12,9Z"/>
</svg>

</a>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="btn-logout">
<img src="{{ asset('images/logout.png') }}">
</button>
</form>

</div>

</nav>

<div class="container">

<div class="d-flex align-items-center gap-3 mb-4">

<a href="{{ route('statistik.index') }}" class="back-btn">
<img src="{{ asset('images/back.png') }}" width="22">
</a>

<div>

<h2 class="fw-bold mb-1">
Data Statistik Budidaya Provinsi Aceh
</h2>

<p class="text-muted mb-0">
Silakan pilih kabupaten untuk mengelola data budidaya.
</p>

</div>

</div>

<div class="row g-3">

@forelse($kabupatenIkans as $kab)

<div class="col-6 col-md-4 col-lg-3">

<a href="{{ route('budidaya.input',$kab->id) }}"
class="text-decoration-none">

<div class="card shadow-sm text-center p-3 kab-card">

<div class="card-body">

<h5 class="fw-semibold text-dark">

{{ $kab->nama_kabupaten }}

</h5>

</div>

</div>

</a>

</div>

@empty

<div class="col-12">

<div class="alert alert-warning text-center">

Belum ada data kabupaten.

</div>

</div>

@endforelse

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>