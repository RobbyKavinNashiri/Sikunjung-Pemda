@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Pemohon</h2>
        <a href="{{ route('pemohon.pengajuan.create') }}" class="btn btn-primary">+ Buat Pengajuan Kunjungan</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Riwayat Pengajuan Kunjungan</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuan as $index => $item)
                        @php
                            if ($item->konfrimasi_admin === 'T' || $item->konfrimasi_penduduk === 'T') {
                                $status = 'ditolak';
                            } elseif ($item->konfrimasi_admin === 'Y' && $item->konfrimasi_penduduk === 'Y') {
                                $status = 'disetujui';
                            } else {
                                $status = 'menunggu';
                            }
                        @endphp
                        <tr>
                            <td>{{ $pengajuan->firstItem() + $index }}</td>
                            <td>{{ $item->tanggal_waktu->translatedFormat('d F Y') }}</td>
                            <td>{{ $item->tanggal_waktu->format('H:i') }}</td>
                            <td>{{ $item->tujuannya }}</td>
                            <td>
                                @if ($status === 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($status === 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->catatan_admin)
                                    <div><small class="text-muted">Admin:</small> {{ $item->catatan_admin }}</div>
                                @endif
                                @if ($item->catatan_penduduk)
                                    <div><small class="text-muted">Pejabat:</small> {{ $item->catatan_penduduk }}</div>
                                @endif
                                @if (!$item->catatan_admin && !$item->catatan_penduduk)
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-muted">Belum ada pengajuan kunjungan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $pengajuan->links() }}</div>
</div>
@endsection