<?php

namespace App\Http\Controllers;

use App\Models\Pemohon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 1) Coba sebagai admin/penduduk (pakai username)
        if (Auth::guard('penduduk')->attempt([
            'username' => $data['login'],
            'password' => $data['password'],
        ])) {
            $request->session()->regenerate();

            $status = Auth::guard('penduduk')->user()->status;

            return redirect()->route($status === 'Admin' ? 'admin.dashboard' : 'penduduk.dashboard');
        }

        // 2) Coba sebagai pemohon (pakai email)
        if (Auth::guard('pemohon')->attempt([
            'email' => $data['login'],
            'password' => $data['password'],
        ])) {
            $request->session()->regenerate();

            return redirect()->route('pemohon.dashboard');
        }

        return back()
            ->withErrors(['login' => 'Username/email atau password salah.'])
            ->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'max:255', 'unique:pemohon,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.max' => 'Nomor telepon maksimal 15 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        Pemohon::create($data);

        return redirect()->route('login')->with('sukses', 'Pendaftaran berhasil. Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::guard('penduduk')->logout();
        Auth::guard('pemohon')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}