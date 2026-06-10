<<<<<<< Updated upstream:resources/views/kabupaten/index.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
=======
@extends('layouts.app')
>>>>>>> Stashed changes:resources/views/kabupaten/dashboardKab.blade.php

@section('content')
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Kelola Data Garam</h2>
            <p class="text-muted mb-0">Kabupaten: <span class="badge bg-primary text-white fs-6">Kab. Aceh Besar</span></p>
        </div>
        <a href="{{ route('statistik.index') }}" class="btn btn-outline-secondary">
            ← Kembali ke Statistik
        </a>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-semibold">📊 1. Input Data Tahunan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="#" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-medium">Jumlah Petani Garam</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Contoh: 150">
                                <span class="input-group-text">Orang</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Luas Lahan Rebus</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" placeholder="Contoh: 12.5">
                                <span class="input-group-text">Ha</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Jumlah Lahan</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Contoh: 45">
                                <span class="input-group-text">Unit</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Harga Per Bulan (Rata-rata)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" placeholder="Contoh: 5000">
                            </div>
                        </div>

<<<<<<< Updated upstream:resources/views/kabupaten/index.blade.php
    <div class="row">

        @foreach($data as $kabupaten)

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">

                    <h5>
                        {{ $kabupaten->nama_kabupaten }}
                    </h5>

                    <a href="{{ route('garam.show',$kabupaten->id) }}"
                       class="btn btn-primary">
                       Kelola Data
                    </a>
=======
                        <div class="mb-4">
                            <label class="form-label fw-medium">Lokasi / Desa / Kecamatan</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan detail lokasi produksi garam..."></textarea>
                        </div>
>>>>>>> Stashed changes:resources/views/kabupaten/dashboardKab.blade.php

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            Simpan Data Tahunan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-secondary text-white py-3">
                    <h5 class="mb-0 fw-semibold">📅 2. Input Data Bulanan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="#" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-medium">Pilih Bulan</label>
                            <select class="form-select">
                                <option selected disabled>-- Pilih Bulan --</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium d-block">Jenis Produksi</label>
                            <div class="form-check form-check-inline mt-1">
                                <input class="form-check-input" type="radio" name="jenis_produksi" id="jemur" value="jemur">
                                <label class="form-check-input-label" for="jemur">☀️ Garam Jemur</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_produksi" id="rebus" value="rebus">
                                <label class="form-check-input-label" for="rebus">🔥 Garam Rebus</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Harga / Total Pendapatan Bulan Ini</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" placeholder="Masukkan total nominal">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold mt-auto">
                            Simpan Data Bulanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<<<<<<< Updated upstream:resources/views/kabupaten/index.blade.php

</body>
</html>
=======
@endsection
>>>>>>> Stashed changes:resources/views/kabupaten/dashboardKab.blade.php
