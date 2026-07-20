<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataTahunanController;
use App\Http\Controllers\DataBulananController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

use App\Http\Controllers\KabupatenIkanController;
use App\Http\Controllers\DataBulananBudidayaController;
use App\Http\Controllers\DataTahunanSaranaController;
use App\Http\Controllers\RekapBudidayaController;
use App\Http\Controllers\KomoditasBudidayaController;
use App\Http\Controllers\JenisBudidayaController;


/*
|--------------------------------------------------------------------------
| Halaman Utama & Auth (Guest)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('welcome');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Route Protected (butuh login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [StatistikController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('kabupaten', KabupatenController::class);

    Route::get('/statistik/StatistikKab', [StatistikController::class, 'statistikKab'])->name('statistik.kab');
    Route::resource('statistik', StatistikController::class);

    Route::get('/garam', [DataTahunanController::class, 'index'])->name('garam.index');
    Route::get('/garam/rekap_tahunan', [DataTahunanController::class, 'rekapTahunan'])->name('garam.rekapTahunan');

    Route::get('/garam/rekap_bulanan', [DataBulananController::class, 'rekapBulanan'])->name('garam.rekapBulanan');
    Route::get('/data-bulanan/create/{kabupaten_id}', [DataBulananController::class, 'create'])->name('data-bulanan.create');
    Route::post('/data-bulanan', [DataBulananController::class, 'store'])->name('data-bulanan.store');
    Route::get('/data-bulanan/{dataBulanan}/edit', [DataBulananController::class, 'edit'])->name('data-bulanan.edit');
    Route::put('/data-bulanan/{dataBulanan}', [DataBulananController::class, 'update'])->name('data-bulanan.update');
    Route::delete('/data-bulanan/{dataBulanan}', [DataBulananController::class, 'destroy'])->name('data-bulanan.destroy');

    Route::get('/export/bulanan', [DataBulananController::class, 'exportBulanan'])->name('export.bulanan');
    Route::get('/export/tahunan', [DataBulananController::class, 'exportTahunan'])->name('export.tahunan');

    /*
    |--------------------------------------------------------------------------
    | Budidaya
    |--------------------------------------------------------------------------
    */

    Route::get('/budidaya', [KabupatenIkanController::class, 'index'])
        ->name('budidaya.index');

    /*
    |----------------------------------------------------------------------
    | Budidaya - Rekap Bulanan & Tahunan
    | PENTING: route ini HARUS di atas '/budidaya/{kabupaten}' supaya
    | tidak "ketangkep" oleh wildcard di bawahnya.
    |----------------------------------------------------------------------
    */

    Route::get('/budidaya/rekapBulanan', [RekapBudidayaController::class, 'bulanan'])
        ->name('budidaya.rekapBulanan');

    Route::get('/budidaya/rekapBulanan/export', [RekapBudidayaController::class, 'exportRekapBulanan'])
        ->name('budidaya.rekapBulanan.export');

    Route::get('/budidaya/rekapTahunan', [RekapBudidayaController::class, 'tahunan'])
        ->name('budidaya.rekapTahunan');

    Route::get('/budidaya/rekapTahunan/export', [RekapBudidayaController::class, 'exportRekapTahunan'])
        ->name('budidaya.rekapTahunan.export');

    // Route::get('/budidaya/rekapTahunan/export', [RekapBudidayaController::class, 'exportTahunan'])
    //     ->name('budidaya.rekapTahunan.export');

    /*
    |----------------------------------------------------------------------
    | Budidaya - Input per kabupaten (WILDCARD, harus di bawah route di atas)
    |----------------------------------------------------------------------
    */

    Route::get('/budidaya/{kabupaten}', [KabupatenIkanController::class, 'input'])
        ->name('budidaya.input');


    Route::post('/budidaya/{kabupaten}/sarana', [DataTahunanSaranaController::class, 'store'])
        ->name('budidaya.sarana.store');

    Route::put('/budidaya/sarana/{id}', [DataTahunanSaranaController::class, 'update'])
        ->name('budidaya.sarana.update');

    Route::delete('/budidaya/sarana/{id}', [DataTahunanSaranaController::class, 'destroy'])
        ->name('budidaya.sarana.destroy');

    Route::post('/budidaya/{kabupaten}/produksi', [DataBulananBudidayaController::class, 'store'])
        ->name('budidaya.produksi.store');

    Route::put('/budidaya/produksi/{id}', [DataBulananBudidayaController::class, 'update'])
        ->name('budidaya.produksi.update');

    Route::delete('/budidaya/produksi/{id}', [DataBulananBudidayaController::class, 'destroy'])
        ->name('budidaya.produksi.destroy');

    /*
    |----------------------------------------------------------------------
    | Budidaya - Sibling: Kelola Komoditas (per kabupaten)
    |----------------------------------------------------------------------
    */

    Route::get('/budidaya/{kabupatenId}/komoditas/create', [KomoditasBudidayaController::class, 'createForKabupaten'])
        ->name('budidaya.komoditas.create');

    Route::post('/budidaya/{kabupatenId}/komoditas', [KomoditasBudidayaController::class, 'storeForKabupaten'])
        ->name('budidaya.komoditas.store');

    Route::delete('/budidaya/{kabupatenId}/komoditas/{id}', [KomoditasBudidayaController::class, 'destroyForKabupaten'])
        ->name('budidaya.komoditas.destroy');

    /*
    |----------------------------------------------------------------------
    | Budidaya - Sibling: Kelola Jenis Budidaya (per kabupaten)
    |----------------------------------------------------------------------
    */

    Route::get('/budidaya/{kabupatenId}/jenis', [JenisBudidayaController::class, 'index'])
        ->name('budidaya.jenis.index');

    Route::post('/budidaya/{kabupatenId}/jenis', [JenisBudidayaController::class, 'store'])
        ->name('budidaya.jenis.store');

    Route::put('/budidaya/jenis/{id}', [JenisBudidayaController::class, 'update'])
        ->name('budidaya.jenis.update');

    Route::delete('/budidaya/jenis/{id}', [JenisBudidayaController::class, 'destroy'])
        ->name('budidaya.jenis.destroy');

});