<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* DOKTER
 * */
Route::middleware('role:dokter')->prefix('dokter')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboardDokter'])->name('dashboard');
    Route::get('/history-periksa', [DokterController::class, 'historyPemeriksaan'])->name('history.pemeriksaan');

    Route::get('/jadwal', [DokterController::class, 'showJadwalDokter'])->name('jadwalDokter');
    Route::post('/jadwal', [DokterController::class, 'storeJadwal'])->name('storeJadwal');
    Route::get('/jadwal/edit/{id}', [DokterController::class, 'editJadwal'])->name('editJadwal');
    Route::put('/jadwal/{id}', [DokterController::class, 'updateJadwal'])->name('updateJadwal');
    Route::delete('/jadwal/{id}', [DokterController::class, 'deleteJadwal'])->name('deleteJadwal');
    Route::patch('/jadwal/{id}/toggle-status', [DokterController::class, 'toggleStatusJadwal'])->name('toggleStatusJadwal');

});


/* PASIEN
 * */
Route::middleware('role:pasien')->prefix('pasien')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboardPasien'])->name('dashboard');
});


require __DIR__ . '/auth.php';
