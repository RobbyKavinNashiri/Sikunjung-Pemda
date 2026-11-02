@php
    $k     = $item ?? null;
    $idJp  = old('id_jabatan_penduduk', $k->id_jabatan_penduduk ?? '');
    $awal  = old('tanggal_awal', $k ? $k->tanggal_awal->format('Y-m-d') : '');
    $akhir = old('tanggal_akhir', $k ? $k->tanggal_akhir->format('Y-m-d') : '');
    $nama  = old('kegiatan', $k->kegiatan ?? '');
@endphp

@if ($daftarJp->isEmpty())
    <div class="alert alert-warning">Anda belum memegang jabatan aktif. Hubungi admin untuk menambahkannya.</div>
@endif

<div class="mb-3">
    <label class="form-label">Jabatan</label>
    <select name="id_jabatan_penduduk" class="form-select @error('id_jabatan_penduduk') is-invalid @enderror">
        <option value="">-- Pilih jabatan --</option>
        @foreach ($daftarJp as $jp)
            <option value="{{ $jp->id_jabatan_penduduk }}" @selected((string) $idJp === (string) $jp->id_jabatan_penduduk)>
                {{ $jp->jabatan?->nama_jabatan }}
            </option>
        @endforeach
    </select>
    @error('id_jabatan_penduduk') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Tanggal mulai</label>
        <input type="date" name="tanggal_awal" value="{{ $awal }}"
               class="form-control @error('tanggal_awal') is-invalid @enderror">
        @error('tanggal_awal') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Tanggal selesai</label>
        <input type="date" name="tanggal_akhir" value="{{ $akhir }}"
               class="form-control @error('tanggal_akhir') is-invalid @enderror">
        @error('tanggal_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Kegiatan</label>
    <input type="text" name="kegiatan" maxlength="255" value="{{ $nama }}"
           class="form-control @error('kegiatan') is-invalid @enderror"
           placeholder="Contoh: Rapat koordinasi di provinsi">
    @error('kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('penduduk.kegiatan.index') }}" class="btn btn-secondary">Batal</a>
