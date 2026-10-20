<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Sementara: halaman awal diarahkan ke login
Route::get('/', fn () => view('beranda'))->name('beranda');

// Login, daftar, logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar', [AuthController::class, 'register'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Admin
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('sementara', ['judul' => 'Dashboard Admin']))->name('dashboard');
});

// Area Penduduk
Route::middleware('role:penduduk')->prefix('penduduk')->name('penduduk.')->group(function () {
    Route::get('/dashboard', fn () => view('sementara', ['judul' => 'Dashboard Penduduk']))->name('dashboard');
});

// Area Pemohon
Route::middleware('role:pemohon')->prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('/dashboard', fn () => view('sementara', ['judul' => 'Dashboard Pemohon']))->name('dashboard');
});