<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JabatanPenduduk;
use App\Models\SettingsKegiatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsKegiatanController extends Controller
{
    public function index()
    {
        $daftar = SettingsKegiatan::with(['jabatanPenduduk.jabatan', 'jabatanPenduduk.penduduk'])
            ->orderByDesc('tanggal_awal')
            ->paginate(10);

        return view('admin.settings_kegiatan.index', compact('daftar'));
    }

    public function create()
    {
        return view('admin.settings_kegiatan.create', $this->pilihan());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan());

        SettingsKegiatan::create($data);

        return redirect()->route('admin.settings-kegiatan.index')
            ->with('sukses', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(SettingsKegiatan $settingsKegiatan)
    {
        return view('admin.settings_kegiatan.edit', array_merge(
            $this->pilihan(),
            ['item' => $settingsKegiatan]
        ));
    }

    public function update(Request $request, SettingsKegiatan $settingsKegiatan)
    {
        $data = $request->validate($this->aturan(), $this->pesan());

        $settingsKegiatan->update($data);

        return redirect()->route('admin.settings-kegiatan.index')
            ->with('sukses', 'Kegiatan berhasil diubah.');
    }

    public function destroy(SettingsKegiatan $settingsKegiatan)
    {
        $settingsKegiatan->delete();

        return redirect()->route('admin.settings-kegiatan.index')
            ->with('sukses', 'Kegiatan berhasil dihapus.');
    }

    private function pilihan(): array
    {
        $daftarJp = JabatanPenduduk::with(['jabatan', 'penduduk'])->get()
            ->sortBy(fn ($jp) => $jp->jabatan?->nama_jabatan)
            ->values();

        return ['daftarJp' => $daftarJp];
    }

    private function aturan(): array
    {
        return [
            'id_jabatan_penduduk' => ['required', Rule::exists('jabatan_penduduk', 'id_jabatan_penduduk')],
            'tanggal_awal' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date', 'after_or_equal:tanggal_awal'],
            'kegiatan' => ['required', 'string', 'max:255'],
        ];
    }

    private function pesan(): array
    {
        return [
            'id_jabatan_penduduk.required' => 'Pejabat wajib dipilih.',
            'id_jabatan_penduduk.exists' => 'Pejabat tidak ditemukan.',
            'tanggal_awal.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_awal.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_akhir.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_akhir.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_akhir.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'kegiatan.max' => 'Nama kegiatan maksimal 255 karakter.',
        ];
    }
}
