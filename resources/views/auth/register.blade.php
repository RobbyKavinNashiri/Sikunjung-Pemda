<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Pemohon</title>
</head>
<body>
    <h1>Daftar Pemohon</h1>

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $pesan)
                <li>{{ $pesan }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.proses') }}">
        @csrf
        <p><label>Nama</label><br>
            <input type="text" name="nama" value="{{ old('nama') }}"></p>
        <p><label>Telepon</label><br>
            <input type="text" name="telepon" value="{{ old('telepon') }}"></p>
        <p><label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}"></p>
        <p><label>Password</label><br>
            <input type="password" name="password"></p>
        <p><label>Ulangi Password</label><br>
            <input type="password" name="password_confirmation"></p>
        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
</body>
</html>