<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KalkulatorController;
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
