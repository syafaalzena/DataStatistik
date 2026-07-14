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

Route::get('/budidaya/{kabupaten}', [KabupatenIkanController::class, 'input'])
    ->name('budidaya.input');


Route::post('/budidaya/{kabupaten}/sarana', [DataTahunanSaranaController::class, 'storeSarana'])
    ->name('budidaya.sarana.store');

Route::put('/budidaya/sarana/{id}', [DataTahunanSaranaController::class, 'updateSarana'])
    ->name('budidaya.sarana.update');

Route::delete('/budidaya/sarana/{id}', [DataTahunanSaranaController::class, 'destroySarana'])
    ->name('budidaya.sarana.destroy');

Route::post('/budidaya/{kabupaten}/produksi', [DataBulananBudidayaController::class, 'storeProduksi'])
    ->name('budidaya.produksi.store');

Route::put('/budidaya/produksi/{id}', [DataBulananBudidayaController::class, 'updateProduksi'])
    ->name('budidaya.produksi.update');

Route::delete('/budidaya/produksi/{id}', [DataBulananBudidayaController::class, 'destroyProduksi'])
    ->name('budidaya.produksi.destroy');

});