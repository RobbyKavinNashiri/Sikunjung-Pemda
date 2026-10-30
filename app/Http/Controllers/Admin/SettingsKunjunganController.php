<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JabatanPenduduk;
use App\Models\SettingsKunjungan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SettingsKunjunganController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $tanggal = $request->query('tanggal');

        $daftar = SettingsKunjungan::with(['jabatanPenduduk.jabatan', 'jabatanPenduduk.penduduk'])
            ->when(in_array($status, ['Y', 'T'], true), fn ($q) => $q->where('status', $status))
            ->when($tanggal, fn ($q) => $q->whereDate('tanggal', $tanggal))
            ->orderByDesc('tanggal')
            ->orderBy('jam_aktif')
            ->paginate(10)
            ->withQueryString();

        return view('admin.settings_kunjungan.index', compact('daftar', 'status', 'tanggal'));
    }

    public function create()
    {
        return view('admin.settings_kunjungan.create', $this->pilihan());
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);

        SettingsKunjungan::create($data);

        return redirect()->route('admin.settings-kunjungan.index')
            ->with('sukses', 'Jadwal kunjungan berhasil ditambahkan.');
    }

    public function edit(SettingsKunjungan $settingsKunjungan)
    {
        return view('admin.settings_kunjungan.edit', array_merge(
            $this->pilihan(),
            ['item' => $settingsKunjungan]
        ));
    }

    public function update(Request $request, SettingsKunjungan $settingsKunjungan)
    {
        $data = $this->validasi($request, $settingsKunjungan);

        $settingsKunjungan->update($data);

        return redirect()->route('admin.settings-kunjungan.index')
            ->with('sukses', 'Jadwal kunjungan berhasil diubah.');
    }

    public function destroy(SettingsKunjungan $settingsKunjungan)
    {
        if ($settingsKunjungan->kunjungan()->exists()) {
            return redirect()->route('admin.settings-kunjungan.index')
                ->with('error', 'Jadwal tidak bisa dihapus karena sudah ada pengajuan kunjungan. Ubah statusnya menjadi Tidak aktif.');
        }

        $settingsKunjungan->delete();

        return redirect()->route('admin.settings-kunjungan.index')
            ->with('sukses', 'Jadwal kunjungan berhasil dihapus.');
    }

    private function pilihan(): array
    {
        $daftarJp = JabatanPenduduk::with(['jabatan', 'penduduk'])->get()
            ->sortBy(fn ($jp) => $jp->jabatan?->nama_jabatan)
            ->values();

        return ['daftarJp' => $daftarJp];
    }

    private function validasi(Request $request, ?SettingsKunjungan $setting = null): array
    {
        $aturanTanggal = ['required', 'date'];
        if (! $setting) {
            // jadwal baru tidak boleh di masa lalu
            $aturanTanggal[] = 'after_or_equal:today';
        }

        $data = $request->validate([
            'id_jabatan_penduduk' => [
                'required',
                Rule::exists('jabatan_penduduk', 'id_jabatan_penduduk')->where('status', 'Y'),
            ],
            'tanggal' => $aturanTanggal,
            'jam_aktif' => ['required', 'date_format:H:i'],
            'jam_non_aktif' => ['required', 'date_format:H:i', 'after:jam_aktif'],
            'status' => ['required', Rule::in(['Y', 'T'])],
        ], [
            'id_jabatan_penduduk.required' => 'Pejabat wajib dipilih.',
            'id_jabatan_penduduk.exists' => 'Pejabat tidak ditemukan atau tidak aktif.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
            'jam_aktif.required' => 'Jam mulai wajib diisi.',
            'jam_aktif.date_format' => 'Format jam mulai tidak valid.',
            'jam_non_aktif.required' => 'Jam selesai wajib diisi.',
            'jam_non_aktif.date_format' => 'Format jam selesai tidak valid.',
            'jam_non_aktif.after' => 'Jam selesai harus lebih besar dari jam mulai.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        // Jadwal pejabat yang sama pada tanggal yang sama tidak boleh bertumpuk
        $bentrok = SettingsKunjungan::query()
            ->where('id_jabatan_penduduk', $data['id_jabatan_penduduk'])
            ->whereDate('tanggal', $data['tanggal'])
            ->where('jam_aktif', '<', $data['jam_non_aktif'])
            ->where('jam_non_aktif', '>', $data['jam_aktif'])
            ->when($setting, fn ($q) => $q->where('id_settings_kunjungan', '!=', $setting->id_settings_kunjungan))
            ->exists();

        if ($bentrok) {
            throw ValidationException::withMessages([
                'jam_aktif' => 'Jadwal bentrok dengan jadwal lain milik pejabat yang sama pada tanggal tersebut.',
            ]);
        }

        return $data;
    }
}
