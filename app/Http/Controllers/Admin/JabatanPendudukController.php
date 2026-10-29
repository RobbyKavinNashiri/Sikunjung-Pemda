<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\JabatanPenduduk;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JabatanPendudukController extends Controller
{
    public function index()
    {
        $daftar = JabatanPenduduk::with(['jabatan', 'penduduk'])
            ->orderByDesc('id_jabatan_penduduk')
            ->paginate(10);

        return view('admin.jabatan_penduduk.index', compact('daftar'));
    }

    public function create()
    {
        return view('admin.jabatan_penduduk.create', $this->pilihan());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan($request), $this->pesan());

        JabatanPenduduk::create($data);

        return redirect()->route('admin.jabatan-penduduk.index')
            ->with('sukses', 'Jabatan pegawai berhasil ditambahkan.');
    }

    public function edit(JabatanPenduduk $jabatanPenduduk)
    {
        return view('admin.jabatan_penduduk.edit', array_merge(
            $this->pilihan(),
            ['jp' => $jabatanPenduduk]
        ));
    }

    public function update(Request $request, JabatanPenduduk $jabatanPenduduk)
    {
        $data = $request->validate($this->aturan($request, $jabatanPenduduk), $this->pesan());

        $jabatanPenduduk->update($data);

        return redirect()->route('admin.jabatan-penduduk.index')
            ->with('sukses', 'Jabatan pegawai berhasil diubah.');
    }

    public function destroy(JabatanPenduduk $jabatanPenduduk)
    {
        if ($jabatanPenduduk->settingsKunjungan()->exists() || $jabatanPenduduk->settingsKegiatan()->exists()) {
            return redirect()->route('admin.jabatan-penduduk.index')
                ->with('error', 'Data tidak bisa dihapus karena sudah dipakai di jadwal kunjungan atau kegiatan. Ubah statusnya menjadi Tidak aktif.');
        }

        $jabatanPenduduk->delete();

        return redirect()->route('admin.jabatan-penduduk.index')
            ->with('sukses', 'Jabatan pegawai berhasil dihapus.');
    }

    private function pilihan(): array
    {
        return [
            'daftarJabatan'  => Jabatan::orderBy('nama_jabatan')->get(),
            'daftarPenduduk' => Penduduk::orderBy('nama_penduduk')->get(),
        ];
    }

    private function aturan(Request $request, ?JabatanPenduduk $jp = null): array
    {
        return [
            'id_jabatan' => ['required', Rule::exists('jabatan', 'id_jabatan')],
            'id_penduduk' => [
                'required',
                Rule::exists('penduduk', 'id_penduduk'),
                // satu orang tidak boleh punya jabatan yang sama dua kali
                Rule::unique('jabatan_penduduk', 'id_penduduk')
                    ->where(fn ($q) => $q->where('id_jabatan', $request->input('id_jabatan')))
                    ->ignore($jp?->id_jabatan_penduduk, 'id_jabatan_penduduk'),
            ],
            'status' => ['required', Rule::in(['Y', 'T'])],
        ];
    }

    private function pesan(): array
    {
        return [
            'id_jabatan.required' => 'Jabatan wajib dipilih.',
            'id_jabatan.exists' => 'Jabatan tidak ditemukan.',
            'id_penduduk.required' => 'Pegawai wajib dipilih.',
            'id_penduduk.exists' => 'Pegawai tidak ditemukan.',
            'id_penduduk.unique' => 'Pegawai ini sudah memegang jabatan tersebut.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}