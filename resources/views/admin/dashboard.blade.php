@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h3 class="mb-4">Dashboard Admin</h3>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-center"><div class="card-body">
                <div class="fs-2 fw-bold">{{ $jumlahJabatan }}</div>
                <div class="text-muted">Jabatan</div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card text-center"><div class="card-body">
                <div class="fs-2 fw-bold">{{ $jumlahPenduduk }}</div>
                <div class="text-muted">Penduduk</div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card text-center"><div class="card-body">
                <div class="fs-2 fw-bold">{{ $jumlahPemohon }}</div>
                <div class="text-muted">Pemohon</div>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card text-center"><div class="card-body">
                <div class="fs-2 fw-bold">{{ $jumlahKunjungan }}</div>
                <div class="text-muted">Total Kunjungan</div>
            </div></div>
        </div>
    </div>

    <div class="alert alert-warning mt-4 mb-0">
        Pengajuan yang menunggu konfirmasi admin: <strong>{{ $menunggu }}</strong>
    </div>
@endsection