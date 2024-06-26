<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::match(['get', 'put'], 'profil', [App\Http\Controllers\User\ProfilController::class, 'index'])->name('profil');
    Route::put('profil/password', [App\Http\Controllers\User\ProfilController::class, 'password'])->name('profil.password');
    Route::match(['get', 'put'], 'harga', [App\Http\Controllers\User\HargaController::class, 'index'])->name('harga');
    Route::resource('stok', App\Http\Controllers\User\StokController::class)->names('stok');
    Route::resource('penjualan', App\Http\Controllers\User\PenjualanController::class)->names('penjualan');
    Route::get('keuangan', [App\Http\Controllers\User\KeuanganController::class, 'index'])->name('keuangan');
    Route::post('setor-penjualan', [App\Http\Controllers\User\PenjualanController::class, 'setorPenjualan'])->name('setor.penjualan');
    Route::post('insentif-penjualan', [App\Http\Controllers\User\PenjualanController::class, 'insentifPenjualan'])->name('insentif.penjualan');
});

Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::match(['get', 'put'], 'profil', [App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('admin.profil');
    Route::put('profil/password', [App\Http\Controllers\Admin\ProfilController::class, 'password'])->name('admin.profil.password');
    Route::match(['get', 'put'], 'harga', [App\Http\Controllers\Admin\HargaController::class, 'index'])->name('admin.harga');
    Route::resource('mitra', App\Http\Controllers\Admin\MitraController::class)->names('admin.mitra');
    Route::resource('stok', App\Http\Controllers\Admin\StokController::class)->names('admin.stok');
    Route::get('keuangan', [App\Http\Controllers\Admin\KeuanganController::class, 'index'])->name('admin.keuangan');
    Route::resource('penjualan', App\Http\Controllers\Admin\PenjualanController::class)->names('admin.penjualan');
});
