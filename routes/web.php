<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home']);
Route::get('/produk', [PageController::class, 'produk']);
Route::get('/undangan', [PageController::class, 'undangan']);
Route::get('/cpns', [PageController::class, 'cpns']);
Route::get('/artikel', [PageController::class, 'artikel']);
Route::get('/artikel/{slug}', [PageController::class, 'artikelDetail']);
Route::get('/kontak', [PageController::class, 'kontak']);
