@extends('layouts.app')

@section('title', 'Kegiatan Saya')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Kegiatan Saya</h3>
        <a href="{{ route('penduduk.kegiatan.create') }}" class="btn btn-primary">+ Tambah Kegiatan</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Jabatan</th>
                        <th style="width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $k)
                        <tr>
                            <td>{{ $daftar->firstItem() + $loop->index }}</td>
                            <td>
                                {{ $k->tanggal_awal->format('d-m-Y') }}
                                @if (! $k->tanggal_awal->isSameDay($k->tanggal_akhir))
                                    s/d {{ $k->tanggal_akhir->format('d-m-Y') }}
                                @endif
                            </td>
                            <td>{{ $k->kegiatan }}</td>
                            <td>{{ $k->jabatanPenduduk?->jabatan?->nama_jabatan }}</td>
                            <td>
                                <a href="{{ route('penduduk.kegiatan.edit', $k->id_settings_kegiatan) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <form method="POST" action="{{ route('penduduk.kegiatan.destroy', $k->id_settings_kegiatan) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kegiatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection
