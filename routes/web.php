<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTahunanController;
use App\Http\Controllers\DataBulananController;
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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



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

Route::get('/export/bulanan', [DataBulananController::class, 'exportBulanan'])->name('export.bulanan');
Route::get('/export/tahunan', [DataBulananController::class, 'exportTahunan'])->name('export.tahunan');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');