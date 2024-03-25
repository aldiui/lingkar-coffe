<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('pages.user.dasboard.index');
});

Route::get('/penjualan', function () {
    return view('pages.user.penjualan.index');
});

Route::get('/stok', function () {
    return view('pages.user.stok.index');
});

Route::get('/keuangan', function () {
    return view('pages.user.keuangan.index');
});

Route::get('/harga', function () {
    return view('pages.user.harga.index');
});
