@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Form Pengajuan Kunjungan Baru</div>
                <div class="card-body">

                    @if ($jadwal->isEmpty())
                        <div class="alert alert-warning mb-3">
                            Belum ada jadwal kunjungan yang tersedia. Silakan coba lagi nanti.
                        </div>
                    @endif

                    <form action="{{ route('pemohon.pengajuan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="id_settings_kunjungan" class="form-label">Jadwal Kunjungan</label>
                            <select name="id_settings_kunjungan" id="id_settings_kunjungan"
                                    class="form-select @error('id_settings_kunjungan') is-invalid @enderror" required>
                                <option value="">-- Pilih jadwal --</option>
                                @foreach ($jadwal as $j)
                                    <option value="{{ $j->id_settings_kunjungan }}"
                                        {{ old('id_settings_kunjungan') == $j->id_settings_kunjungan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d F Y') }}
                                        ({{ substr($j->jam_aktif, 0, 5) }}-{{ substr($j->jam_non_aktif, 0, 5) }})
                                        - {{ $j->nama_penduduk }}, {{ $j->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_settings_kunjungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jam" class="form-label">Jam Kunjungan</label>
                            <input type="time" name="jam" id="jam"
                                   class="form-control @error('jam') is-invalid @enderror"
                                   value="{{ old('jam') }}" required>
                            <div class="form-text">Pilih jam di dalam rentang jadwal yang dipilih.</div>
                            @error('jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tujuannya" class="form-label">Tujuan / Keperluan Kunjungan</label>
                            <textarea name="tujuannya" id="tujuannya" rows="4"
                                      class="form-control @error('tujuannya') is-invalid @enderror"
                                      placeholder="Jelaskan maksud dan tujuan kunjungan Anda..." required>{{ old('tujuannya') }}</textarea>
                            @error('tujuannya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pemohon.dashboard') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary" {{ $jadwal->isEmpty() ? 'disabled' : '' }}>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection