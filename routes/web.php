<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
//admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\AdminActivityController;
//petugas
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController; 
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;

//peminjam
use App\Http\Controllers\Peminjaman\PeminjamDashboardController; 
use App\Http\Controllers\Peminjaman\PeminjamController;
use App\Http\Controllers\Peminjaman\PeminjamanController;
use App\Http\Controllers\Peminjaman\AlatController;
use App\Http\Controllers\Peminjaman\RiwayatPeminjamanController;




// Redirect Halaman Awal
Route::get('/', function () {
    return redirect()->route('login');
});


// Auth Routes (Breeze)
require __DIR__.'/auth.php';


// Profile (User Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ================= ADMIN AREA =================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Manajemen User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Kategori
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Peminjaman
        Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman', [AdminPeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::put('/peminjaman/{id}', [AdminPeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::delete('/peminjaman/{id}', [AdminPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

        // Pengembalian
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::get('/pengembalian/{id}/edit', [PengembalianController::class, 'edit'])->name('pengembalian.edit');
        Route::put('/pengembalian/{id}', [PengembalianController::class, 'update'])->name('pengembalian.update');
        Route::delete('/pengembalian/{id}', [PengembalianController::class, 'destroy'])->name('pengembalian.destroy');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

        // Log Aktivitas
        Route::get('/activities', [AdminActivityController::class, 'index'])->name('activities.index');
    });


// ================= PETUGAS =================
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
            ->name('dashboard');

        //peminjaman
        Route::get('/peminjaman', [PetugasPeminjamanController::class, 'index'])
        ->name('peminjaman.index');

        Route::put('/peminjaman/{id}/kembali', [PetugasPeminjamanController::class, 'kembali'])
        ->name('peminjaman.kembali');

        Route::put('/peminjaman/{id}/setujui', [PetugasPeminjamanController::class, 'setujui'])
        ->name('peminjaman.setujui');

        //pengembalian
        Route::get('/pengembalian', [PetugasPengembalianController::class, 'index'])
            ->name('pengembalian.index');

        //laporan
        Route::get('/laporan', [PetugasPeminjamanController::class, 'laporan'])
        ->name('laporan');


    });

// ================= PEMINJAM =================
Route::middleware(['auth', 'role:peminjam'])
    ->prefix('peminjam')
    ->name('peminjam.')
    ->group(function () {

        Route::get('/dashboard', [PeminjamDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/alat', [AlatController::class, 'index'])
            ->name('alat.index');

        Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');

        // Riwayat Peminjaman
        Route::get('/riwayat', [RiwayatPeminjamanController::class, 'index'])
            ->name('peminjaman.index'); // <-- ini untuk sidebar "Riwayat Peminjaman"


    });
