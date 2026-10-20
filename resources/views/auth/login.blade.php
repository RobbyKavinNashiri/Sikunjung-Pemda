@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h5 class="mb-3">Masuk</h5>

    <form method="POST" action="{{ route('login.proses') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Username / Email</label>
            <input type="text" name="login" class="form-control" value="{{ old('login') }}" autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>

    <p class="text-center mt-3 mb-0">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai pemohon</a>
    </p>
@endsection