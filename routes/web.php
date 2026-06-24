<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});



/*
|--------------------------------------------------------------------------
| Halaman Utama (Landing Page)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Auth Routes (hanya untuk tamu / belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // GET /login → tampilkan welcome.blade.php (bukan halaman login terpisah)
    Route::get('/login', function () {
        return view('welcome');
    })->name('login');

    // POST /login → proses login
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // POST /register → proses register
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Route yang butuh login (middleware auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard utama
    Route::get('/dashboard', [StatistikController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kabupaten
    Route::resource('kabupaten', KabupatenController::class);

    // Statistik
    Route::get('/statistik/StatistikKab', [StatistikController::class, 'statistikKab'])->name('statistik.kab');
    Route::resource('statistik', StatistikController::class);

    // Data Garam Tahunan
    Route::get('/garam', [DataTahunanController::class, 'index'])->name('garam.index');
    Route::get('/garam/rekap_tahunan', [DataTahunanController::class, 'rekapTahunan'])->name('garam.rekapTahunan');

    // Data Bulanan
    Route::get('/garam/rekap_bulanan', [DataBulananController::class, 'rekapBulanan'])->name('garam.rekapBulanan');
    Route::get('/data-bulanan/create/{kabupaten_id}', [DataBulananController::class, 'create'])->name('data-bulanan.create');
    Route::post('/data-bulanan', [DataBulananController::class, 'store'])->name('data-bulanan.store');
    Route::get('/data-bulanan/{dataBulanan}/edit', [DataBulananController::class, 'edit'])->name('data-bulanan.edit');
    Route::put('/data-bulanan/{dataBulanan}', [DataBulananController::class, 'update'])->name('data-bulanan.update');
    Route::delete('/data-bulanan/{dataBulanan}', [DataBulananController::class, 'destroy'])->name('data-bulanan.destroy');

    // Export
    Route::get('/export/bulanan', [DataBulananController::class, 'exportBulanan'])->name('export.bulanan');
    Route::get('/export/tahunan', [DataBulananController::class, 'exportTahunan'])->name('export.tahunan');
});