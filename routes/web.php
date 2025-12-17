<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\PengukuranController;
use App\Http\Controllers\StatusGiziController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\LaporanController;

// Landing Page -> Redirect ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Halaman login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (hanya untuk user yang login)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Data Balita
Route::get('/balita', [App\Http\Controllers\BalitaController::class, 'index'])->name('balita.index')->middleware('auth');
Route::post('/balita', [App\Http\Controllers\BalitaController::class, 'store'])->name('balita.store')->middleware('auth');
Route::get('/balita/{id}', [App\Http\Controllers\BalitaController::class, 'show'])->name('balita.show')->middleware('auth');
Route::put('/balita/{id}', [App\Http\Controllers\BalitaController::class, 'update'])->name('balita.update')->middleware('auth');
Route::delete('/balita/{id}', [App\Http\Controllers\BalitaController::class, 'destroy'])->name('balita.destroy')->middleware('auth');
Route::get('/api/balita/{id}', [App\Http\Controllers\BalitaController::class, 'getBalitaData'])->name('api.balita.data')->middleware('auth');

// DATASET (baru)
Route::get('/dataset', [DatasetController::class, 'index'])->name('dataset.index')->middleware('auth');
Route::get('/dataset/export', [DatasetController::class, 'export'])->name('dataset.export')->middleware('auth');

// PENGUKURAN (baru)
Route::get('/pengukuran', [PengukuranController::class, 'index'])->name('pengukuran.index')->middleware('auth');
Route::get('/pengukuran/create', [PengukuranController::class, 'create'])->name('pengukuran.create')->middleware('auth');
Route::post('/pengukuran', [PengukuranController::class, 'store'])->name('pengukuran.store')->middleware('auth');
Route::get('/pengukuran/{id}/edit', [PengukuranController::class, 'edit'])->name('pengukuran.edit')->middleware('auth');
Route::put('/pengukuran/{id}', [PengukuranController::class, 'update'])->name('pengukuran.update')->middleware('auth');
Route::delete('/pengukuran/{id}', [PengukuranController::class, 'destroy'])->name('pengukuran.destroy')->middleware('auth');

// PREDIKSI GIZI (ML Integration)
Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi.index')->middleware('auth');
Route::post('/prediksi/calculate', [PrediksiController::class, 'calculate'])->name('prediksi.calculate')->middleware('auth');
Route::get('/prediksi/rekap', [PrediksiController::class, 'rekap'])->name('prediksi.rekap')->middleware('auth');
Route::get('/prediksi/balita/{id}', [PrediksiController::class, 'getBalitaData'])->name('prediksi.balita')->middleware('auth');
Route::get('/prediksi/{id}', [PrediksiController::class, 'show'])->name('prediksi.show')->middleware('auth');

// USER MANAGEMENT
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('auth');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');

// LAPORAN
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index')->middleware('auth');
Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print')->middleware('auth');
Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export')->middleware('auth');
