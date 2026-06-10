<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <h5 class="fw-bold text-dark mb-3">🔍 Pilih Wilayah Kabupaten:</h5>
            
            <div class="d-flex flex-wrap gap-2">
                @php
                    $kabupaten_list = [
                        ['id' => 1, 'nama' => 'Aceh Besar'],
                        ['id' => 2, 'nama' => 'Pidie'],
                        ['id' => 3, 'nama' => 'Aceh Utara'],
                        ['id' => 4, 'nama' => 'Pidie Jaya'],
                        ['id' => 5, 'nama' => 'Bireuen'],
                        ['id' => 6, 'nama' => 'Aceh Timur'],
                        ['id' => 7, 'nama' => 'Aceh Tamiang'],
                        ['id' => 8, 'nama' => 'Banda Aceh']
                    ];
                @endphp

                @foreach($kabupaten_list as $kab)
                    <a href="{{ route('kabupaten.show', $kab['id']) }}" class="btn custom-pill-btn py-2 px-4 fw-medium">
                        📍 {{ $kab['nama'] }}
                    </a>
                @endforeach
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
</style>
@endsection
</body>
</html>