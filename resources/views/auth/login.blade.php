<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    @if (session('sukses')) <p style="color:green">{{ session('sukses') }}</p> @endif
    @if (session('error')) <p style="color:red">{{ session('error') }}</p> @endif
    @error('login') <p style="color:red">{{ $message }}</p> @enderror
    @error('password') <p style="color:red">{{ $message }}</p> @enderror

    <form method="POST" action="{{ route('login.proses') }}">
        @csrf
        <p>
            <label>Username / Email</label><br>
            <input type="text" name="login" value="{{ old('login') }}">
        </p>
        <p>
            <label>Password</label><br>
            <input type="password" name="password">
        </p>
        <button type="submit">Masuk</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai pemohon</a></p>
</body>
</html>