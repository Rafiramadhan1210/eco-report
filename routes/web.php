<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanMasukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Warga: CRUD laporan milik sendiri
    Route::middleware('role:warga')->group(function () {
        Route::resource('laporan', LaporanController::class)->except('show');
    });

    // Semua peran: detail laporan (dicek per peran di controller) dan komentar
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::post('/laporan/{laporan}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
    Route::put('/komentar/{komentar}', [KomentarController::class, 'update'])->name('komentar.update');
    Route::delete('/komentar/{komentar}', [KomentarController::class, 'destroy'])->name('komentar.destroy');

    // Pengurus dan admin: kelola laporan masuk
    Route::middleware('role:pengurus,admin')->prefix('kelola')->name('kelola.')->group(function () {
        Route::get('laporan', [LaporanMasukController::class, 'index'])->name('laporan');
        Route::get('peta', [LaporanMasukController::class, 'peta'])->name('peta');
        Route::post('laporan/{laporan}/tindak-lanjut', [LaporanMasukController::class, 'tindakLanjut'])->name('tindaklanjut');
        Route::delete('laporan/{laporan}', [LaporanMasukController::class, 'destroy'])
            ->middleware('role:admin')->name('laporan.destroy');
    });

    // Admin: data master dan pengguna
    Route::middleware('role:admin')->group(function () {
        Route::resource('kategori', KategoriController::class)->except('show');
        Route::resource('wilayah', WilayahController::class)->except('show');
        Route::resource('pengguna', UserController::class)->except('show')->parameters(['pengguna' => 'user']);
    });
});

require __DIR__ . '/auth.php';
