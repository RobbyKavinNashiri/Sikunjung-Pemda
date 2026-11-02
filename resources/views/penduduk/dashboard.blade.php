@extends('layouts.app')

@section('title', 'Dashboard Pejabat')

@section('content')
    <h3 class="mb-1">Dashboard Pejabat</h3>
    <p class="text-muted">
        Jabatan:
        @forelse ($jabatanSaya as $jp)
            <span class="badge bg-primary">{{ $jp->jabatan?->nama_jabatan }}</span>
        @empty
            <span class="badge bg-secondary">Belum memegang jabatan aktif</span>
        @endforelse
    </p>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg">
            <div class="card text-center h-100"><div class="card-body">
                <div class="fs-2 fw-bold text-warning">{{ $statistik['belum'] }}</div>
                <div class="text-muted">Menunggu keputusan saya</div>
            </div></div>
        </div>
        <div class="col-6 col-lg">
            <div class="card text-center h-100"><div class="card-body">
                <div class="fs-2 fw-bold text-success">{{ $statistik['setuju'] }}</div>
                <div class="text-muted">Saya setujui</div>
            </div></div>
        </div>
        <div class="col-6 col-lg">
            <div class="card text-center h-100"><div class="card-body">
                <div class="fs-2 fw-bold text-danger">{{ $statistik['tolak'] }}</div>
                <div class="text-muted">Saya tolak</div>
            </div></div>
        </div>
        <div class="col-6 col-lg">
            <div class="card text-center h-100"><div class="card-body">
                <div class="fs-2 fw-bold">{{ $statistik['jadwal'] }}</div>
                <div class="text-muted">Jadwal mendatang</div>
            </div></div>
        </div>
        <div class="col-6 col-lg">
            <div class="card text-center h-100"><div class="card-body">
                <div class="fs-2 fw-bold">{{ $statistik['kegiatan'] }}</div>
                <div class="text-muted">Kegiatan mendatang</div>
            </div></div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold d-flex justify-content-between">
            <span>Pengajuan yang menunggu keputusan saya</span>
            <a href="{{ route('penduduk.kunjungan.index') }}" class="small">Lihat semua</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Pemohon</th>
                        <th>Waktu Kunjungan</th>
                        <th>Tujuan</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menunggu as $k)
                        <tr>
                            <td>{{ $k->pemohon?->nama }}</td>
                            <td>{{ $k->tanggal_waktu->format('d-m-Y H:i') }}</td>
                            <td>{{ $k->tujuannya }}</td>
                            <td><a href="{{ route('penduduk.kunjungan.show', $k->id_kunjungan) }}" class="btn btn-sm btn-primary">Proses</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada pengajuan yang menunggu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
