<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TreatmentController;
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


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'permission:menu.dashboard'])->name('dashboard');
Route::get('/grafikdashboard', [DashboardController::class, 'grafikdashboard'])->middleware(['auth', 'verified'])->name('grafikdashboard');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

    Route::resource('bank', MasterBankController::class)->middleware('permission:menu.bank');
    Route::resource('kukumpul', KukumpulController::class);
    Route::patch('/kukumpul/{id}/sukses', [KukumpulController::class, 'markSukses'])->name('kukumpul.sukses');
    Route::patch('/kukumpul/{id}/reload', [KukumpulController::class, 'markReload'])->name('kukumpul.reload');
    Route::resource('testimoni', TestimonialController::class)->middleware('permission:menu.testimoni');
    Route::resource('patients', PatientController::class)->except(['create', 'edit', 'show'])->middleware('permission:menu.patients');
    Route::resource('employees', EmployeeController::class)->except(['create', 'edit', 'show'])->middleware('permission:menu.employees');
    Route::resource('treatments', TreatmentController::class)->except(['create', 'edit', 'show'])->middleware('permission:menu.treatments');
    Route::resource('medical-records', MedicalRecordController::class)->parameters([
        'medical-records' => 'medicalRecord',
    ])->except(['create', 'edit', 'show'])->middleware('permission:menu.medical-records');
    Route::get('medical-records/{id}/invoice', [MedicalRecordController::class, 'downloadInvoice'])
        ->middleware('permission:menu.medical-records')
        ->name('medical-records.invoice');
    Route::resource('payrolls', PayrollController::class)->except(['create', 'edit', 'show'])->middleware('permission:menu.payrolls');

    Route::name('admin.')->group(function () {
        Route::resource('roles', RoleController::class)->except(['create', 'edit', 'show'])->middleware('permission:menu.roles');
        Route::get('permissions', [PermissionController::class, 'index'])->middleware('permission:menu.permissions')->name('permissions.index');
        Route::put('permissions/{role}', [PermissionController::class, 'update'])->middleware('permission:menu.permissions')->name('permissions.update');
    });
});


require __DIR__ . '/auth.php';
