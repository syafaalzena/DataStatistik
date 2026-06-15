<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTahunanController;
use App\Http\Controllers\DataBulananController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\KabupatenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kabupaten', KabupatenController::class);
Route::get('/statistik/StatistikKab', [StatistikController::class, 'statistikKab'])->name('statistik.kab');
Route::resource('statistik', StatistikController::class);
Route::get('/garam', [DataTahunanController::class, 'index'])->name('garam.index');
Route::get('/dashboard', [StatistikController::class, 'dashboard'])->name('dashboard');
Route::get('/garam/rekap_tahunan', [DataTahunanController::class, 'rekapTahunan'])->name('garam.rekapTahunan');
Route::get('/garam/rekap_bulanan', [DataBulananController::class, 'rekapBulanan'])->name('garam.rekapBulanan');
Route::post('/data-bulanan', [DataBulananController::class, 'store'])->name('data-bulanan.store');
Route::get('/data-bulanan/create/{kabupaten_id}', [DataBulananController::class, 'create']) ->name('data-bulanan.create');
Route::delete('/data-bulanan/{dataBulanan}', [DataBulananController::class, 'destroy']) ->name('data-bulanan.destroy');
Route::get('/data-bulanan/{dataBulanan}/edit', [DataBulananController::class, 'edit'])
    ->name('data-bulanan.edit');

Route::put('/data-bulanan/{dataBulanan}', [DataBulananController::class, 'update'])
    ->name('data-bulanan.update');