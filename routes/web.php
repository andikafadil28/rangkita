<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/produk', function () {
    return view('pages.produk');
});

Route::get('/undangan', function () {
    return view('pages.undangan');
});

Route::get('/cpns', function () {
    return view('pages.cpns');
});

Route::get('/artikel', function () {
    return view('pages.artikel');
});

Route::get('/kontak', function () {
    return view('pages.kontak');
});
