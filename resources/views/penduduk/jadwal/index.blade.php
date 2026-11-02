@extends('layouts.app')

@section('title', 'Jadwal Saya')

@section('content')
    <h3 class="mb-1">Jadwal Kunjungan Saya</h3>
    <p class="text-muted">Jadwal diatur oleh admin. Halaman ini hanya untuk dilihat.</p>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">No</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Jumlah Pengajuan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $s)
                        <tr>
                            <td>{{ $daftar->firstItem() + $loop->index }}</td>
                            <td>{{ $s->tanggal->format('d-m-Y') }}</td>
                            <td>{{ substr($s->jam_aktif, 0, 5) }} - {{ substr($s->jam_non_aktif, 0, 5) }}</td>
                            <td>{{ $s->jabatanPenduduk?->jabatan?->nama_jabatan }}</td>
                            <td>
                                <span class="badge {{ $s->status === 'Y' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $s->status === 'Y' ? 'Aktif' : 'Tidak aktif' }}
                                </span>
                            </td>
                            <td>{{ $s->kunjungan_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada jadwal untuk Anda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection
