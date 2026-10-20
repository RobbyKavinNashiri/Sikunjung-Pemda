@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
    <h5 class="mb-3">Daftar Pemohon</h5>

    <form method="POST" action="{{ route('register.proses') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Ulangi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>

    <p class="text-center mt-3 mb-0">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </p>
@endsection