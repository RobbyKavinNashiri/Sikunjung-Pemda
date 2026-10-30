<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JabatanPendudukController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\SettingsKegiatanController;
use App\Http\Controllers\Admin\SettingsKunjunganController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KunjunganController;
// Halaman awal
Route::get('/', fn () => view('beranda'))->name('beranda');

// Login, daftar, logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar', [AuthController::class, 'register'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Admin
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kunjungan', KunjunganController::class)->only(['index', 'show', 'update']);
    Route::resource('jabatan', JabatanController::class)->except('show');
    Route::resource('penduduk', PendudukController::class)->except('show');

    Route::resource('jabatan-penduduk', JabatanPendudukController::class)
        ->except('show')
        ->parameters(['jabatan-penduduk' => 'jabatanPenduduk']);

    Route::resource('settings-kunjungan', SettingsKunjunganController::class)
        ->except('show')
        ->parameters(['settings-kunjungan' => 'settingsKunjungan']);

    Route::resource('settings-kegiatan', SettingsKegiatanController::class)
        ->except('show')
        ->parameters(['settings-kegiatan' => 'settingsKegiatan']);
});

   // Area Penduduk
   
Route::middleware('role:penduduk')->prefix('penduduk')->name('penduduk.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Penduduk\KunjunganController::class, 'index'])->name('dashboard');
    Route::resource('kunjungan', App\Http\Controllers\Penduduk\KunjunganController::class)->only(['index', 'show', 'update']);
    Route::resource('kegiatan', App\Http\Controllers\Penduduk\KegiatanController::class);
});
// Area Pemohon
// Area Pemohon
// Area Pemohon
Route::middleware('role:pemohon')->prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Pemohon\PengajuanController::class, 'index'])->name('dashboard');
    Route::get('/pengajuan/buat', [App\Http\Controllers\Pemohon\PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [App\Http\Controllers\Pemohon\PengajuanController::class, 'store'])->name('pengajuan.store');
});
