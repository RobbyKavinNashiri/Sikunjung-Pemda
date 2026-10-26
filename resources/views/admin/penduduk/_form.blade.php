<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_penduduk" maxlength="100"
               class="form-control @error('nama_penduduk') is-invalid @enderror"
               value="{{ old('nama_penduduk', $penduduk->nama_penduduk ?? '') }}">
        @error('nama_penduduk') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Jenis Kelamin</label>
        @php $jk = old('jenis_kelamin', $penduduk->jenis_kelamin ?? ''); @endphp
        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
            <option value="">-- Pilih --</option>
            <option value="L" @selected($jk === 'L')>Laki-laki</option>
            <option value="P" @selected($jk === 'P')>Perempuan</option>
        </select>
        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">NIK (16 digit)</label>
        <input type="text" name="nik" maxlength="16" inputmode="numeric"
               class="form-control @error('nik') is-invalid @enderror"
               value="{{ old('nik', $penduduk->nik ?? '') }}">
        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">No. KK (16 digit)</label>
        <input type="text" name="kk" maxlength="16" inputmode="numeric"
               class="form-control @error('kk') is-invalid @enderror"
               value="{{ old('kk', $penduduk->kk ?? '') }}">
        @error('kk') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Alamat</label>
        <input type="text" name="alamat" maxlength="255"
               class="form-control @error('alamat') is-invalid @enderror"
               value="{{ old('alamat', $penduduk->alamat ?? '') }}">
        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Username</label>
        <input type="text" name="username" maxlength="255" autocomplete="off"
               class="form-control @error('username') is-invalid @enderror"
               value="{{ old('username', $penduduk->username ?? '') }}">
        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Status Akun</label>
        @php $st = old('status', $penduduk->status ?? ''); @endphp
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            <option value="">-- Pilih --</option>
            <option value="Penduduk" @selected($st === 'Penduduk')>Penduduk</option>
            <option value="Admin" @selected($st === 'Admin')>Admin</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Password
            @isset($penduduk) <small class="text-muted">(kosongkan jika tidak diganti)</small> @endisset
        </label>
        <input type="password" name="password" autocomplete="new-password"
               class="form-control @error('password') is-invalid @enderror">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Ulangi Password</label>
        <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control">
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.penduduk.index') }}" class="btn btn-secondary">Batal</a>
</div>