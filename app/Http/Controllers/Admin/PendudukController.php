<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');

        $daftar = Penduduk::query()
            ->when($cari, function ($query) use ($cari) {
                $query->where(function ($q) use ($cari) {
                    $q->where('nama_penduduk', 'like', "%{$cari}%")
                      ->orWhere('username', 'like', "%{$cari}%")
                      ->orWhere('nik', 'like', "%{$cari}%");
                });
            })
            ->orderBy('nama_penduduk')
            ->paginate(10)
            ->withQueryString();

        return view('admin.penduduk.index', compact('daftar', 'cari'));
    }

    public function create()
    {
        return view('admin.penduduk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            $this->aturan(),
            $this->pesan()
        );

        Penduduk::create($data);

        return redirect()->route('admin.penduduk.index')
            ->with('sukses', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $data = $request->validate(
            $this->aturan($penduduk),
            $this->pesan()
        );

        // Admin tidak boleh menurunkan statusnya sendiri
        if ($penduduk->id_penduduk === Auth::guard('penduduk')->id() && $data['status'] !== 'Admin') {
            return back()->withInput()
                ->with('error', 'Anda tidak bisa mengubah status akun Anda sendiri.');
        }

        // Password kosong = tidak diganti
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $penduduk->update($data);

        return redirect()->route('admin.penduduk.index')
            ->with('sukses', 'Data penduduk berhasil diubah.');
    }

    public function destroy(Penduduk $penduduk)
    {
        if ($penduduk->id_penduduk === Auth::guard('penduduk')->id()) {
            return redirect()->route('admin.penduduk.index')
                ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        if ($penduduk->jabatanPenduduk()->exists()) {
            return redirect()->route('admin.penduduk.index')
                ->with('error', 'Penduduk tidak bisa dihapus karena masih memiliki data jabatan.');
        }

        $penduduk->delete();

        return redirect()->route('admin.penduduk.index')
            ->with('sukses', 'Data penduduk berhasil dihapus.');
    }

    private function aturan(?Penduduk $penduduk = null): array
    {
        $id = $penduduk?->id_penduduk;
        $adaPassword = $penduduk ? 'nullable' : 'required';

        return [
            'nama_penduduk' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'digits:16', Rule::unique('penduduk', 'nik')->ignore($id, 'id_penduduk')],
            'kk' => ['required', 'digits:16'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'alamat' => ['required', 'string', 'max:255'],
            'username' => ['required', 'alpha_dash', 'max:255', Rule::unique('penduduk', 'username')->ignore($id, 'id_penduduk')],
            'password' => [$adaPassword, 'string', 'min:6', 'confirmed'],
            'status' => ['required', Rule::in(['Admin', 'Penduduk'])],
        ];
    }

    private function pesan(): array
    {
        return [
            'nama_penduduk.required' => 'Nama wajib diisi.',
            'nama_penduduk.max' => 'Nama maksimal 100 karakter.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'kk.required' => 'Nomor KK wajib diisi.',
            'kk.digits' => 'Nomor KK harus 16 digit angka.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, strip, dan garis bawah.',
            'username.unique' => 'Username sudah dipakai.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}