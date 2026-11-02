<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\JabatanPenduduk;
use App\Models\SettingsKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KegiatanController extends Controller
{
    private function idSaya(): int
    {
        return (int) Auth::guard('penduduk')->id();
    }

    /** Semua kegiatan milik pejabat yang login (lewat jabatan_penduduk miliknya). */
    private function milikSaya()
    {
        $idJabatanSaya = JabatanPenduduk::milikPenduduk($this->idSaya())->pluck('id_jabatan_penduduk');

        return SettingsKegiatan::with('jabatanPenduduk.jabatan')
            ->whereIn('id_jabatan_penduduk', $idJabatanSaya);
    }

    private function pilihanJabatan()
    {
        return JabatanPenduduk::with('jabatan')->milikPenduduk($this->idSaya())->aktif()->get();
    }

    public function index()
    {
        $daftar = $this->milikSaya()->orderByDesc('tanggal_awal')->paginate(10);

        return view('penduduk.kegiatan.index', compact('daftar'));
    }

    public function create()
    {
        return view('penduduk.kegiatan.create', ['daftarJp' => $this->pilihanJabatan()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan());

        SettingsKegiatan::create($data);

        return redirect()->route('penduduk.kegiatan.index')
            ->with('sukses', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(int $kegiatan)
    {
        $item = $this->milikSaya()->where('id_settings_kegiatan', $kegiatan)->firstOrFail();

        return view('penduduk.kegiatan.edit', [
            'item' => $item,
            'daftarJp' => $this->pilihanJabatan(),
        ]);
    }

    public function update(Request $request, int $kegiatan)
    {
        $item = $this->milikSaya()->where('id_settings_kegiatan', $kegiatan)->firstOrFail();

        $data = $request->validate($this->aturan(), $this->pesan());

        $item->update($data);

        return redirect()->route('penduduk.kegiatan.index')
            ->with('sukses', 'Kegiatan berhasil diubah.');
    }

    public function destroy(int $kegiatan)
    {
        $item = $this->milikSaya()->where('id_settings_kegiatan', $kegiatan)->firstOrFail();

        $item->delete();

        return redirect()->route('penduduk.kegiatan.index')
            ->with('sukses', 'Kegiatan berhasil dihapus.');
    }

    private function aturan(): array
    {
        return [
            // hanya boleh memakai jabatan aktif milik sendiri
            'id_jabatan_penduduk' => [
                'required',
                Rule::exists('jabatan_penduduk', 'id_jabatan_penduduk')
                    ->where('id_penduduk', $this->idSaya())
                    ->where('status', 'Y'),
            ],
            'tanggal_awal' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date', 'after_or_equal:tanggal_awal'],
            'kegiatan' => ['required', 'string', 'max:255'],
        ];
    }

    private function pesan(): array
    {
        return [
            'id_jabatan_penduduk.required' => 'Jabatan wajib dipilih.',
            'id_jabatan_penduduk.exists' => 'Jabatan tidak valid.',
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
