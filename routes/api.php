<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BerasPriceController;
use App\Http\Controllers\Api\KalkulatorController;
use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Semua route di sini HARUS ada padanannya di openapi.yaml (SSOT kontrak).
| Jika endpoint belum ada di kontrak, jangan ditambahkan di sini.
|
*/

// ---- Auth ----
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
});

// ---- Kalkulator (publik, tanpa DB tulis) ----
Route::prefix('kalkulator')->group(function () {
    Route::post('/zakat-fitrah', [KalkulatorController::class, 'zakatFitrah']);
    Route::post('/zakat-mal', [KalkulatorController::class, 'zakatMal']);
});

// ---- Harga Beras ----
Route::get('/beras-price', [BerasPriceController::class, 'show']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::put('/beras-price', [BerasPriceController::class, 'update']);
});

// ---- Direktori Lokasi ----
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/locations/{location}', [LocationController::class, 'show']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/locations', [LocationController::class, 'store']);
    Route::put('/locations/{location}', [LocationController::class, 'update']);
    Route::delete('/locations/{location}', [LocationController::class, 'destroy']);
});
