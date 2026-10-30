<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

@php
    $penduduk = Auth::guard('penduduk')->user();
    $pemohon = Auth::guard('pemohon')->user();
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>

                @if ($penduduk && $penduduk->status === 'Admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.jabatan.index') }}">Jabatan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.penduduk.index') }}">Penduduk</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.jabatan-penduduk.index') }}">Jabatan Pegawai</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings-kunjungan.index') }}">Jadwal Kunjungan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings-kegiatan.index') }}">Kegiatan</a></li>
                @elseif ($penduduk)
                    <li class="nav-item"><a class="nav-link" href="{{ route('penduduk.dashboard') }}">Dashboard</a></li>
                @elseif ($pemohon)
                    <li class="nav-item"><a class="nav-link" href="{{ route('pemohon.dashboard') }}">Dashboard</a></li>
                @endif
            </ul>

            <ul class="navbar-nav">
                @if ($penduduk || $pemohon)
                    <li class="nav-item"><span class="navbar-text me-3">
                        {{ $penduduk ? $penduduk->nama_penduduk : $pemohon->nama }}
                    </span></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Keluar</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @include('partials.flash')
    @include('partials.errors')
    @yield('content')
</main>

<footer class="text-center text-muted py-3 border-top">
    &copy; {{ date('Y') }} {{ config('app.name') }}
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
