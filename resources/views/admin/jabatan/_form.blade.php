<div class="mb-3">
    <label class="form-label">Nama Jabatan</label>
    <input type="text" name="nama_jabatan"
           class="form-control @error('nama_jabatan') is-invalid @enderror"
           value="{{ old('nama_jabatan', $jabatan->nama_jabatan ?? '') }}"
           maxlength="100" autofocus>
    @error('nama_jabatan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.jabatan.index') }}" class="btn btn-secondary">Batal</a>