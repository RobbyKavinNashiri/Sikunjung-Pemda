@extends('layouts.app')

@section('title', 'Struktur Jabatan')

@section('content')
    <h3 class="mb-1">Struktur Jabatan</h3>
    <p class="text-muted">Daftar jabatan beserta pejabat yang sedang memegangnya.</p>

    <div class="row g-3">
        @forelse ($daftar as $j)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $j->nama_jabatan }}</h5>
                        @forelse ($j->jabatanPenduduk as $jp)
                            <div>{{ $jp->penduduk?->nama_penduduk }}</div>
                        @empty
                            <div class="text-muted fst-italic">Belum ada pemegang jabatan.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-secondary">Belum ada data jabatan.</div></div>
        @endforelse
    </div>
@endsection
