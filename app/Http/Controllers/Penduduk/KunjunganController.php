<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KunjunganController extends Controller
{
    private array $relasi = [
        'pemohon',
        'settingsKunjungan.jabatanPenduduk.jabatan',
        'settingsKunjungan.jabatanPenduduk.penduduk',
    ];

    /**
     * Query dasar: hanya pengajuan yang ditujukan ke pejabat yang sedang login.
     * Pejabat dikenali dari jadwal (settings_kunjungan) -> jabatan_penduduk -> id_penduduk.
     */
    private function milikSaya()
    {
        $idPenduduk = Auth::guard('penduduk')->id();

        return Kunjungan::with($this->relasi)
            ->whereHas('settingsKunjungan.jabatanPenduduk', fn ($q) => $q->where('id_penduduk', $idPenduduk));
    }

    public function index(Request $request)
    {
        $status = $request->query('status');

        $daftar = $this->milikSaya()
            ->when($status === 'belum', fn ($q) => $q->whereNull('konfrimasi_penduduk'))
            ->when($status === 'setuju', fn ($q) => $q->where('konfrimasi_penduduk', 'Y'))
            ->when($status === 'tolak', fn ($q) => $q->where('konfrimasi_penduduk', 'T'))
            ->orderByDesc('tanggal_waktu')
            ->paginate(10)
            ->withQueryString();

        return view('penduduk.kunjungan.index', compact('daftar', 'status'));
    }

    public function show(int $kunjungan)
    {
        // firstOrFail: pengajuan milik pejabat lain akan menghasilkan 404
        $item = $this->milikSaya()->where('id_kunjungan', $kunjungan)->firstOrFail();

        return view('penduduk.kunjungan.show', ['kunjungan' => $item]);
    }

    public function update(Request $request, int $kunjungan)
    {
        $item = $this->milikSaya()->where('id_kunjungan', $kunjungan)->firstOrFail();

        $data = $request->validate([
            'keputusan'        => ['required', 'in:Y,T'],
            'catatan_penduduk' => ['required_if:keputusan,T', 'nullable', 'string', 'max:255'],
        ], [
            'keputusan.required'              => 'Pilih Setujui atau Tolak.',
            'keputusan.in'                    => 'Pilihan tidak valid.',
            'catatan_penduduk.required_if'    => 'Catatan wajib diisi saat menolak pengajuan.',
            'catatan_penduduk.max'            => 'Catatan maksimal 255 karakter.',
        ]);

        $item->update([
            'konfrimasi_penduduk'    => $data['keputusan'],
            'tanggal_waktu_penduduk' => now(),
            'catatan_penduduk'       => $data['catatan_penduduk'] ?? null,
        ]);

        $pesan = $data['keputusan'] === 'Y'
            ? 'Pengajuan berhasil disetujui.'
            : 'Pengajuan berhasil ditolak.';

        return redirect()
            ->route('penduduk.kunjungan.show', $item->id_kunjungan)
            ->with('sukses', $pesan);
    }
}
