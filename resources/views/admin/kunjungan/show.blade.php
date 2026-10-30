@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
    @php $jp = $kunjungan->settingsKunjungan?->jabatanPenduduk; @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Detail Pengajuan</h3>
        <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header bg-white fw-bold">Data Pengajuan</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Pemohon</dt>
                        <dd class="col-sm-8">{{ $kunjungan->pemohon?->nama }}</dd>

                        <dt class="col-sm-4">Telepon</dt>
                        <dd class="col-sm-8">{{ $kunjungan->pemohon?->telepon }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $kunjungan->pemohon?->email }}</dd>

                        <dt class="col-sm-4">Pejabat dituju</dt>
                        <dd class="col-sm-8">
                            {{ $jp?->penduduk?->nama_penduduk }}
                            <span class="text-muted">({{ $jp?->jabatan?->nama_jabatan }})</span>
                        </dd>

                        <dt class="col-sm-4">Waktu kunjungan</dt>
                        <dd class="col-sm-8">{{ $kunjungan->tanggal_waktu->format('d-m-Y') }}, pukul {{ $kunjungan->tanggal_waktu->format('H:i') }}</dd>

                        <dt class="col-sm-4">Tujuan</dt>
                        <dd class="col-sm-8">{{ $kunjungan->tujuannya }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if ($kunjungan->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($kunjungan->status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card mb-3">
                <div class="card-header bg-white fw-bold">Konfirmasi Pejabat</div>
                <div class="card-body">
                    @if ($kunjungan->konfrimasi_penduduk === 'Y')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif ($kunjungan->konfrimasi_penduduk === 'T')
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <span class="badge bg-secondary">Belum diputuskan</span>
                    @endif
                    @if ($kunjungan->tanggal_waktu_penduduk)
                        <div class="small text-muted mt-1">{{ $kunjungan->tanggal_waktu_penduduk->format('d-m-Y H:i') }}</div>
                    @endif
                    @if ($kunjungan->catatan_penduduk)
                        <div class="mt-2">{{ $kunjungan->catatan_penduduk }}</div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white fw-bold">Keputusan Admin</div>
                <div class="card-body">
                    @if ($kunjungan->konfrimasi_admin)
                        <div class="mb-3">
                            Keputusan saat ini:
                            @if ($kunjungan->konfrimasi_admin === 'Y')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                            @if ($kunjungan->tanggal_waktu_admin)
                                <div class="small text-muted">{{ $kunjungan->tanggal_waktu_admin->format('d-m-Y H:i') }}</div>
                            @endif
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.kunjungan.update', $kunjungan) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="catatan_admin" class="form-label">Catatan</label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="3"
                                      class="form-control @error('catatan_admin') is-invalid @enderror"
                                      placeholder="Wajib diisi jika menolak">{{ old('catatan_admin', $kunjungan->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" name="keputusan" value="Y" class="btn btn-success">Setujui</button>
                            <button type="submit" name="keputusan" value="T" class="btn btn-danger">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection