@php
    $idJabatan  = old('id_jabatan', $jp->id_jabatan ?? '');
    $idPenduduk = old('id_penduduk', $jp->id_penduduk ?? '');
    $status     = old('status', $jp->status ?? 'Y');
@endphp

<div class="mb-3">
    <label class="form-label">Jabatan</label>
    <select name="id_jabatan" class="form-select @error('id_jabatan') is-invalid @enderror">
        <option value="">-- Pilih jabatan --</option>
        @foreach ($daftarJabatan as $j)
            <option value="{{ $j->id_jabatan }}" @selected((string) $idJabatan === (string) $j->id_jabatan)>
                {{ $j->nama_jabatan }}
            </option>
        @endforeach
    </select>
    @error('id_jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Pegawai</label>
    <select name="id_penduduk" class="form-select @error('id_penduduk') is-invalid @enderror">
        <option value="">-- Pilih pegawai --</option>
        @foreach ($daftarPenduduk as $p)
            <option value="{{ $p->id_penduduk }}" @selected((string) $idPenduduk === (string) $p->id_penduduk)>
                {{ $p->nama_penduduk }} ({{ $p->username }})
            </option>
        @endforeach
    </select>
    @error('id_penduduk') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="Y" @selected($status === 'Y')>Aktif</option>
        <option value="T" @selected($status === 'T')>Tidak aktif</option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.jabatan-penduduk.index') }}" class="btn btn-secondary">Batal</a>