<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistik Garam Aceh</title>


</head>
<body>

    <div class="navbar">
        <h2>Sistem Data Statistik Garam Aceh</h2>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Selamat Datang...!</h1>
            <p>Silakan pilih menu yang ingin Anda kelola.</p>
        </div>

        <div class="card-container">

            <div class="card">
                <h2> Data Garam</h2>
                <p>Kelola data produksi garam dan statistik garam Aceh.</p>

                <a href="{{ route('statistik.index') }}" class="btn">
                    Masuk
                </a>
            </div>

            <div class="card">
                <h2> Data Budidaya</h2>
                <p>Kelola data budidaya dan informasi pendukung.</p>

                <a href="{{ route('dashboard') }}" class="btn">
                    Masuk
                </a>
            </div>

        </div>

    </div>

</body>
</html>