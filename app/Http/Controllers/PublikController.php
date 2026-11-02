<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\SettingsKunjungan;
use Illuminate\Http\Request;

class PublikController extends Controller
{
    /** Jadwal kunjungan yang masih dibuka, dengan pencarian dan filter. */
    public function jadwal(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $jabatan = $request->query('jabatan');
        $cari = $request->query('cari');

        $daftar = SettingsKunjungan::with([
                'jabatanPenduduk.jabatan',
                'jabatanPenduduk.penduduk',
                'jabatanPenduduk.settingsKegiatan',
            ])
            ->aktif()
            ->mendatang()
            ->whereHas('jabatanPenduduk', fn ($q) => $q->aktif())
            ->when($tanggal, fn ($q) => $q->whereDate('tanggal', $tanggal))
            ->when($jabatan, fn ($q) => $q->whereHas('jabatanPenduduk', fn ($w) => $w->where('id_jabatan', $jabatan)))
            ->when($cari, fn ($q) => $q->whereHas('jabatanPenduduk.penduduk', fn ($w) => $w->where('nama_penduduk', 'like', "%{$cari}%")))
            ->orderBy('tanggal')
            ->orderBy('jam_aktif')
            ->paginate(10)
            ->withQueryString();

        $daftarJabatan = Jabatan::orderBy('nama_jabatan')->get();

        return view('publik.jadwal', compact('daftar', 'daftarJabatan', 'tanggal', 'jabatan', 'cari'));
    }

    /** Struktur jabatan: hanya nama jabatan dan nama pemegangnya (data pribadi tidak ditampilkan). */
    public function struktur()
    {
        $daftar = Jabatan::with(['jabatanPenduduk' => fn ($q) => $q->aktif()->with('penduduk')])
            ->orderBy('nama_jabatan')
            ->get();

        return view('publik.struktur', compact('daftar'));
    }
}
