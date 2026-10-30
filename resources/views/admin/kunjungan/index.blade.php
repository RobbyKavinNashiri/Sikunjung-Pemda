@extends('layouts.app')

@section('title', 'Pengajuan Kunjungan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Pengajuan Kunjungan</h3>
    </div>

    <form method="GET" action="{{ route('admin.kunjungan.index') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua status</option>
                <option value="menunggu" @selected($status === 'menunggu')>Menunggu</option>
                <option value="disetujui" @selected($status === 'disetujui')>Disetujui</option>
                <option value="ditolak" @selected($status === 'ditolak')>Ditolak</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
            @if ($status)
                <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Waktu Kunjungan</th>
                        <th>Pemohon</th>
                        <th>Pejabat Dituju</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $k)
                        @php $jp = $k->settingsKunjungan?->jabatanPenduduk; @endphp
                        <tr>
                            <td>{{ $daftar->firstItem() + $loop->index }}</td>
                            <td>{{ $k->tanggal_waktu->format('d-m-Y') }}
                                <div class="small text-muted">{{ $k->tanggal_waktu->format('H:i') }}</div>
                            </td>
                            <td>{{ $k->pemohon?->nama }}
                                <div class="small text-muted">{{ $k->pemohon?->telepon }}</div>
                            </td>
                            <td>{{ $jp?->penduduk?->nama_penduduk }}
                                <div class="small text-muted">{{ $jp?->jabatan?->nama_jabatan }}</div>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($k->tujuannya, 40) }}</td>
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
                                <a href="{{ route('admin.kunjungan.show', $k) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pengajuan kunjungan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection