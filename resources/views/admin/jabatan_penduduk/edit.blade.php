@extends('layouts.app')

@section('title', 'Ubah Jabatan Pegawai')

@section('content')
    <h3 class="mb-3">Ubah Jabatan Pegawai</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.jabatan-penduduk.update', $jp) }}">
            @csrf
            @method('PUT')
            @include('admin.jabatan_penduduk._form')
        </form>
    </div></div>
@endsection