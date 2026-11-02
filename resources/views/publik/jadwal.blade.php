@extends('layouts.app')

@section('title', 'Jadwal Kunjungan')

@section('content')
    <h3 class="mb-1">Jadwal Kunjungan</h3>
    <p class="text-muted">Daftar jadwal pejabat yang masih dibuka. Untuk mengajukan kunjungan, silakan
        <a href="{{ route('login') }}">masuk</a> atau <a href="{{ route('register') }}">daftar</a> sebagai pemohon.</p>

    <form method="GET" action="{{ route('publik.jadwal') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="cari" value="{{ $cari }}" class="form-control" placeholder="Cari nama pejabat">
        </div>
        <div class="col-md-3">
            <select name="jabatan" class="form-select">
                <option value="">Semua jabatan</option>
                @foreach ($daftarJabatan as $j)
                    <option value="{{ $j->id_jabatan }}" @selected((string) $jabatan === (string) $j->id_jabatan)>{{ $j->nama_jabatan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
            @if ($cari || $jabatan || $tanggal)
                <a href="{{ route('publik.jadwal') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jabatan</th>
                        <th>Pejabat</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar as $s)
                        @php
                            $kegiatan = $s->jabatanPenduduk?->settingsKegiatan
                                ?->first(fn ($k) => $s->tanggal->between($k->tanggal_awal, $k->tanggal_akhir));
                        @endphp
                        <tr>
                            <td>{{ $s->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td>{{ substr($s->jam_aktif, 0, 5) }} - {{ substr($s->jam_non_aktif, 0, 5) }}</td>
                            <td>{{ $s->jabatanPenduduk?->jabatan?->nama_jabatan }}</td>
                            <td>{{ $s->jabatanPenduduk?->penduduk?->nama_penduduk }}</td>
                            <td>
                                @if ($kegiatan)
                                    <span class="badge bg-warning text-dark">Ada kegiatan: {{ $kegiatan->kegiatan }}</span>
                                @else
                                    <span class="badge bg-success">Tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada jadwal kunjungan yang cocok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $daftar->links() }}</div>
@endsection
