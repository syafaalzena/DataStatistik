<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistik Garam Aceh</title>

    <style>
        *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Inter, sans-serif;
}

body{
    background:#f8fafc;
    color:#0f172a;
}

/* Navbar */
.navbar{
    background:#0f172a;
    color:white;
    padding:18px 40px;
}

.navbar h2{
    font-size:22px;
    font-weight:700;
}

/* Container */
.container{
    max-width:1200px;
    margin:auto;
    padding:50px 20px;
}

/* Welcome */
.welcome{
    margin-bottom:40px;
}

.welcome h1{
    font-size:42px;
    font-weight:800;
    margin-bottom:8px;
}

.welcome p{
    color:#64748b;
    font-size:16px;
}

/* Card Container */
.card-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
    gap:24px;
}

/* Card */
.card{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:35px;
    transition:all .3s ease;
}

.card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(15,23,42,.08);
}

.card h2{
    font-size:28px;
    margin-bottom:15px;
    font-weight:700;
}

.card p{
    color:#64748b;
    line-height:1.7;
    margin-bottom:25px;
}

/* Button */
.btn{
    display:inline-block;
    text-decoration:none;
    background:#202529;
    color:white;
    padding:12px 28px;
    border-radius:12px;
    font-weight:600;
    transition:.3s;
}

.btn:hover{
    background:#3f4346;
}

/* Responsive */
@media(max-width:768px){

    .welcome h1{
        font-size:30px;
    }

    .card-container{
        grid-template-columns:1fr;
    }
}
    </style>

</head>
<body>

    <div class="navbar">
        <h2>Sistem Data Statistik Garam Aceh</h2>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Selamat Datang </h1>
            <p>Silakan pilih menu yang ingin Anda kelola.</p>
        </div>

        <div class="card-container">

            <div class="card">
                <h2>📊 Data Garam</h2>
                <p>
                    Kelola data produksi garam dan statistik garam Aceh
                    berdasarkan kabupaten/kota.
                </p>

                <a href="{{ route('kabupaten.index') }}" class="btn">
                    Masuk
                </a>
            </div>

            <div class="card">
                <h2>🐟 Data Budidaya Ikan</h2>
                <p>
                    Kelola data budidaya garam dan informasi pendukung
                    untuk kebutuhan pelaporan.
                </p>

                <a href="{{ route('dashboard') }}" class="btn">
                    Masuk
                </a>
            </div>

        </div>

    </div>

</body>
</html>