@extends('layouts.app')

@section('title', 'Tambah Jabatan Pegawai')

@section('content')
    <h3 class="mb-3">Tambah Jabatan Pegawai</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.jabatan-penduduk.store') }}">
            @csrf
            @include('admin.jabatan_penduduk._form')
        </form>
    </div></div>
@endsection