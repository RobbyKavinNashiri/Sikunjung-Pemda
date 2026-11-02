<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\JabatanPenduduk;
use App\Models\Kunjungan;
use App\Models\SettingsKegiatan;
use App\Models\SettingsKunjungan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $id = Auth::guard('penduduk')->id();
        $idJabatanSaya = JabatanPenduduk::milikPenduduk($id)->pluck('id_jabatan_penduduk');

        $statistik = [
            'belum' => Kunjungan::untukPejabat($id)->whereNull('konfrimasi_penduduk')->count(),
            'setuju' => Kunjungan::untukPejabat($id)->where('konfrimasi_penduduk', 'Y')->count(),
            'tolak' => Kunjungan::untukPejabat($id)->where('konfrimasi_penduduk', 'T')->count(),
            'jadwal' => SettingsKunjungan::milikPejabat($id)->aktif()->mendatang()->count(),
            'kegiatan' => SettingsKegiatan::whereIn('id_jabatan_penduduk', $idJabatanSaya)
                ->whereDate('tanggal_akhir', '>=', now()->toDateString())
                ->count(),
        ];

        $menunggu = Kunjungan::with('pemohon')
            ->untukPejabat($id)
            ->whereNull('konfrimasi_penduduk')
            ->orderBy('tanggal_waktu')
            ->limit(5)
            ->get();

        $jabatanSaya = JabatanPenduduk::with('jabatan')->milikPenduduk($id)->aktif()->get();

        return view('penduduk.dashboard', compact('statistik', 'menunggu', 'jabatanSaya'));
    }
}
