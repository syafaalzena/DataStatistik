<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <style>
    /* Styling tombol wilayah agar terlihat modern & semi-transparan greyish */
    .custom-pill-btn {
        background-color: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        transition: all 0.2s ease;
    }
    
    .custom-pill-btn:hover {
        background-color: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    /* Animasi hover halus untuk card rekap bawah */
    .transition-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important;
    }

    .kab-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .kab-card:hover {
        background-color: #0f172a;
        color: white;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }
    .kab-card:hover h5 {
        color: white !important;
    }
</style>
</head>
<body>

<div class="container py-4">

    <div class="row mb-4">
        <div class="col-12 text-center text-md-start">
            <h2 class="fw-bold text-dark mb-1">Data Statistik Garam Provinsi Aceh</h2>
            <p class="text-muted">Silakan pilih wilayah kabupaten untuk mengelola data atau lihat total rekapitulasi provinsi di bawah.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-4">
            
            <div class="container py-5">
    <h2 class="fw-bold mb-4">Pilih Kabupaten</h2>

    <div class="row g-3">
        @foreach($data as $kab)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('kabupaten.show', $kab->id) }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm text-center p-3 kab-card">
                    <div class="card-body">
                        <h5 class="fw-semibold text-dark">{{ $kab->nama_kabupaten }}</h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(145deg, #1e293b, #0f172a); border-radius: 16px;">
        <div class="card-body p-4 text-white">
            <div class="row align-items-center">
                <div class="col-md-8 mb-3 mb-md-0">
                    <h4 class="fw-bold mb-2">Akumulasi Data Tingkat Provinsi</h4>
                    <p class="text-white-50 m-0">
                        Kotak ini menampilkan ringkasan/total keseluruhan data dari 8 kabupaten di atas. Semua rekapitulasi data bulanan maupun tahunan digabungkan dan disebutkan secara global di sini.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="bg-white bg-opacity-10 p-3 rounded-3 d-inline-block text-center">
                        <span class="small text-white-50 d-block">Total Wilayah</span>
                        <span class="fs-3 fw-bold">8 Kabupaten</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm transition-card" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">📅 Rekap Bulanan Provinsi</h5>
                        <p class="text-muted small m-0">Lihat total grafik & tren bulanan se-Aceh</p>
                    </div>
                    <a href="{{ route('garam.rekapBulanan') }}" class="btn btn-dark px-4 py-2 fw-semibold" style="background: #0f172a; border-radius: 8px;">
                        Buka Rekap →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm transition-card" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">📊 Rekap Tahunan Provinsi</h5>
                        <p class="text-muted small m-0">Lihat perbandingan total tahunan semua wilayah</p>
                    </div>
                    <a href="{{ route('garam.rekapTahunan') }}" class="btn btn-primary px-4 py-2 fw-semibold" style="border-radius: 8px;">
                        Buka Rekap →
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>