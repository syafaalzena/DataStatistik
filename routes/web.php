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
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\TangkapMenuController;
use App\Http\Controllers\ProduksiTangkapController;
use App\Http\Controllers\TripTangkapController;
use App\Http\Controllers\LaporanOperasionalController;
use App\Http\Controllers\KomoditasIkanController;
use App\Http\Controllers\PelabuhanController;

/*
|--------------------------------------------------------------------------
| Halaman Utama & Auth (Guest)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
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

    Route::get('/budidaya/rekapBulanan/export-pdf', [RekapBudidayaController::class, 'exportPdfBulanan'])
        ->name('budidaya.rekapBulanan.exportPdf');

    Route::get('/budidaya/rekapTahunan/export-pdf', [RekapBudidayaController::class, 'exportPdfTahunan'])
        ->name('budidaya.rekapTahunan.exportPdf');

    Route::get('/export/bulanan/pdf', [DataBulananController::class, 'exportPdfBulanan'])->name('export.bulanan.pdf');
    Route::get('/export/tahunan/pdf', [DataTahunanController::class, 'exportPdfTahunan'])->name('export.tahunan.pdf');

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

    /*
    |--------------------------------------------------------------------------
    | Tangkap
    |--------------------------------------------------------------------------
    */


Route::get('/tangkap', [TangkapMenuController::class, 'index'])->name('tangkap.index');

// PENTING: route literal /tangkap/produksi dan /tangkap/laporan-operasional
// HARUS di atas /tangkap/{kabupaten}, supaya tidak "ketangkep" jadi nilai {kabupaten}
Route::get('/tangkap/produksi', [ProduksiTangkapController::class, 'index'])->name('tangkap.produksi.index');
Route::get('/tangkap/laporan-operasional', [LaporanOperasionalController::class, 'pilihKabupaten'])->name('laporan-operasional.pilih-kabupaten');

Route::get('/tangkap/{kabupaten}', [ProduksiTangkapController::class, 'input'])->name('tangkap.input');
Route::get('/tangkap/{kabupaten}/produksi/create', [ProduksiTangkapController::class, 'create'])->name('tangkap.produksi.create');
Route::get('/tangkap/{kabupaten}/produksi/rekap', [ProduksiTangkapController::class, 'rekap'])->name('tangkap.produksi.rekap');
Route::get('/tangkap/{kabupaten}/produksi/export', [ProduksiTangkapController::class, 'export'])->name('tangkap.produksi.export');
Route::get('/tangkap/{kabupaten}/produksi/export-pdf', [ProduksiTangkapController::class, 'exportPdf'])->name('tangkap.produksi.exportPdf');
Route::post('/tangkap/{kabupaten}/produksi', [ProduksiTangkapController::class, 'store'])->name('tangkap.produksi.store');
Route::put('/tangkap/produksi/{produksi}', [ProduksiTangkapController::class, 'update'])->name('tangkap.produksi.update');
Route::delete('/tangkap/produksi/{produksi}', [ProduksiTangkapController::class, 'destroy'])->name('tangkap.produksi.destroy');

Route::post('/komoditas-ikan', [KomoditasIkanController::class, 'store'])->name('komoditas-ikan.store');
Route::put('/komoditas-ikan/{komoditasIkan}', [KomoditasIkanController::class, 'update'])->name('komoditas-ikan.update');
Route::delete('/komoditas-ikan/{komoditasIkan}', [KomoditasIkanController::class, 'destroy'])->name('komoditas-ikan.destroy');

Route::get('/tangkap/{kabupaten}/pelabuhan', [PelabuhanController::class, 'index'])->name('pelabuhan.index');
Route::post('/tangkap/{kabupaten}/pelabuhan', [PelabuhanController::class, 'store'])->name('pelabuhan.store');
Route::put('/tangkap/pelabuhan/{pelabuhan}', [PelabuhanController::class, 'update'])->name('pelabuhan.update');
Route::delete('/tangkap/pelabuhan/{pelabuhan}', [PelabuhanController::class, 'destroy'])->name('pelabuhan.destroy');

Route::get('/tangkap/{kabupaten}/laporan-operasional', [LaporanOperasionalController::class, 'index'])->name('laporan-operasional.index');

// Trip Tangkap
Route::get('/tangkap/{kabupaten}/trip', [TripTangkapController::class, 'input'])->name('tangkap.trip.input');
Route::get('/tangkap/{kabupaten}/trip/create', [TripTangkapController::class, 'create'])->name('tangkap.trip.create');
Route::post('/tangkap/{kabupaten}/trip', [TripTangkapController::class, 'store'])->name('tangkap.trip.store');
Route::put('/tangkap/trip/{trip}', [TripTangkapController::class, 'update'])->name('tangkap.trip.update');
Route::delete('/tangkap/trip/{trip}', [TripTangkapController::class, 'destroy'])->name('tangkap.trip.destroy');
Route::get('/tangkap/{kabupaten}/laporan-operasional/create', [LaporanOperasionalController::class, 'create'])->name('laporan-operasional.create');
Route::post('/tangkap/{kabupaten}/laporan-operasional', [LaporanOperasionalController::class, 'store'])->name('laporan-operasional.store');
Route::get('/tangkap/laporan-operasional/{laporanOperasional}', [LaporanOperasionalController::class, 'show'])->name('laporan-operasional.show');
Route::get('/tangkap/laporan-operasional/{laporanOperasional}/edit', [LaporanOperasionalController::class, 'edit'])->name('laporan-operasional.edit');
Route::put('/tangkap/laporan-operasional/{laporanOperasional}', [LaporanOperasionalController::class, 'update'])->name('laporan-operasional.update');
Route::delete('/tangkap/laporan-operasional/{laporanOperasional}', [LaporanOperasionalController::class, 'destroy'])->name('laporan-operasional.destroy');
Route::get('/tangkap/laporan-operasional/rekap', [LaporanOperasionalController::class, 'rekapTahunan'])->name('laporan-operasional.rekap');
});