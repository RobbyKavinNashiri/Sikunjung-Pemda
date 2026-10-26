<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Kunjungan;
use App\Models\Pemohon;
use App\Models\Penduduk;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'jumlahJabatan'  => Jabatan::count(),
            'jumlahPenduduk' => Penduduk::count(),
            'jumlahPemohon'  => Pemohon::count(),
            'jumlahKunjungan' => Kunjungan::count(),
            'menunggu'       => Kunjungan::whereNull('konfrimasi_admin')->count(),
        ]);
    }
}