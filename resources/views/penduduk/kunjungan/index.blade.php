@extends('layouts.app')

@section('title', 'Pengajuan Kunjungan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Pengajuan Kunjungan Untuk Saya</h3>
    </div>

    <form method="GET" action="{{ route('penduduk.kunjungan.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">Semua pengajuan</option>
                <option value="belum" @selected($status === 'belum')>Belum saya putuskan</option>
                <option value="setuju" @selected($status === 'setuju')>Sudah saya setujui</option>
                <option value="tolak" @selected($status === 'tolak')>Sudah saya tolak</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
            @if ($status)
                <a href="{{ route('penduduk.kunjungan.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Pemohon</th>
                        <th>Waktu Kunjungan</th>
                        <th>Tujuan</th>
                        <th>Keputusan Saya</th>
                        <th>Status Akhir</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $k)
                        <tr>
                            <td>{{ $daftar->firstItem() + $loop->index }}</td>
                            <td>
                                {{ $k->pemohon?->nama }}
                                <div class="small text-muted">{{ $k->pemohon?->telepon }}</div>
                            </td>
                            <td>{{ $k->tanggal_waktu->format('d-m-Y H:i') }}</td>
                            <td>{{ $k->tujuannya }}</td>
                            <td>
                                @if ($k->konfrimasi_penduduk === 'Y')
                                    <span class="badge bg-success">Setuju</span>
                                @elseif ($k->konfrimasi_penduduk === 'T')
                                    <span class="badge bg-danger">Tolak</span>
                                @else
                                    <span class="badge bg-secondary">Belum diputuskan</span>
                                @endif
                            </td>
                            <td>
                                @if ($k->status === 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($k->status === 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('penduduk.kunjungan.show', $k->id_kunjungan) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada pengajuan yang ditujukan kepada Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection
