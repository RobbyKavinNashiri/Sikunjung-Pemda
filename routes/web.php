<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JabatanPendudukController;
use App\Http\Controllers\Admin\KunjunganController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\SettingsKegiatanController;
use App\Http\Controllers\Admin\SettingsKunjunganController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pemohon\PengajuanController;
use App\Http\Controllers\Pemohon\PengajuanUbahController;
use App\Http\Controllers\Penduduk\DashboardController as PendudukDashboardController;
use App\Http\Controllers\Penduduk\JadwalController as PendudukJadwalController;
use App\Http\Controllers\Penduduk\KegiatanController as PendudukKegiatanController;
use App\Http\Controllers\Penduduk\KunjunganController as PendudukKunjunganController;
use App\Http\Controllers\PublikController;
use Illuminate\Support\Facades\Route;

// Parameter id harus berupa angka. Kalau bukan angka, hasilnya 404 (bukan error 500).
Route::pattern('kunjungan', '[0-9]+');
Route::pattern('kegiatan', '[0-9]+');

// ---------- Halaman publik (tanpa login) ----------
Route::get('/', fn () => view('beranda'))->name('beranda');
Route::get('/jadwal', [PublikController::class, 'jadwal'])->name('publik.jadwal');
Route::get('/struktur', [PublikController::class, 'struktur'])->name('publik.struktur');

// ---------- Login, daftar, logout ----------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar', [AuthController::class, 'register'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- Area Admin ----------
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

// ---------- Area Penduduk (pejabat) ----------
Route::middleware('role:penduduk')->prefix('penduduk')->name('penduduk.')->group(function () {
    Route::get('/dashboard', [PendudukDashboardController::class, 'index'])->name('dashboard');
    Route::resource('kunjungan', PendudukKunjunganController::class)->only(['index', 'show', 'update']);
    Route::get('/jadwal', [PendudukJadwalController::class, 'index'])->name('jadwal.index');
    Route::resource('kegiatan', PendudukKegiatanController::class)->except('show');
});

// ---------- Area Pemohon ----------
Route::middleware('role:pemohon')->prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('/dashboard', [PengajuanController::class, 'index'])->name('dashboard');
    Route::get('/pengajuan/buat', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');

    // ubah dan hapus selama pengajuan belum diproses
    Route::get('/pengajuan/{kunjungan}/ubah', [PengajuanUbahController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{kunjungan}', [PengajuanUbahController::class, 'update'])->name('pengajuan.update');
    Route::delete('/pengajuan/{kunjungan}', [PengajuanUbahController::class, 'destroy'])->name('pengajuan.destroy');
});
