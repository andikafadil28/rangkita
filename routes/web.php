<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminQuestionController;
use App\Http\Controllers\AdminQuestionPackageController;
use App\Http\Controllers\AdminSoalCategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminWeddingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);
Route::get('/produk', [PageController::class, 'produk']);
Route::get('/produk/{slug}', [PageController::class, 'produkDetail']);
Route::get('/undangan', [WeddingController::class, 'index'])->name('weddings.index');
Route::get('/undangan/template/{template}', [WeddingController::class, 'templateDetail'])->name('weddings.template');
Route::get('/undangan/preview/{template}', [WeddingController::class, 'templatePreview'])->name('weddings.preview');
Route::post('/undangan/{wedding}/ucapan', [WeddingController::class, 'addWish'])
    ->middleware('throttle:5,1')
    ->name('weddings.wishes.store');
Route::get('/undangan/{wedding}', [WeddingController::class, 'show'])->name('weddings.show');
Route::get('/artikel', [PageController::class, 'artikel']);
Route::get('/artikel/{slug}', [PageController::class, 'artikelDetail']);
Route::get('/kontak', [PageController::class, 'kontak']);

Route::prefix('soal')->name('soal.')->group(function () {
    Route::get('/', [SoalController::class, 'index'])->name('index');
    Route::get('/kategori/{category}', [SoalController::class, 'category'])->name('category');
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

    Route::get('/soal/paket/{package}/quiz', [SoalController::class, 'quiz'])->name('soal.quiz');
    Route::post('/soal/paket/{package}/submit', [SoalController::class, 'submit'])->name('soal.submit');
    Route::get('/hasil-soal/{session}', [SoalController::class, 'result'])->name('soal.result');
    Route::get('/soal/riwayat', [SoalController::class, 'history'])->name('soal.history');
    Route::get('/soal/paket/{package}/beli', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/pembayaran/sukses', [PaymentController::class, 'success'])->name('payment.success');
});

Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');

    Route::prefix('undangan')->name('weddings.')->group(function () {
        Route::get('/', [AdminWeddingController::class, 'index'])->name('index');
        Route::get('/create', [AdminWeddingController::class, 'create'])->name('create');
        Route::post('/', [AdminWeddingController::class, 'store'])->name('store');
        Route::get('/{wedding}/edit', [AdminWeddingController::class, 'edit'])->name('edit');
        Route::put('/{wedding}', [AdminWeddingController::class, 'update'])->name('update');
        Route::delete('/{wedding}', [AdminWeddingController::class, 'destroy'])->name('destroy');
        Route::delete('/{wedding}/galeri/{gallery}', [AdminWeddingController::class, 'destroyGalleryPhoto'])->name('gallery.destroy');
        Route::patch('/{wedding}/ucapan/{wish}', [AdminWeddingController::class, 'toggleWish'])->name('wishes.toggle');
        Route::delete('/{wedding}/ucapan/{wish}', [AdminWeddingController::class, 'destroyWish'])->name('wishes.destroy');
    });

    Route::prefix('soal/paket')->name('packages.')->group(function () {
        Route::get('/', [AdminQuestionPackageController::class, 'index'])->name('index');
        Route::get('/create', [AdminQuestionPackageController::class, 'create'])->name('create');
        Route::post('/', [AdminQuestionPackageController::class, 'store'])->name('store');
        Route::get('/{package}/edit', [AdminQuestionPackageController::class, 'edit'])->name('edit');
        Route::put('/{package}', [AdminQuestionPackageController::class, 'update'])->name('update');
        Route::delete('/{package}', [AdminQuestionPackageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('soal/paket/{package}/soal')->name('questions.')->group(function () {
        Route::get('/', [AdminQuestionController::class, 'index'])->name('index');
        Route::get('/create', [AdminQuestionController::class, 'create'])->name('create');
        Route::post('/', [AdminQuestionController::class, 'store'])->name('store');
        Route::get('/{question}/edit', [AdminQuestionController::class, 'edit'])->name('edit');
        Route::put('/{question}', [AdminQuestionController::class, 'update'])->name('update');
        Route::delete('/{question}', [AdminQuestionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('soal/kategori')->name('categories.')->group(function () {
        Route::get('/', [AdminSoalCategoryController::class, 'index'])->name('index');
        Route::get('/create', [AdminSoalCategoryController::class, 'create'])->name('create');
        Route::post('/', [AdminSoalCategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [AdminSoalCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [AdminSoalCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [AdminSoalCategoryController::class, 'destroy'])->name('destroy');
    });
});
