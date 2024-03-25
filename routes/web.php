<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::match(['get', 'put'], 'profil', [App\Http\Controllers\User\ProfilController::class, 'index'])->name('profil');
    Route::put('profil/password', [App\Http\Controllers\User\ProfilController::class, 'password'])->name('profil.password');
    Route::match(['get', 'put'], 'harga', [App\Http\Controllers\User\HargaController::class, 'index'])->name('harga');
    Route::resource('stok', App\Http\Controllers\User\StokController::class)->names('stok');
});

Route::get('/', function () {
    return view('pages.user.dasboard.index');
});

Route::get('/penjualan', function () {
    return view('pages.user.penjualan.index');
});
Route::get('/keuangan', function () {
    return view('pages.user.keuangan.index');
});
