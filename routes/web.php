<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\MasterbankController;
use App\Http\Controllers\KukumpulController;
use App\Http\Controllers\TestimonialController;


Route::get('/', [PenggunaController::class, 'index'])->name('index');
Route::get('/profil', [PenggunaController::class, 'profil'])->name('profil');
Route::get('/teknis', [PenggunaController::class, 'teknis'])->name('teknis');
Route::post('/kontributor/store', [PenggunaController::class, 'store'])->name('kontributor.store');
Route::get('/pembayaran/{invoice}', [PenggunaController::class, 'pembayaran'])->name('pembayaran.index');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/grafikdashboard', [DashboardController::class, 'grafikdashboard'])->middleware(['auth', 'verified'])->name('grafikdashboard');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('bank', MasterBankController::class);
    Route::resource('kukumpul', KukumpulController::class);
    Route::patch('/kukumpul/{id}/sukses', [KukumpulController::class, 'markSukses'])->name('kukumpul.sukses');
    Route::patch('/kukumpul/{id}/reload', [KukumpulController::class, 'markReload'])->name('kukumpul.reload');
    Route::resource('testimoni', TestimonialController::class);
});


require __DIR__ . '/auth.php';
