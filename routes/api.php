<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalitaController;

Route::get('/balita/{id}', [BalitaController::class, 'getBalitaData']);
