<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dasboard.index');
});

Route::get('/penjualan', function () {
    return view('pages.penjualan.index');
});

Route::get('/stok', function () {
    return view('pages.stok.index');
});

Route::get('/keuangan', function () {
    return view('pages.keuangan.index');
});

Route::get('/harga', function () {
    return view('pages.harga.index');
});