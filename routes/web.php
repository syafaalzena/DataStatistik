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