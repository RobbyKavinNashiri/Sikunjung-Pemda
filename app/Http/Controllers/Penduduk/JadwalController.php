<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\SettingsKunjungan;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /** Jadwal kunjungan milik pejabat yang login. Hanya dilihat; pengaturan dilakukan admin. */
    public function index()
    {
        $daftar = SettingsKunjungan::with('jabatanPenduduk.jabatan')
            ->withCount('kunjungan')
            ->milikPejabat(Auth::guard('penduduk')->id())
            ->orderByDesc('tanggal')
            ->orderBy('jam_aktif')
            ->paginate(10);

        return view('penduduk.jadwal.index', compact('daftar'));
    }
}
