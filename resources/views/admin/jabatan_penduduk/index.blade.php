@extends('layouts.app')

@section('title', 'Jabatan Pegawai')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Jabatan Pegawai</h3>
        <a href="{{ route('admin.jabatan-penduduk.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Jabatan</th>
                        <th>Pegawai</th>
                        <th>Status</th>
                        <th style="width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $jp)
                        <tr>
                            <td>{{ $daftar->firstItem() + $loop->index }}</td>
                            <td>{{ $jp->jabatan?->nama_jabatan }}</td>
                            <td>{{ $jp->penduduk?->nama_penduduk }}</td>
                            <td>
                                <span class="badge {{ $jp->status === 'Y' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $jp->status === 'Y' ? 'Aktif' : 'Tidak aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.jabatan-penduduk.edit', $jp) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <form method="POST" action="{{ route('admin.jabatan-penduduk.destroy', $jp) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection