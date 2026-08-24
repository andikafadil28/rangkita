<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CpnsController;
use App\Http\Controllers\PaymentController;

Route::get('/', [PageController::class, 'home']);
Route::get('/produk', [PageController::class, 'produk']);
Route::get('/produk/{slug}', [PageController::class, 'produkDetail']);
Route::get('/undangan', [PageController::class, 'undangan']);
Route::get('/undangan/template/{slug}', [PageController::class, 'templateDetail']);
Route::get('/undangan/preview/{slug}', [PageController::class, 'templatePreview']);
Route::get('/artikel', [PageController::class, 'artikel']);
Route::get('/artikel/{slug}', [PageController::class, 'artikelDetail']);
Route::get('/kontak', [PageController::class, 'kontak']);

Route::prefix('cpns')->name('cpns.')->group(function () {
    Route::get('/', [CpnsController::class, 'index'])->name('index');
    Route::get('/kategori/{category}', [CpnsController::class, 'category'])->name('category');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('/cpns/paket/{package}/quiz', [CpnsController::class, 'quiz'])->name('cpns.quiz');
    Route::post('/cpns/paket/{package}/submit', [CpnsController::class, 'submit'])->name('cpns.submit');
    Route::get('/hasil-quiz/{session}', [CpnsController::class, 'result'])->name('cpns.result');
    Route::get('/cpns/paket/{package}/beli', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/pembayaran/sukses', [PaymentController::class, 'success'])->name('payment.success');
});

Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
