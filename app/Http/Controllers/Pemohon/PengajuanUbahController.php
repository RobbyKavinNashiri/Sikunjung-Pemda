<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\SettingsKunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class PengajuanUbahController extends Controller
{
    /** Ambil pengajuan milik pemohon yang sedang login (milik orang lain = 404). */
    private function milikSaya(int $id): Kunjungan
    {
        return Kunjungan::with([
                'settingsKunjungan.jabatanPenduduk.jabatan',
                'settingsKunjungan.jabatanPenduduk.penduduk',
            ])
            ->milikPemohon(Auth::guard('pemohon')->id())
            ->where('id_kunjungan', $id)
            ->firstOrFail();
    }

    /** Pilihan jadwal: yang masih dibuka, ditambah jadwal pengajuan ini sendiri. */
    private function daftarJadwal(Kunjungan $item)
    {
        return SettingsKunjungan::with(['jabatanPenduduk.jabatan', 'jabatanPenduduk.penduduk'])
            ->where(function ($q) use ($item) {
                $q->where(fn ($w) => $w->aktif()->mendatang())
                  ->orWhere('id_settings_kunjungan', $item->id_settings_kunjungan);
            })
            ->orderBy('tanggal')
            ->orderBy('jam_aktif')
            ->get();
    }

    private function tolakJikaSudahDiproses(Kunjungan $item)
    {
        if (! $item->bisaDiubah()) {
            return redirect()->route('pemohon.dashboard')
                ->with('peringatan', 'Pengajuan yang sudah diproses tidak dapat diubah atau dihapus.');
        }

        return null;
    }

    public function edit(int $kunjungan)
    {
        $item = $this->milikSaya($kunjungan);

        if ($tolak = $this->tolakJikaSudahDiproses($item)) {
            return $tolak;
        }

        return view('pemohon.ubah', [
            'item' => $item,
            'daftarJadwal' => $this->daftarJadwal($item),
        ]);
    }

    public function update(Request $request, int $kunjungan)
    {
        $item = $this->milikSaya($kunjungan);

        if ($tolak = $this->tolakJikaSudahDiproses($item)) {
            return $tolak;
        }

        $data = $request->validate([
            'id_settings_kunjungan' => [
                'required',
                Rule::exists('settings_kunjungan', 'id_settings_kunjungan')->where('status', 'Y'),
            ],
            'tanggal' => ['required', 'date_format:Y-m-d'],
            'jam' => ['required', 'date_format:H:i'],
            'tujuannya' => ['required', 'string', 'max:255'],
        ], [
            'id_settings_kunjungan.required' => 'Jadwal wajib dipilih.',
            'id_settings_kunjungan.exists' => 'Jadwal tidak tersedia.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date_format' => 'Format tanggal tidak valid.',
            'jam.required' => 'Jam wajib diisi.',
            'jam.date_format' => 'Format jam tidak valid.',
            'tujuannya.required' => 'Tujuan kunjungan wajib diisi.',
            'tujuannya.max' => 'Tujuan maksimal 255 karakter.',
        ]);

                $jadwal = SettingsKunjungan::findOrFail($data['id_settings_kunjungan']);
        $tanggalJadwal = Carbon::parse($jadwal->tanggal);

        if ($tanggalJadwal->isBefore(today())) {
            throw ValidationException::withMessages([
                'id_settings_kunjungan' => 'Jadwal tersebut sudah lewat.',
            ]);
        }

        if ($tanggalJadwal->format('Y-m-d') !== $data['tanggal']) {
            throw ValidationException::withMessages([
                'tanggal' => 'Tanggal harus sama dengan tanggal jadwal ('.$tanggalJadwal->format('d-m-Y').').',
            ]);
        }

        $item->update([
            'id_settings_kunjungan' => $jadwal->id_settings_kunjungan,
            'tanggal_waktu' => $data['tanggal'].' '.$data['jam'].':00',
            'tujuannya' => $data['tujuannya'],
        ]);

        return redirect()->route('pemohon.dashboard')
            ->with('success', 'Pengajuan berhasil diubah.');
    }

    public function destroy(int $kunjungan)
    {
        $item = $this->milikSaya($kunjungan);

        if ($tolak = $this->tolakJikaSudahDiproses($item)) {
            return $tolak;
        }

        $item->delete();

        return redirect()->route('pemohon.dashboard')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }
}
