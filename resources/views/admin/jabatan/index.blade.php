@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Data Jabatan</h3>
        <a href="{{ route('admin.jabatan.create') }}" class="btn btn-primary">+ Tambah Jabatan</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Nama Jabatan</th>
                        <th style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $jabatan)
                        <tr>
                            <td>{{ $daftar->firstItem() + $loop->index }}</td>
                            <td>{{ $jabatan->nama_jabatan }}</td>
                            <td>
                                <a href="{{ route('admin.jabatan.edit', $jabatan) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <form method="POST" action="{{ route('admin.jabatan.destroy', $jabatan) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data jabatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection