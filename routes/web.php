<?php

use App\Http\Controllers\Dokter\ChatDokterController;
use App\Http\Controllers\Dokter\MemeriksaController;
use App\Http\Controllers\Dokter\ObatController;
use App\Http\Controllers\Dokter\DokterController as DokterController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Pasien\ChatPasienController;
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
    Route::prefix('jadwal-periksa')->name('JadwalPeriksa.')->group(function () {
        Route::get('/', [JadwalPeriksaController::class, 'index'])->name('index');
        Route::get('/create', [JadwalPeriksaController::class, 'create'])->name('create');
        Route::post('/', [JadwalPeriksaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [JadwalPeriksaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JadwalPeriksaController::class, 'update'])->name('update');
        Route::delete('/{id}', [JadwalPeriksaController::class, 'delete'])->name('delete');
        Route::patch('/{id}/toggle-status', [JadwalPeriksaController::class, 'toggleStatus'])->name('toggleStatus');
    });

    /*-----------------
     * OBAT ROUTE
     *-----------------
     * */
    Route::prefix('obat')->name('obat.')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('index');
        Route::get('/create', [ObatController::class, 'create'])->name('create');
        Route::post('/', [ObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [ObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('destroy');

        Route::get('/restore', [ObatController::class, 'recycle'])->name('recycle');  //
        Route::get('/restore/{id}', [ObatController::class, 'restore'])->name('restore'); //


    });
    /* -----------------
     * MEMERIKSA PASIEN
     * -----------------
     * */
    Route::prefix('memeriksa')->name('Memeriksa.')->group(function () {
        Route::get('/', [MemeriksaController::class, 'index'])->name('index');
        Route::delete('/{id}', [MemeriksaController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/create', [MemeriksaController::class, 'create'])->name('create');
        Route::post('/{janjiPeriksaId}', [MemeriksaController::class, 'store'])->name('store');
    });


    /*--------------------
     *  CHAT DOKTER
    * --------------------
    * */

    Route::prefix('chat')->name('Chat.')->group(function () {
        Route::get('/', [ChatDokterController::class, 'index'])->name('index'); // BERANDA NEMAPILKAN NAMA ORH YG CHAT
        Route::get('/chatDetail/{id_pasien}', [ChatDokterController::class, 'chatDetail'])->name('detail');
        Route::post('/chatDetail', [ChatDokterController::class, 'store'])->name('store');
        Route::put('/chatDetail/update/{id}', [ChatDokterController::class, 'update'])->name('update');
        Route::delete('/chatDetail/{id}', [ChatDokterController::class, 'destroy'])->name('destroy');
    });


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
    Route::prefix('janji-periksa')->name('JanjiPeriksa.')->group(function () {
        Route::get('/', [JanjiPeriksaController::class, 'index'])->name('index');
        Route::get('/create', [JanjiPeriksaController::class, 'create'])->name('create');
        Route::post('/', [JanjiPeriksaController::class, 'store'])->name('store');
        Route::get('/{janjiPeriksa}/edit', [JanjiPeriksaController::class, 'edit'])->name('edit');
        Route::put('/{janjiPeriksa}', [JanjiPeriksaController::class, 'update'])->name('update');
        Route::delete('/{janjiPeriksa}', [JanjiPeriksaController::class, 'destroy'])->name('destroy');
    });

    /*--------------------
    *  CHAT DOKTER
   * --------------------
   * */

    Route::prefix('chat')->name('Chat.')->group(function () {
        Route::get('/', [ChatPasienController::class, 'index'])->name('index'); // BERANDA NEMAPILKAN NAMA ORH YG CHAT
        Route::get('/chatDetail/{id_pasien}', [ChatPasienController::class, 'chatDetail'])->name('detail');
        Route::post('/chatDetail', [ChatPasienController::class, 'store'])->name('store');
        Route::put('/chatDetail/update/{id}', [ChatPasienController::class, 'update'])->name('update');
        Route::delete('/chatDetail/{id}', [ChatPasienController::class, 'destroy'])->name('destroy');
    });


});


require __DIR__ . '/auth.php';
