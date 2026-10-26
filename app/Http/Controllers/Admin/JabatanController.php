<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JabatanController extends Controller
{
    // Menampilkan daftar jabatan
    public function index()
    {
        $daftar = Jabatan::orderBy('nama_jabatan')->paginate(10);

        return view('admin.jabatan.index', compact('daftar'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('admin.jabatan.create');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_jabatan' => ['required', 'string', 'max:100', 'unique:jabatan,nama_jabatan'],
        ], $this->pesan());

        Jabatan::create($data);

        return redirect()->route('admin.jabatan.index')
            ->with('sukses', 'Jabatan berhasil ditambahkan.');
    }

    // Menampilkan form ubah
    public function edit(Jabatan $jabatan)
    {
        return view('admin.jabatan.edit', compact('jabatan'));
    }

    // Menyimpan perubahan
    public function update(Request $request, Jabatan $jabatan)
    {
        $data = $request->validate([
            'nama_jabatan' => [
                'required', 'string', 'max:100',
                Rule::unique('jabatan', 'nama_jabatan')->ignore($jabatan->id_jabatan, 'id_jabatan'),
            ],
        ], $this->pesan());

        $jabatan->update($data);

        return redirect()->route('admin.jabatan.index')
            ->with('sukses', 'Jabatan berhasil diubah.');
    }

    // Menghapus data
    public function destroy(Jabatan $jabatan)
    {
        if ($jabatan->jabatanPenduduk()->exists()) {
            return redirect()->route('admin.jabatan.index')
                ->with('error', 'Jabatan tidak bisa dihapus karena masih dipakai oleh pegawai.');
        }

        $jabatan->delete();

        return redirect()->route('admin.jabatan.index')
            ->with('sukses', 'Jabatan berhasil dihapus.');
    }

    private function pesan(): array
    {
        return [
            'nama_jabatan.required' => 'Nama jabatan wajib diisi.',
            'nama_jabatan.max'      => 'Nama jabatan maksimal 100 karakter.',
            'nama_jabatan.unique'   => 'Nama jabatan sudah ada.',
        ];
    }
}