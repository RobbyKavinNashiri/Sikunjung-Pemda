@extends('layouts.app')

@section('title', 'Ubah Pengajuan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Ubah Pengajuan Kunjungan</h3>
        <a href="{{ route('pemohon.dashboard') }}" class="btn btn-outline-secondary">&larr; Kembali</a>
    </div>

    @php
        $idJadwal = old('id_settings_kunjungan', $item->id_settings_kunjungan);
        $tgl      = old('tanggal', $item->tanggal_waktu->format('Y-m-d'));
        $jam      = old('jam', $item->tanggal_waktu->format('H:i'));
        $tujuan   = old('tujuannya', $item->tujuannya);
    @endphp

    <div class="card shadow-sm"><div class="card-body">
        <p class="text-muted">Pengajuan hanya bisa diubah selama belum diproses admin maupun pejabat.</p>

        <form method="POST" action="{{ route('pemohon.pengajuan.update', $item->id_kunjungan) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Jadwal pejabat</label>
                <select name="id_settings_kunjungan" id="jadwal"
                        class="form-select @error('id_settings_kunjungan') is-invalid @enderror">
                    <option value="">-- Pilih jadwal --</option>
                    @foreach ($daftarJadwal as $j)
                        <option value="{{ $j->id_settings_kunjungan }}"
                                data-tanggal="{{ $j->tanggal->format('Y-m-d') }}"
                                data-mulai="{{ substr($j->jam_aktif, 0, 5) }}"
                                @selected((string) $idJadwal === (string) $j->id_settings_kunjungan)>
                            {{ $j->tanggal->format('d-m-Y') }},
                            {{ substr($j->jam_aktif, 0, 5) }}-{{ substr($j->jam_non_aktif, 0, 5) }}
                            | {{ $j->jabatanPenduduk?->jabatan?->nama_jabatan }}
                            ({{ $j->jabatanPenduduk?->penduduk?->nama_penduduk }})
                        </option>
                    @endforeach
                </select>
                @error('id_settings_kunjungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $tgl }}"
                           class="form-control @error('tanggal') is-invalid @enderror">
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jam kedatangan</label>
                    <input type="time" name="jam" id="jam" value="{{ $jam }}"
                           class="form-control @error('jam') is-invalid @enderror">
                    @error('jam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tujuan kunjungan</label>
                <input type="text" name="tujuannya" maxlength="255" value="{{ $tujuan }}"
                       class="form-control @error('tujuannya') is-invalid @enderror">
                @error('tujuannya') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('pemohon.dashboard') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div></div>

    <script>
        // Saat jadwal diganti, tanggal dan jam otomatis mengikuti jadwal tersebut.
        document.getElementById('jadwal').addEventListener('change', function () {
            var opsi = this.options[this.selectedIndex];
            if (opsi && opsi.dataset.tanggal) {
                document.getElementById('tanggal').value = opsi.dataset.tanggal;
                document.getElementById('jam').value = opsi.dataset.mulai;
            }
        });
    </script>
@endsection
