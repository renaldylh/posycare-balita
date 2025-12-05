<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\PengukuranController;
use App\Http\Controllers\StatusGiziController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;

// Landing Page (Public)
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/predict', [LandingController::class, 'predict'])->name('predict');
Route::post('/predict/calculate', [LandingController::class, 'calculate'])->name('predict.calculate');

// Halaman login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (hanya untuk user yang login)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Data Balita
Route::get('/balita', [App\Http\Controllers\BalitaController::class, 'index'])->name('balita.index')->middleware('auth');
Route::get('/balita/{id}', [App\Http\Controllers\BalitaController::class, 'show'])->name('balita.show')->middleware('auth');

// DATASET (baru)
Route::get('/dataset', [DatasetController::class, 'index'])->name('dataset.index')->middleware('auth');

// PENGUKURAN (baru)
Route::get('/pengukuran', [PengukuranController::class, 'index'])->name('pengukuran.index')->middleware('auth');
Route::get('/pengukuran/create', [PengukuranController::class, 'create'])->name('pengukuran.create')->middleware('auth');
Route::post('/pengukuran', [PengukuranController::class, 'store'])->name('pengukuran.store')->middleware('auth');
Route::get('/pengukuran/{id}/edit', [PengukuranController::class, 'edit'])->name('pengukuran.edit')->middleware('auth');
Route::put('/pengukuran/{id}', [PengukuranController::class, 'update'])->name('pengukuran.update')->middleware('auth');
Route::delete('/pengukuran/{id}', [PengukuranController::class, 'destroy'])->name('pengukuran.destroy')->middleware('auth');

// USER MANAGEMENT
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('auth');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');
