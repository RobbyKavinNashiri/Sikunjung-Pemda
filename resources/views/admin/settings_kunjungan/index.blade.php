@extends('layouts.app')

@section('title', 'Jadwal Kunjungan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Jadwal Kunjungan</h3>
        <a href="{{ route('admin.settings-kunjungan.create') }}" class="btn btn-primary">+ Tambah Jadwal</a>
    </div>

    <form method="GET" action="{{ route('admin.settings-kunjungan.index') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua status</option>
                <option value="Y" @selected($status === 'Y')>Aktif</option>
                <option value="T" @selected($status === 'T')>Tidak aktif</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
            @if ($tanggal || $status)
                <a href="{{ route('admin.settings-kunjungan.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Pejabat</th>
                        <th>Status</th>
                        <th style="width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $s)
                        <tr>
                            <td>{{ $daftar->firstItem() + $loop->index }}</td>
                            <td>{{ $s->tanggal->format('d-m-Y') }}</td>
                            <td>{{ substr($s->jam_aktif, 0, 5) }} - {{ substr($s->jam_non_aktif, 0, 5) }}</td>
                            <td>
                                {{ $s->jabatanPenduduk?->jabatan?->nama_jabatan }}
                                <div class="small text-muted">{{ $s->jabatanPenduduk?->penduduk?->nama_penduduk }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $s->status === 'Y' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $s->status === 'Y' ? 'Aktif' : 'Tidak aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.settings-kunjungan.edit', $s) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <form method="POST" action="{{ route('admin.settings-kunjungan.destroy', $s) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada jadwal kunjungan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection
