<?php

use App\Http\Controllers\Dokter\MemeriksaController;
use App\Http\Controllers\Dokter\ObatController;
use App\Http\Controllers\Dokter\DokterController as DokterController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Pasien\JanjiPeriksaController;
use App\Http\Controllers\Pasien\PasienController;
use App\Http\Controllers\ProfileController;
use App\Models\JanjiPeriksa;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* DOKTER
 * */
Route::middleware(['auth', 'role:dokter', 'verified'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboardDokter'])->name('dashboard');

    /* HISTORY PEMERIKSAAN YANG TELAH DI LAKUKAN DOKTER
     * */
    Route::get('/history-periksa', [DokterController::class, 'historyPeriksa'])->name('HistoryPeriksa.index');

    /*------------------
     *  JADWAL PERIKSA
     * -----------------
     * */
    Route::get('jadwal-periksa', [JadwalPeriksaController::class, 'index'])->name('JadwalPeriksa.index');
    Route::get('jadwal-periksa/create', [JadwalPeriksaController::class, 'create'])->name('JadwalPeriksa.create');
    Route::post('jadwal-periksa/', [JadwalPeriksaController::class, 'store'])->name('JadwalPeriksa.store');
    Route::get('jadwal-periksa/{id}/edit', [JadwalPeriksaController::class, 'edit'])->name('JadwalPeriksa.edit');
    Route::put('jadwal-periksa/{id}', [JadwalPeriksaController::class, 'update'])->name('JadwalPeriksa.update');
    Route::delete('jadwal-periksa/{id}', [JadwalPeriksaController::class, 'delete'])->name('JadwalPeriksa.delete');
    Route::patch('jadwal-periksa/{id}/toggle-status', [JadwalPeriksaController::class, 'toggleStatus'])->name('JadwalPeriksa.toggleStatus');

    /*-----------------
     * OBAT ROUTE
     *-----------------
     * */
    Route::get('obat/', [ObatController::class, 'index'])->name('obat.index');
    Route::get('obat/create', [ObatController::class, 'create'])->name('obat.create');
    Route::post('obat/', [ObatController::class, 'store'])->name('obat.store');
    Route::get('obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::patch('obat/{id}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

    /* -----------------
     * MEMERIKSA PASIEN
     * -----------------
     * */
    Route::get('memeriksa/', [MemeriksaController::class, 'index'])->name('Memeriksa.index');
    Route::delete('memeriksa/{id}', [MemeriksaController::class, 'destroy'])->name('Memeriksa.destroy');
    Route::get('memeriksa/{id}/create', [MemeriksaController::class, 'create'])->name('Memeriksa.create');
    Route::post('memeriksa/{janjiPeriksaId}', [MemeriksaController::class, 'store'])->name('Memeriksa.store');




});


/* PASIEN
 * */
Route::middleware(['role:pasien', 'auth', 'verified'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboardPasien'])->name('dashboard');

    /*HISTORY PERIKSA
     * */
    Route::get('/history-periksa', [PasienController::class, 'historyPeriksa'])->name('HistoryPeriksa.index');

    /*JANJI PERIKSA
     * */
    Route::get('janji-periksa/', [JanjiPeriksaController::class, 'index'])->name('JanjiPeriksa.index');
    Route::get('janji-periksa/create', [JanjiPeriksaController::class, 'create'])->name('JanjiPeriksa.create');
    Route::post('janji-periksa/', [JanjiPeriksaController::class, 'store'])->name('JanjiPeriksa.store');
    Route::get('janji-periksa/{janjiPeriksa}/edit', [JanjiPeriksaController::class, 'edit'])->name('JanjiPeriksa.edit');
    Route::put('janji-periksa/{janjiPeriksa}', [JanjiPeriksaController::class, 'update'])->name('JanjiPeriksa.update');
    Route::delete('janji-periksa/{janjiPeriksa}', [JanjiPeriksaController::class, 'destroy'])->name('JanjiPeriksa.destroy');

});


require __DIR__ . '/auth.php';
