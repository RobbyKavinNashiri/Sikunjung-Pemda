<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    private array $relasi = [
        'pemohon',
        'settingsKunjungan.jabatanPenduduk.jabatan',
        'settingsKunjungan.jabatanPenduduk.penduduk',
    ];

    public function index(Request $request)
    {
        $status = $request->query('status');

        $daftar = Kunjungan::with($this->relasi)
            ->when($status === 'ditolak', fn ($q) => $q->where(function ($w) {
                $w->where('konfrimasi_admin', 'T')->orWhere('konfrimasi_penduduk', 'T');
            }))
            ->when($status === 'disetujui', fn ($q) => $q
                ->where('konfrimasi_admin', 'Y')
                ->where('konfrimasi_penduduk', 'Y'))
            ->when($status === 'menunggu', fn ($q) => $q
                ->where(fn ($w) => $w->whereNull('konfrimasi_admin')->orWhere('konfrimasi_admin', 'Y'))
                ->where(fn ($w) => $w->whereNull('konfrimasi_penduduk')->orWhere('konfrimasi_penduduk', 'Y'))
                ->where(fn ($w) => $w->whereNull('konfrimasi_admin')->orWhereNull('konfrimasi_penduduk')))
            ->orderByDesc('tanggal_waktu')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kunjungan.index', compact('daftar', 'status'));
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load($this->relasi);

        return view('admin.kunjungan.show', compact('kunjungan'));
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $data = $request->validate([
            'keputusan'     => 'required|in:Y,T',
            'catatan_admin' => 'required_if:keputusan,T|nullable|string|max:255',
        ], [
            'keputusan.required'         => 'Pilih Setujui atau Tolak.',
            'catatan_admin.required_if'  => 'Catatan wajib diisi saat menolak pengajuan.',
            'catatan_admin.max'          => 'Catatan maksimal 255 karakter.',
        ]);

        $kunjungan->update([
            'konfrimasi_admin'    => $data['keputusan'],
            'tanggal_waktu_admin' => now(),
            'catatan_admin'       => $data['catatan_admin'] ?? null,
        ]);

        $pesan = $data['keputusan'] === 'Y'
            ? 'Pengajuan berhasil disetujui.'
            : 'Pengajuan berhasil ditolak.';

        return redirect()->route('admin.kunjungan.show', $kunjungan)->with('success', $pesan);
    }
}