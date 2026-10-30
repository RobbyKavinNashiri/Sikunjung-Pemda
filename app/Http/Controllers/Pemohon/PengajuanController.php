<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\SettingsKunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PengajuanController extends Controller
{
    public function index()
    {
        $idPemohon = Auth::guard('pemohon')->id();

        $pengajuan = Kunjungan::where('id_pemohon', $idPemohon)
            ->orderBy('tanggal_waktu', 'desc')
            ->paginate(10);

        return view('pemohon.dashboard', compact('pengajuan'));
    }

    public function create()
    {
        // Jadwal yang masih aktif (status Y) dan belum lewat,
        // lengkap dengan nama pejabat dan jabatannya.
        $jadwal = DB::table('settings_kunjungan as s')
            ->join('jabatan_penduduk as jp', 'jp.id_jabatan_penduduk', '=', 's.id_jabatan_penduduk')
            ->join('penduduk as p', 'p.id_penduduk', '=', 'jp.id_penduduk')
            ->join('jabatan as j', 'j.id_jabatan', '=', 'jp.id_jabatan')
            ->where('s.status', 'Y')
            ->whereDate('s.tanggal', '>=', today())
            ->orderBy('s.tanggal')
            ->orderBy('s.jam_aktif')
            ->select(
                's.id_settings_kunjungan',
                's.tanggal',
                's.jam_aktif',
                's.jam_non_aktif',
                'p.nama_penduduk',
                'j.nama_jabatan'
            )
            ->get();

        return view('pemohon.pengajuan_buat', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_settings_kunjungan' => 'required|exists:settings_kunjungan,id_settings_kunjungan',
            'jam'                   => 'required|date_format:H:i',
            'tujuannya'             => 'required|string|max:255',
        ], [
            'id_settings_kunjungan.required' => 'Jadwal kunjungan wajib dipilih.',
            'id_settings_kunjungan.exists'   => 'Jadwal yang dipilih tidak ditemukan.',
            'jam.required'                   => 'Jam kunjungan wajib diisi.',
            'jam.date_format'                => 'Format jam tidak valid.',
            'tujuannya.required'             => 'Tujuan kunjungan wajib diisi.',
            'tujuannya.max'                  => 'Tujuan kunjungan maksimal 255 karakter.',
        ]);

        $jadwal = SettingsKunjungan::findOrFail($request->id_settings_kunjungan);

          if ($jadwal->status !== 'Y' || Carbon::parse($jadwal->tanggal)->lt(today())) {
            return back()->withErrors(['id_settings_kunjungan' => 'Jadwal ini sudah tidak tersedia.'])->withInput();
        }

        $aktif    = substr($jadwal->jam_aktif, 0, 5);
        $nonAktif = substr($jadwal->jam_non_aktif, 0, 5);

        if ($request->jam < $aktif || $request->jam > $nonAktif) {
            return back()->withErrors(['jam' => "Jam kunjungan harus antara $aktif dan $nonAktif."])->withInput();
        }

        Kunjungan::create([
            'id_settings_kunjungan' => $jadwal->id_settings_kunjungan,
            'id_pemohon'            => Auth::guard('pemohon')->id(),
            'tujuannya'             => $request->tujuannya,
            'tanggal_waktu'         => Carbon::parse($jadwal->tanggal)->format('Y-m-d') . ' ' . $request->jam . ':00',
        ]);

        return redirect()->route('pemohon.dashboard')
            ->with('success', 'Pengajuan kunjungan berhasil dikirim!');
    }
}