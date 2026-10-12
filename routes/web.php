<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE SEMENTARA (FRONT-END) — TODO(backend)
|--------------------------------------------------------------------------
| ⚠️ PERHATIAN UNTUK BACK-END (Masidah):
| Blok ini adalah route SEMENTARA milik Front-end, semata-mata agar tampilan
| bisa dibuka & diuji di browser sebelum API siap.
|
| Silakan GANTI/HAPUS dengan route + controller asli Anda.
| Halaman-halaman ini menampilkan view statis; data dinamisnya diambil
| lewat JavaScript (fetch) dari API sesuai openapi.yaml.
|
| Front-end TIDAK menyentuh app/, database/, atau logika backend.
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('welcome');

Route::view('/beranda', 'beranda')->name('beranda');
Route::view('/kalkulator', 'kalkulator')->name('kalkulator');
Route::view('/direktori', 'direktori')->name('direktori');
Route::view('/panduan', 'panduan')->name('panduan');

// Autentikasi — tampilan (proses login/daftar ditangani API via JavaScript)
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// Dashboard — tampilan; role ditentukan dari data API sesudah login
Route::view('/dashboard', 'dashboard.index')->name('dashboard');
Route::view('/dashboard/locations', 'dashboard.locations')->name('dashboard.locations');
Route::view('/dashboard/beras', 'dashboard.beras')->name('dashboard.beras');
Route::view('/dashboard/users', 'dashboard.users')->name('dashboard.users');
Route::view('/dashboard/user', 'dashboard.user')->name('dashboard.user');