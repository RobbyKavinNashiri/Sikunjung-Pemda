@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Detail Pengajuan</h3>
        <a href="{{ route('penduduk.kunjungan.index') }}" class="btn btn-outline-secondary">&larr; Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Data Pengajuan</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Pemohon</dt>
                        <dd class="col-sm-8">{{ $kunjungan->pemohon?->nama }}</dd>

                        <dt class="col-sm-4">Telepon</dt>
                        <dd class="col-sm-8">{{ $kunjungan->pemohon?->telepon }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $kunjungan->pemohon?->email }}</dd>

                        <dt class="col-sm-4">Jabatan Tujuan</dt>
                        <dd class="col-sm-8">{{ $kunjungan->settingsKunjungan?->jabatanPenduduk?->jabatan?->nama_jabatan }}</dd>

                        <dt class="col-sm-4">Waktu Kunjungan</dt>
                        <dd class="col-sm-8">{{ $kunjungan->tanggal_waktu->format('d-m-Y H:i') }}</dd>

                        <dt class="col-sm-4">Tujuan</dt>
                        <dd class="col-sm-8">{{ $kunjungan->tujuannya }}</dd>

                        <dt class="col-sm-4">Status Akhir</dt>
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

            <div class="card shadow-sm mt-3">
                <div class="card-header bg-white fw-bold">Keputusan Admin</div>
                <div class="card-body">
                    @if ($kunjungan->konfrimasi_admin === 'Y')
                        <span class="badge bg-success">Setuju</span>
                    @elseif ($kunjungan->konfrimasi_admin === 'T')
                        <span class="badge bg-danger">Tolak</span>
                    @else
                        <span class="badge bg-secondary">Belum diputuskan</span>
                    @endif

                    @if ($kunjungan->tanggal_waktu_admin)
                        <span class="small text-muted ms-2">{{ $kunjungan->tanggal_waktu_admin->format('d-m-Y H:i') }}</span>
                    @endif

                    @if ($kunjungan->catatan_admin)
                        <div class="mt-2"><small class="text-muted">Catatan:</small> {{ $kunjungan->catatan_admin }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Keputusan Saya</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('penduduk.kunjungan.update', $kunjungan->id_kunjungan) }}">
                        @csrf
                        @method('PUT')

                        @php $pilihan = old('keputusan', $kunjungan->konfrimasi_penduduk); @endphp

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="keputusan" id="setuju" value="Y"
                                       @checked($pilihan === 'Y')>
                                <label class="form-check-label" for="setuju">Setujui</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="keputusan" id="tolak" value="T"
                                       @checked($pilihan === 'T')>
                                <label class="form-check-label" for="tolak">Tolak</label>
                            </div>
                            @error('keputusan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan <small class="text-muted">(wajib jika menolak)</small></label>
                            <textarea name="catatan_penduduk" rows="3" maxlength="255"
                                      class="form-control @error('catatan_penduduk') is-invalid @enderror">{{ old('catatan_penduduk', $kunjungan->catatan_penduduk) }}</textarea>
                            @error('catatan_penduduk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
                    </form>

                    @if ($kunjungan->tanggal_waktu_penduduk)
                        <div class="small text-muted mt-3">
                            Terakhir diputuskan: {{ $kunjungan->tanggal_waktu_penduduk->format('d-m-Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
