@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
        <h1 class="display-6">Layanan Kunjungan Pemda</h1>
        <p class="lead">Ajukan jadwal kunjungan ke pejabat secara online, tanpa antre dan tanpa repot.</p>
        @if (! Auth::guard('penduduk')->check() && ! Auth::guard('pemohon')->check())
            <a class="btn btn-primary" href="{{ route('register') }}">Daftar Sekarang</a>
            <a class="btn btn-outline-primary" href="{{ route('login') }}">Masuk</a>
        @endif
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100"><div class="card-body">
                <h5>1. Daftar</h5>
                <p class="mb-0">Buat akun pemohon dengan email dan nomor telepon.</p>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card h-100"><div class="card-body">
                <h5>2. Ajukan</h5>
                <p class="mb-0">Pilih jadwal yang tersedia dan isi tujuan kunjungan.</p>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card h-100"><div class="card-body">
                <h5>3. Tunggu Konfirmasi</h5>
                <p class="mb-0">Pantau status pengajuanmu di halaman riwayat.</p>
            </div></div>
        </div>
    </div>
@endsection