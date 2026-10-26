@extends('layouts.app')

@section('title', 'Data Penduduk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Data Penduduk</h3>
        <a href="{{ route('admin.penduduk.create') }}" class="btn btn-primary">+ Tambah Penduduk</a>
    </div>

    <form method="GET" action="{{ route('admin.penduduk.index') }}" class="row g-2 mb-3">
        <div class="col-md-5">
            <input type="text" name="cari" value="{{ $cari }}" class="form-control"
                   placeholder="Cari nama, username, atau NIK">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
            @if ($cari)
                <a href="{{ route('admin.penduduk.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>NIK</th>
                        <th>JK</th>
                        <th>Status</th>
                        <th style="width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $p)
                        <tr>
                            <td>{{ $daftar->firstItem() + $loop->index }}</td>
                            <td>{{ $p->nama_penduduk }}</td>
                            <td>{{ $p->username }}</td>
                            <td>{{ $p->nik }}</td>
                            <td>{{ $p->jenis_kelamin }}</td>
                            <td>
                                <span class="badge {{ $p->status === 'Admin' ? 'bg-danger' : 'bg-secondary' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.penduduk.edit', $p) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <form method="POST" action="{{ route('admin.penduduk.destroy', $p) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus penduduk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data penduduk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection