@php
    $s       = $item ?? null;
    $idJp    = old('id_jabatan_penduduk', $s->id_jabatan_penduduk ?? '');
    $tgl     = old('tanggal', $s ? $s->tanggal->format('Y-m-d') : '');
    $mulai   = old('jam_aktif', $s ? substr($s->jam_aktif, 0, 5) : '08:00');
    $selesai = old('jam_non_aktif', $s ? substr($s->jam_non_aktif, 0, 5) : '12:00');
    $status  = old('status', $s->status ?? 'Y');
@endphp

@if ($daftarJp->where('status', 'Y')->isEmpty())
    <div class="alert alert-warning">
        Belum ada pejabat aktif.
        <a href="{{ route('admin.jabatan-penduduk.create') }}">Tambah jabatan pegawai</a> terlebih dahulu.
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Pejabat</label>
    <select name="id_jabatan_penduduk" class="form-select @error('id_jabatan_penduduk') is-invalid @enderror">
        <option value="">-- Pilih pejabat --</option>
        @foreach ($daftarJp as $jp)
            <option value="{{ $jp->id_jabatan_penduduk }}"
                    @selected((string) $idJp === (string) $jp->id_jabatan_penduduk)
                    @disabled($jp->status !== 'Y')>
                {{ $jp->jabatan?->nama_jabatan }} - {{ $jp->penduduk?->nama_penduduk }}@if ($jp->status !== 'Y') (nonaktif)@endif
            </option>
        @endforeach
    </select>
    @error('id_jabatan_penduduk') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" value="{{ $tgl }}"
               class="form-control @error('tanggal') is-invalid @enderror">
        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Jam mulai</label>
        <input type="time" name="jam_aktif" value="{{ $mulai }}"
               class="form-control @error('jam_aktif') is-invalid @enderror">
        @error('jam_aktif') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Jam selesai</label>
        <input type="time" name="jam_non_aktif" value="{{ $selesai }}"
               class="form-control @error('jam_non_aktif') is-invalid @enderror">
        @error('jam_non_aktif') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="my-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="Y" @selected($status === 'Y')>Aktif (bisa diajukan)</option>
        <option value="T" @selected($status === 'T')>Tidak aktif</option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.settings-kunjungan.index') }}" class="btn btn-secondary">Batal</a>
